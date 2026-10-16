<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SupportTicketController extends Controller
{
    public function index()
    {
        [$tickets, $error] = $this->loadTickets();

        return view('Support.tickets', compact('tickets', 'error'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject'     => 'required|string|max:255',
            'description' => 'required|string|max:3800',
            'priority'    => 'nullable|in:LOW,MEDIUM,HIGH,URGENT',
            'screenshots' => 'nullable|array|max:4',
            'screenshots.*' => 'file|mimes:jpg,jpeg,png,webp,gif|max:1536',
        ]);

        $key = config('services.tickets.key');
        $secret = config('services.tickets.secret');
        if (!$key || !$secret) {
            return response()->json([
                'success' => false,
                'message' => 'Ticket API key and secret are not set in .env.',
            ], 422);
        }

        $org = DB::table('mst_org')->first(['Org_Name', 'Print_Name', 'Admin_Mail', 'org_phone']);
        $orgName = $org->Print_Name ?? $org->Org_Name ?? 'Organization';
        $orgMail = trim((string) ($org->Admin_Mail ?? ''));
        $orgPhone = trim((string) ($org->org_phone ?? ''));

        if ($orgPhone === '') {
            return response()->json([
                'success' => false,
                'message' => 'Organization phone is not set.',
            ], 422);
        }

        $description = trim($request->description)
            . "\n\nOrganization email: " . ($orgMail !== '' ? $orgMail : '-')
            . "\nOrganization phone: " . $orgPhone;

        $payload = [
            'subject'       => $request->subject,
            'description'   => mb_substr($description, 0, 4000),
            'priority'      => $request->input('priority', 'MEDIUM'),
            'customerName'  => mb_substr($orgName, 0, 150),
            'customerPhone' => mb_substr($orgPhone, 0, 30),
        ];

        $screenshots = [];
        foreach ($request->file('screenshots', []) as $file) {
            $screenshots[] = [
                'name' => $file->getClientOriginalName(),
                'data' => base64_encode(file_get_contents($file->getRealPath())),
            ];
        }
        if ($screenshots) {
            $payload['screenshots'] = $screenshots;
        }

        try {
            $response = Http::timeout(30)
                ->withHeaders([
                    'X-Api-Key'    => $key,
                    'X-Api-Secret' => $secret,
                    'Accept'       => 'application/json',
                ])
                ->post($this->endpoint('/integrations/tickets'), $payload);

            $body = $response->json() ?? [];
            if (!$response->successful() || empty($body['success'])) {
                return response()->json([
                    'success' => false,
                    'message' => $body['message'] ?? 'Could not create the complaint.',
                ], $response->status() ?: 500);
            }

            $token = $body['data']['accessToken'] ?? null;
            if ($token) {
                Cache::put('support_ticket_client', [
                    'token' => $token,
                    'phone' => $payload['customerPhone'],
                ], now()->addDays(30));
            }

            return response()->json([
                'success' => true,
                'message' => $body['message'] ?? 'Ticket created.',
                'number'  => $body['data']['number'] ?? null,
            ]);
        } catch (\Exception $e) {
            Log::channel('internet')->error('Support ticket create error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Could not reach the ticket service.',
            ], 500);
        }
    }

    public function show(string $number)
    {
        if (!preg_match('/^TKT-\d+$/', $number)) {
            return response()->json(['success' => false, 'message' => 'Ticket not found.'], 404);
        }

        $key = config('services.tickets.key');
        $secret = config('services.tickets.secret');
        if (!$key || !$secret) {
            return response()->json([
                'success' => false,
                'message' => 'Ticket API key and secret are not set in .env.',
            ], 422);
        }

        try {
            $response = Http::timeout(20)
                ->withHeaders([
                    'X-Api-Key'    => $key,
                    'X-Api-Secret' => $secret,
                    'Accept'       => 'application/json',
                ])
                ->get($this->endpoint('/integrations/tickets/' . $number));

            $body = $response->json() ?? [];
            if (!$response->successful() || empty($body['success'])) {
                return response()->json([
                    'success' => false,
                    'message' => $body['message'] ?? 'Could not load this complaint.',
                ], $response->status() ?: 500);
            }

            return response()->json([
                'success' => true,
                'ticket'  => $body['data'] ?? [],
            ]);
        } catch (\Exception $e) {
            Log::channel('internet')->error('Support ticket show error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Could not reach the ticket service.',
            ], 500);
        }
    }

    private function loadTickets(): array
    {
        $cached = Cache::get('support_ticket_client');
        $key = config('services.tickets.key');

        if (!$cached || empty($cached['token']) || empty($cached['phone']) || !$key) {
            return [[], null];
        }

        try {
            $response = Http::timeout(20)
                ->withHeaders([
                    'X-Api-Key'       => $key,
                    'X-Client-Token'  => $cached['token'],
                    'Accept'          => 'application/json',
                ])
                ->get($this->endpoint('/integrations/redirect/tickets'), [
                    'phone' => $cached['phone'],
                ]);

            $body = $response->json() ?? [];
            if ($response->status() === 401) {
                Cache::forget('support_ticket_client');
                return [[], $body['message'] ?? 'Ticket access expired. Add a complaint again to refresh the list.'];
            }

            if (!$response->successful() || empty($body['success'])) {
                return [[], $body['message'] ?? 'Could not load complaints.'];
            }

            return [$body['data'] ?? [], null];
        } catch (\Exception $e) {
            Log::channel('internet')->error('Support ticket list error: ' . $e->getMessage());
            return [[], 'Could not reach the ticket service.'];
        }
    }

    private function endpoint(string $path): string
    {
        return rtrim((string) config('services.tickets.url'), '/') . $path;
    }
}
