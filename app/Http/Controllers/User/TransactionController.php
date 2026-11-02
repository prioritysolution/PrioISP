<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $payModes = DB::select('CALL usp_getPayMode(?)', [0]);
        $org      = DB::select('CALL usp_getOrganization()')[0] ?? null;
        $isAdmin  = session('is_admin') == 1;
        $searchRoute  = $isAdmin ? 'admin.demand.search'  : 'demand.search';
        $collectRoute = $isAdmin ? 'admin.demand.collect' : 'demand.collect';
        return view('User.demand-collection', compact('payModes', 'org', 'searchRoute', 'collectRoute'));
    }

    public function search(Request $request)
    {
        try {
            $result = DB::select('CALL usp_searchDemandCustomer(?,?,?,?)', [
                $request->filled('account') ? $request->account : null,
                $request->filled('userid')  ? $request->userid  : null,
                $request->filled('code')    ? $request->code    : null,
                $request->filled('name')    ? $request->name    : null,
            ]);

            if (empty($result)) {
                return response()->json(['success' => false, 'message' => 'No customer found.']);
            }

            if (isset($result[0]->Error_No)) {
                if ((int) $result[0]->Error_No === 0) {
                    $customer = $this->findSearchedCustomer($request);
                    if ($customer) {
                        if (!$this->customerHasGeneratedDemand((int) $customer->Cust_Id)) {
                            return response()->json([
                                'success' => false,
                                'message' => 'Generate a demand for this customer before opening payment collection.',
                            ]);
                        }

                        return response()->json([
                            'success'  => true,
                            'demands'  => [],
                            'customer' => [
                                'Cust_Id'   => $customer->Cust_Id,
                                'Cust_Name' => $customer->Cust_Name,
                            ],
                            'advance'  => (float) ($customer->Advance_Amt ?? 0),
                            'has_plan' => !empty($customer->Package_Id),
                            'message'  => $result[0]->Message,
                        ]);
                    }
                }

                return response()->json(['success' => false, 'message' => $result[0]->Message]);
            }

            $customer = DB::table('mst_customer')->where('Cust_Id', $result[0]->Cust_Id)->first();

            return response()->json([
                'success'  => true,
                'demands'  => $result,
                'advance'  => (float) ($customer->Advance_Amt ?? 0),
                'has_plan' => !empty($customer->Package_Id),
            ]);
        } catch (\Exception $e) {
            Log::channel('internet')->error('Demand search error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Something went wrong.'], 500);
        }
    }

    public function collect(Request $request)
    {
        $request->validate([
            'Renewal_Ids'    => 'nullable|string',
            'Cust_Id'        => 'required|integer',
            'Receipt_Date'   => 'required|date',
            'Discount'       => 'nullable|numeric|min:0',
            'Extra_Amt'      => 'nullable|numeric|min:0',
            'Advance_Amt'    => 'nullable|numeric|min:0',
            'Net_Amt'        => 'required|numeric',
            'Payment_Lines'  => 'required|string',
        ]);

        $lines = json_decode($request->Payment_Lines, true);
        if (!is_array($lines) || count($lines) < 1) {
            return response()->json(['success' => false, 'message' => 'Add at least one payment mode.']);
        }

        $normalized = [];
        $linesSum   = 0.0;
        $modes      = DB::table('mst_mode')->pluck('Mode', 'Mode_Id');

        foreach ($lines as $line) {
            $modeId = (int) ($line['mode_id'] ?? 0);
            $amt    = round((float) ($line['amt'] ?? 0), 2);
            $txn    = trim((string) ($line['txn'] ?? ''));
            $modeName = $modes[$modeId] ?? null;

            if (!$modeId || $amt <= 0) {
                return response()->json(['success' => false, 'message' => 'Each payment line needs a mode and amount > 0.']);
            }
            if (strlen($txn) > 30) {
                return response()->json(['success' => false, 'message' => 'Transaction ID can be at most 30 characters.']);
            }
            if (!$modeName || strcasecmp($modeName, 'Cash') === 0) {
                $txn = '';
            }

            $normalized[] = [
                'mode_id' => $modeId,
                'amt'     => $amt,
                'txn'     => $txn,
            ];
            $linesSum += $amt;
        }

        $extra      = round(max(0, (float) ($request->Extra_Amt ?? 0)), 2);
        $advance    = round(max(0, (float) ($request->Advance_Amt ?? 0)), 2);
        $discount   = round(max(0, (float) ($request->Discount ?? 0)), 2);
        $renewalIds = array_values(array_filter(array_map('trim', explode(',', (string) $request->Renewal_Ids))));

        if ($renewalIds === [] && !$this->customerHasGeneratedDemand((int) $request->Cust_Id)) {
            return response()->json([
                'success' => false,
                'message' => 'Generate a demand for this customer before collecting payment.',
            ]);
        }

        if ($extra > 0) {
            $packageId = DB::table('mst_customer')->where('Cust_Id', $request->Cust_Id)->value('Package_Id');
            if (empty($packageId)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Extra amount cannot be collected. This customer has no plan.',
                ]);
            }
        }

        if ($renewalIds === [] && $advance <= 0 && $extra <= 0) {
            return response()->json(['success' => false, 'message' => 'Enter an extra amount or an advance amount.']);
        }

        $dueSum = 0.0;
        if ($renewalIds !== []) {
            $dueSum = round((float) DB::table('trans_renewal')->whereIn('Renewal_Id', $renewalIds)->sum('Due_Amt'), 2);
        }
        $discountBase = $renewalIds === [] ? $extra : $dueSum;
        if ($discount - $discountBase > 0.05) {
            return response()->json(['success' => false, 'message' => 'Discount cannot be more than the amount being collected.']);
        }

        $billNet = $renewalIds === []
            ? round($extra - $discount, 2)
            : round($dueSum - $discount + $extra, 2);
        $payNet  = round($billNet + $advance, 2);
        if (abs($linesSum - $payNet) > 0.05) {
            return response()->json([
                'success' => false,
                'message' => 'Payment modes total (₹ ' . number_format($linesSum, 2) . ') must equal net amount (₹ ' . number_format($payNet, 2) . ').',
            ]);
        }

        [$billLines, $advanceLines] = $this->splitPaymentLines($normalized, $billNet);
        $primaryMode = $billLines[0]['mode_id'] ?? $normalized[0]['mode_id'];
        $primaryTxn  = ($billLines[0]['txn'] ?? $normalized[0]['txn']) !== '' ? ($billLines[0]['txn'] ?? $normalized[0]['txn']) : null;
        $paymentJson = json_encode($billLines);
        $netAmt      = $billNet;

        $extraApplied = false;
        $createdExtraId = null;

        try {
            if ($extra > 0 && $renewalIds === []) {
                $createdExtraId = $this->createExtraRenewal((int) $request->Cust_Id, $extra, $request->Receipt_Date);
                $renewalIds = [(string) $createdExtraId];
            } elseif ($extra > 0) {
                $this->addExtraCharge((int) $renewalIds[0], (int) $request->Cust_Id, $extra);
                $extraApplied = true;
            }

            $receiptData = null;
            $message = 'Payment collected successfully.';

            if ($billNet > 0) {
                $pdo  = DB::getPdo();
                $stmt = $pdo->prepare('CALL usp_collectPayment(?,?,?,?,?,?,?,?,?,?)');
                $stmt->execute([
                    implode(',', $renewalIds),
                    $request->Cust_Id,
                    $request->Receipt_Date,
                    $primaryMode,
                    $discount,
                    $netAmt,
                    session('user_id'),
                    session('is_admin') == 1 ? null : session('counter_id'),
                    $primaryTxn,
                    $paymentJson,
                ]);

                $first = $stmt->fetchAll(\PDO::FETCH_OBJ);

                if (!empty($first) && isset($first[0]->Error_No)) {
                    $this->undoExtra($extraApplied, $createdExtraId, $renewalIds, (int) $request->Cust_Id, $extra);
                    return response()->json(['success' => false, 'message' => $first[0]->Message]);
                }

                $renewals = $first;
                $stmt->nextRowset();
                $row = $stmt->fetch(\PDO::FETCH_OBJ);

                if (!$row || $row->Error_No < 0) {
                    $stmt->closeCursor();
                    $this->undoExtra($extraApplied, $createdExtraId, $renewalIds, (int) $request->Cust_Id, $extra);
                    return response()->json(['success' => false, 'message' => $row->Message ?? 'Failed to collect payment.']);
                }

                $stmt->closeCursor();
                $message = $row->Message;

                $receipt  = $renewals[0];
                $details  = [];
                $totalAmt = 0;
                $totalDisc = 0;

                $extraLeft = $extra;
                foreach ($renewals as $r) {
                    $lineAmt = round((float) $r->Receipt_Amt, 2);
                    if ($extraLeft > 0) {
                        $lineAmt = round($lineAmt - $extraLeft, 2);
                        $extraLeft = 0;
                    }
                    if ($lineAmt > 0.009) {
                        $details[] = 'Rs. ' . number_format($lineAmt, 2) . '/- against Renew '
                            . $r->Package_Name . ' package for '
                            . date('d/m/y', strtotime($r->Renew_From)) . ' to '
                            . date('d/m/y', strtotime($r->Renew_Upto));
                    }
                    $totalAmt  += $r->Receipt_Amt;
                    $totalDisc += $r->Disc_Amount ?? 0;
                }
                if ($extra > 0) {
                    $details[] = 'Rs. ' . number_format($extra, 2) . '/- extra amount against '
                        . ($receipt->Package_Name ?? 'current') . ' package for '
                        . date('d/m/y', strtotime($receipt->Renew_From)) . ' to '
                        . date('d/m/y', strtotime($receipt->Renew_Upto));
                }

                $receiptData = [
                    'receipt_no'   => $receipt->Receipt_No,
                    'date'         => date('d/m/y', strtotime($receipt->Receipt_Date)),
                    'cust_name'    => $receipt->Cust_Name,
                    'cust_code'    => $receipt->Cust_Code      ?? '-',
                    'address'      => $receipt->Billing_Address ?? '-',
                    'account_no'   => $receipt->Account_No,
                    'user_id'      => $receipt->User_Id,
                    'amount'       => $totalAmt,
                    'pay_mode'     => $receipt->Pay_Mode        ?? '-',
                    'txn_id'       => $receipt->Txn_Id          ?? '',
                    'package_name' => $receipt->Package_Name    ?? '-',
                    'period'       => implode(', ', $details),
                    'discount'     => number_format($totalDisc, 2),
                ];
            }

            if ($advance > 0) {
                $receiptNo = $receiptData['receipt_no'] ?? $this->nextAdvanceReceipt($request->Receipt_Date);
                $this->storeAdvance(
                    (int) $request->Cust_Id,
                    $receiptNo,
                    $request->Receipt_Date,
                    $advance,
                    $advanceLines,
                    session('is_admin') == 1 ? null : session('counter_id'),
                    session('user_id')
                );
                $message = $billNet > 0
                    ? $message . ' Advance of ₹ ' . number_format($advance, 2) . ' kept.'
                    : 'Advance of ₹ ' . number_format($advance, 2) . ' collected.';

                if (!$receiptData) {
                    $customer = DB::table('mst_customer')->where('Cust_Id', $request->Cust_Id)->first();
                    $receiptData = [
                        'receipt_no'   => $receiptNo,
                        'date'         => date('d/m/y', strtotime($request->Receipt_Date)),
                        'cust_name'    => $customer->Cust_Name ?? '-',
                        'cust_code'    => $customer->Cust_Code ?? '-',
                        'address'      => $customer->Billing_Address ?? '-',
                        'account_no'   => $customer->Account_No ?? '-',
                        'user_id'      => $customer->User_Id ?? '-',
                        'amount'       => 0,
                        'pay_mode'     => '',
                        'txn_id'       => '',
                        'package_name' => $customer ? (DB::table('mst_package')->where('Package_Id', $customer->Package_Id)->value('Package_Name') ?? '-') : '-',
                        'period'       => 'Advance against ' . ($customer ? (DB::table('mst_package')->where('Package_Id', $customer->Package_Id)->value('Package_Name') ?? 'current plan') : 'current plan')
                            . ' for '
                            . ($customer && $customer->Renew_From ? date('d/m/y', strtotime($customer->Renew_From)) : '-')
                            . ' to '
                            . ($customer && $customer->Renew_Upto ? date('d/m/y', strtotime($customer->Renew_Upto)) : '-'),
                        'discount'     => '0.00',
                    ];
                } else {
                    $receiptData['period'] .= ', Advance Rs. ' . number_format($advance, 2) . '/- against '
                        . ($receiptData['package_name'] ?? 'current plan');
                }

                $modeNames = DB::table('mst_mode')->pluck('Mode', 'Mode_Id');
                $payModes = array_filter(array_map('trim', explode(',', (string) ($receiptData['pay_mode'] ?? ''))));
                foreach ($advanceLines as $line) {
                    $payModes[] = $modeNames[$line['mode_id']] ?? 'Payment';
                }
                $receiptData['pay_mode'] = implode(', ', array_values(array_unique($payModes)));
                $receiptData['amount'] = round(((float) $receiptData['amount']) + $advance, 2);
            }

            $receiptData['amount_words'] = $this->numberToWords((float) $receiptData['amount']);
            $receiptData['amount'] = number_format((float) $receiptData['amount'], 2);

            return response()->json([
                'success' => true,
                'message' => $message,
                'receipt' => $receiptData,
            ]);
        } catch (\Exception $e) {
            $this->undoExtra($extraApplied, $createdExtraId, $renewalIds, (int) $request->Cust_Id, $extra);
            Log::channel('internet')->error('Demand collect error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to collect payment.'], 500);
        }
    }


    private function customerHasGeneratedDemand(int $custId): bool
    {
        return DB::table('trans_renewal')
            ->where('Cust_Id', $custId)
            ->where('Inv_No', 'not like', 'EXT-%')
            ->exists();
    }

    private function findSearchedCustomer(Request $request): ?object
    {
        $query = DB::table('mst_customer')->select('Cust_Id', 'Cust_Name', 'Cust_Code', 'Account_No', 'User_Id', 'Billing_Address', 'Package_Id', 'Advance_Amt');
        if ($request->filled('account')) {
            $query->where('Account_No', $request->account);
        }
        if ($request->filled('userid')) {
            $query->where('User_Id', $request->userid);
        }
        if ($request->filled('code')) {
            $query->where('Cust_Code', $request->code);
        }
        if ($request->filled('name')) {
            $query->where('Cust_Name', 'like', '%' . $request->name . '%');
        }

        return $query->first();
    }

    private function splitPaymentLines(array $lines, float $billNet): array
    {
        $billLines = [];
        $advanceLines = [];
        $remain = round($billNet, 2);

        foreach ($lines as $line) {
            $amt = round((float) $line['amt'], 2);
            if ($remain > 0.009) {
                $take = round(min($amt, $remain), 2);
                $billLines[] = ['mode_id' => $line['mode_id'], 'amt' => $take, 'txn' => $line['txn']];
                $remain = round($remain - $take, 2);
                $left = round($amt - $take, 2);
                if ($left > 0.009) {
                    $advanceLines[] = ['mode_id' => $line['mode_id'], 'amt' => $left, 'txn' => $line['txn']];
                }
            } else {
                $advanceLines[] = $line;
            }
        }

        return [$billLines, $advanceLines];
    }

    private function createExtraRenewal(int $custId, float $extra, string $receiptDate): int
    {
        $customer = DB::table('mst_customer')->where('Cust_Id', $custId)->first();
        if (!$customer || !$customer->Package_Id) {
            throw new \RuntimeException('Customer has no package for this extra amount.');
        }

        $from = $customer->Renew_From ?: $receiptDate;
        $upto = $customer->Renew_Upto ?: $receiptDate;

        return (int) DB::table('trans_renewal')->insertGetId([
            'Cust_Id'       => $custId,
            'Demand_Date'   => $receiptDate,
            'Inv_No'        => 'EXT-' . date('YmdHis'),
            'Plan_Id'       => $customer->Package_Id,
            'Renew_Mnth'    => 0,
            'Renew_From'    => $from,
            'Renew_Upto'    => $upto,
            'Renew_Amt'     => 0,
            'OTT_Amt'       => 0,
            'Extra_Amt'     => $extra,
            'GST_Amt'       => 0,
            'Total_Amount'  => $extra,
            'Pay_Status'    => 1,
            'Due_Amt'       => $extra,
            'Advance_Adj'   => 0,
            'Zone_Comm'     => 0,
            'Created_By'    => session('user_id'),
            'Created_On'    => now(),
        ]);
    }

    private function undoExtra(bool $extraApplied, ?int $createdExtraId, array $renewalIds, int $custId, float $extra): void
    {
        if ($createdExtraId) {
            DB::table('trans_renewal')->where('Renewal_Id', $createdExtraId)->where('Pay_Status', 1)->delete();
            return;
        }
        if ($extraApplied && isset($renewalIds[0])) {
            $this->reverseExtraCharge((int) $renewalIds[0], $custId, $extra);
        }
    }

    private function addExtraCharge(int $renewalId, int $custId, float $extra): void
    {
        DB::update(
            'UPDATE trans_renewal SET Total_Amount = Total_Amount + ?, Due_Amt = Due_Amt + ?, Extra_Amt = COALESCE(Extra_Amt, 0) + ? WHERE Renewal_Id = ?',
            [$extra, $extra, $extra, $renewalId]
        );
        DB::update(
            'UPDATE mst_customer SET Due_Amount = COALESCE(Due_Amount, 0) + ? WHERE Cust_Id = ?',
            [$extra, $custId]
        );
    }

    private function reverseExtraCharge(int $renewalId, int $custId, float $extra): void
    {
        DB::update(
            'UPDATE trans_renewal SET Total_Amount = Total_Amount - ?, Due_Amt = Due_Amt - ?, Extra_Amt = GREATEST(COALESCE(Extra_Amt, 0) - ?, 0) WHERE Renewal_Id = ?',
            [$extra, $extra, $extra, $renewalId]
        );
        DB::update(
            'UPDATE mst_customer SET Due_Amount = GREATEST(COALESCE(Due_Amount, 0) - ?, 0) WHERE Cust_Id = ?',
            [$extra, $custId]
        );
    }

    private function storeAdvance(int $custId, string $receiptNo, string $receiptDate, float $advance, array $lines, $counterId, $userId): void
    {
        $customer = DB::table('mst_customer')->where('Cust_Id', $custId)->first();
        foreach ($lines as $line) {
            DB::table('trans_advance')->insert([
                'Cust_Id'      => $custId,
                'Receipt_No'   => $receiptNo,
                'Receipt_Date' => $receiptDate,
                'Amount'       => $line['amt'],
                'Mode_Id'      => $line['mode_id'],
                'Txn_Id'       => $line['txn'] !== '' ? $line['txn'] : null,
                'Counter_Id'   => $counterId,
                'Plan_Id'      => $customer->Package_Id ?? null,
                'Renew_From'   => $customer->Renew_From ?? null,
                'Renew_Upto'   => $customer->Renew_Upto ?? null,
                'Remarks'      => 'Advance against current plan',
                'Created_By'   => $userId,
                'Created_On'   => now(),
            ]);
        }
        DB::update(
            'UPDATE mst_customer SET Advance_Amt = COALESCE(Advance_Amt, 0) + ? WHERE Cust_Id = ?',
            [$advance, $custId]
        );
    }

    private function nextAdvanceReceipt(string $date): string
    {
        $prefix = 'ADV-' . date('Ym', strtotime($date)) . '-';
        $last = DB::table('trans_advance')
            ->where('Receipt_No', 'like', $prefix . '%')
            ->orderByDesc('Advance_Id')
            ->value('Receipt_No');
        $seq = 0;
        if (is_string($last) && str_starts_with($last, $prefix)) {
            $seq = (int) substr($last, strlen($prefix));
        }

        return $prefix . str_pad((string) ($seq + 1), 4, '0', STR_PAD_LEFT);
    }

    private function numberToWords(float $amount): string
    {
        $ones = [
            '',
            'One',
            'Two',
            'Three',
            'Four',
            'Five',
            'Six',
            'Seven',
            'Eight',
            'Nine',
            'Ten',
            'Eleven',
            'Twelve',
            'Thirteen',
            'Fourteen',
            'Fifteen',
            'Sixteen',
            'Seventeen',
            'Eighteen',
            'Nineteen'
        ];
        $tens = ['', '', 'Twenty', 'Thirty', 'Forty', 'Fifty', 'Sixty', 'Seventy', 'Eighty', 'Ninety'];

        $n     = (int) $amount;
        $paise = round(($amount - $n) * 100);

        $convert = function (int $n) use (&$convert, $ones, $tens): string {
            if ($n < 20)       return $ones[$n];
            if ($n < 100)      return $tens[(int)($n / 10)] . ($n % 10 ? ' ' . $ones[$n % 10] : '');
            if ($n < 1000)     return $ones[(int)($n / 100)] . ' Hundred' . ($n % 100 ? ' ' . $convert($n % 100) : '');
            if ($n < 100000)   return $convert((int)($n / 1000)) . ' Thousand' . ($n % 1000 ? ' ' . $convert($n % 1000) : '');
            if ($n < 10000000) return $convert((int)($n / 100000)) . ' Lakh' . ($n % 100000 ? ' ' . $convert($n % 100000) : '');
            return $convert((int)($n / 10000000)) . ' Crore' . ($n % 10000000 ? ' ' . $convert($n % 10000000) : '');
        };

        $words = $convert($n) . ' Rupees';
        if ($paise > 0) $words .= ' and ' . $convert($paise) . ' Paise';
        return $words . ' Only';
    }




    public function billPrint()
    {
        $org = DB::select('CALL usp_getOrganization()')[0] ?? null;
        return view('User.bill-print', compact('org'));
    }

    public function billPrintSearch(Request $request)
    {
        try {
            $result = DB::select('CALL usp_getLastBill(?, ?, ?, ?)', [
                $request->filled('account') ? $request->account : null,
                $request->filled('userid')  ? $request->userid  : null,
                $request->filled('code')    ? $request->code    : null,
                session('counter_id'),
            ]);

            if (empty($result)) {
                return response()->json(['success' => false, 'message' => 'No paid bill found for this customer.']);
            }

            $r = $result[0];
            return response()->json([
                'success' => true,
                'bill' => [
                    'receipt_no'   => $r->Receipt_No,
                    'date'         => date('d/m/y', strtotime($r->Receipt_Date)),
                    'cust_name'    => $r->Cust_Name,
                    'cust_code'    => $r->Cust_Code,
                    'address'      => $r->Billing_Address,
                    'account_no'   => $r->Account_No,
                    'user_id'      => $r->User_Id,
                    'amount'       => number_format($r->Receipt_Amt, 2),
                    'amount_words' => $this->numberToWords($r->Receipt_Amt),
                    'package_name' => $r->Package_Name,
                    'extra_amt'    => number_format($r->Extra_Amt ?? 0, 2),
                    'renew_from'   => date('d/m/y', strtotime($r->Renew_From)),
                    'renew_upto'   => date('d/m/y', strtotime($r->Renew_Upto)),
                    'pay_mode'     => $r->Pay_Mode,
                    'txn_id'       => $r->Txn_Id ?? '',
                    'period'       => date('d/m/y', strtotime($r->Renew_From)) . ' to ' . date('d/m/y', strtotime($r->Renew_Upto)),
                    'discount'     => number_format($r->Disc_Amount ?? 0, 2),
                ]
            ]);
        } catch (\Exception $e) {
            Log::channel('internet')->error('Bill print error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Something went wrong.'], 500);
        }
    }
}
