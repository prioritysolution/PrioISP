<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Mail\DemandGeneratedMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class GenerateDemandController extends Controller
{
    public function index(Request $request)
    {
        $packages   = DB::select('CALL usp_getPackage(?,?)',[0,0]);
        $isAdmin    = session('is_admin') == 1;
        $searchRoute  = $isAdmin ? 'admin.generate.demand.search' : 'generate.demand.search';
        $storeRoute   = $isAdmin ? 'admin.generate.demand.store'  : 'generate.demand.store';
        return view('User.generate-demand', compact('packages', 'searchRoute', 'storeRoute','isAdmin'));
    }


    public function search(Request $request)
    {
        try {
            $customerQuery = DB::table('mst_customer as c')
                ->join('mst_package as p', 'p.Package_Id', '=', 'c.Package_Id')
                ->whereIn('c.Status', [1, 2])
                ->select(
                    'c.Cust_Id',
                    'c.Cust_Code',
                    'c.Cust_Name',
                    'c.Account_No',
                    'c.User_Id',
                    'c.Contact_No',
                    'c.Renew_From',
                    'c.Renew_Upto',
                    'c.Due_Amount',
                    'c.Status',
                    'c.Advance_Amt',
                    'p.Package_Name',
                    'p.Basic_Amt',
                    'p.Total_Amt',
                    'p.Plan_Days'
                );

            if ($request->filled('account')) {
                $customerQuery->where('c.Account_No', 'like', '%' . $request->account . '%');
            }
            if ($request->filled('userid')) {
                $customerQuery->where('c.User_Id', 'like', '%' . $request->userid . '%');
            }
            if ($request->filled('code')) {
                $customerQuery->where('c.Cust_Code', 'like', '%' . $request->code . '%');
            }
            if ($request->filled('name')) {
                $customerQuery->where('c.Cust_Name', 'like', '%' . $request->name . '%');
            }

            $customer = $customerQuery->first();
            if (!$customer) {
                return response()->json(['success' => false, 'message' => 'No customer found.']);
            }

            $renewals = DB::table('trans_renewal')
                ->where('Cust_Id', $customer->Cust_Id)
                ->orderByDesc('Demand_Date')
                ->orderByDesc('Renewal_Id')
                ->get([
                    'Renewal_Id',
                    'Inv_No',
                    'Demand_Date',
                    'Renew_From',
                    'Renew_Upto',
                    'Total_Amount',
                    'Pay_Status',
                    'Receipt_No',
                    'Receipt_Date',
                    'Advance_Adj',
                ]);

            return response()->json([
                'success'  => true,
                'customer' => $customer,
                'renewals' => $renewals,
            ]);
        } catch (\Exception $e) {
            Log::channel('internet')->error('Generate demand search error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Something went wrong.'], 500);
        }
    }

    public function generate(Request $request)
    {
        $request->validate([
            'Cust_Id'      => 'required|integer',
            'Renewal_Date' => 'required|date',
            'Renew_From'   => 'required|date',
            'Renew_Upto'   => 'required|date|after:Renew_From',
            'Package_Id'   => 'nullable|integer',
        ]);

        try {
            $customer = DB::table('mst_customer')
                ->where('Cust_Id', $request->Cust_Id)
                ->first(['Cust_Name', 'Cust_Code', 'User_Id', 'Account_No', 'Contact_No', 'Billing_Address', 'Package_Id']);

            $packageId = $request->Package_Id ?: (is_object($customer) ? $customer->Package_Id : null);
            $package = $packageId
                ? DB::table('mst_package')->where('Package_Id', $packageId)->first(['Package_Name', 'Total_Amt'])
                : null;

            $pdo  = DB::getPdo();
            $stmt = $pdo->prepare('CALL usp_generateDemandManual(?,?,?,?,?,?,?)');
            $stmt->execute([
                $request->Cust_Id,
                $request->Renew_From,
                $request->Renew_Upto,
                session('user_id'),
                session('is_admin') == 1 ? null : session('counter_id'),
                $request->Package_Id ?: null,
                $request->Renewal_Date,
            ]);

            $row = $stmt->fetch(\PDO::FETCH_OBJ);
            $stmt->closeCursor();

            if (!$row || $row->Error_No < 0) {
                return response()->json([
                    'success' => false,
                    'message' => is_object($row) ? $row->Message : 'Failed to generate renewal.',
                ]);
            }

            try {
                $adminMail = DB::table('mst_org')->value('Admin_Mail');

                if (!empty($adminMail) && $customer) {
                    $generatedBy = session('is_admin') == 1
                        ? (session('full_name') ?: session('user_name') ?: 'Admin')
                        : (session('counter_name') ?: session('full_name') ?: 'Counter');

                    $packageName = $package->Package_Name ?? '-';
                    $from = date('d/m/y', strtotime($request->Renew_From));
                    $upto = date('d/m/y', strtotime($request->Renew_Upto));

                    Mail::to($adminMail)->queue(new DemandGeneratedMail([
                        'generated_by' => $generatedBy,
                        'cust_name'    => $customer->Cust_Name ?? '-',
                        'cust_code'    => $customer->Cust_Code ?? '-',
                        'user_id'      => $customer->User_Id ?? '-',
                        'account_no'   => $customer->Account_No ?? '-',
                        'contact_no'   => $customer->Contact_No ?? '-',
                        'address'      => $customer->Billing_Address ?? '-',
                        'package'      => $packageName,
                        'period'       => 'Rs. ' . number_format((float) ($package->Total_Amt ?? 0), 2)
                            . '/- against Renew ' . $packageName . ' package for ' . $from . ' to ' . $upto,
                    ]));
                }
            } catch (\Exception $mailError) {
                Log::channel('internet')->error('Demand mail error: ' . $mailError->getMessage());
            }

            return response()->json(['success' => true, 'message' => $row->Message]);
        } catch (\Exception $e) {
            Log::channel('internet')->error('Generate demand error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to generate renewal.'], 500);
        }
    }

    public function destroy(Request $request)
    {
        if ((int) session('is_admin') !== 1) {
            return response()->json(['success' => false, 'message' => 'Only admin can delete a renewal.'], 403);
        }

        $request->validate([
            'Renewal_Id' => 'required|integer',
            'Cust_Id'    => 'required|integer',
        ]);

        $renewal = DB::table('trans_renewal')
            ->where('Renewal_Id', $request->Renewal_Id)
            ->where('Cust_Id', $request->Cust_Id)
            ->first();

        if (!$renewal) {
            return response()->json(['success' => false, 'message' => 'Renewal not found.']);
        }

        if ((int) $renewal->Counter_Comm_Paid === 1 || (int) $renewal->Zone_Comm_Paid === 1) {
            return response()->json([
                'success' => false,
                'message' => 'Commission for this renewal is already paid, so it cannot be deleted.',
            ]);
        }

        try {
            DB::transaction(function () use ($renewal) {
                $customer = DB::table('mst_customer')
                    ->where('Cust_Id', $renewal->Cust_Id)
                    ->lockForUpdate()
                    ->first();

                $log = (array) $renewal;
                $log['Deleted_By'] = session('user_id');
                $log['Deleted_On'] = now();
                $logColumns = collect(DB::select('SHOW COLUMNS FROM trans_renewal_log'))->pluck('Field')->flip();
                unset($log['Log_Id']);
                $log = array_intersect_key($log, $logColumns->all());
                DB::table('trans_renewal_log')->insert($log);

                if (!empty($renewal->Receipt_No)) {
                    $payments = DB::table('trans_renewal_payment')
                        ->where('Receipt_No', $renewal->Receipt_No)
                        ->get();
                    foreach ($payments as $payment) {
                        DB::table('trans_renewal_payment_log')->insert([
                            'Payment_Id'   => $payment->Payment_Id,
                            'Receipt_No'   => $payment->Receipt_No,
                            'Renewal_Id'   => $renewal->Renewal_Id,
                            'Cust_Id'      => $payment->Cust_Id,
                            'Receipt_Date' => $payment->Receipt_Date,
                            'Mode_Id'      => $payment->Mode_Id,
                            'Paid_Amt'     => $payment->Paid_Amt,
                            'Txn_Id'       => $payment->Txn_Id,
                            'Counter_Id'   => $payment->Counter_Id,
                            'Created_By'   => $payment->Created_By,
                            'Created_On'   => $payment->Created_On,
                            'Deleted_By'   => session('user_id'),
                            'Deleted_On'   => now(),
                        ]);
                    }
                }

                DB::table('trans_renewal')->where('Renewal_Id', $renewal->Renewal_Id)->delete();

                $remaining = DB::table('trans_renewal')
                    ->where('Cust_Id', $renewal->Cust_Id)
                    ->orderByDesc('Renew_Upto')
                    ->orderByDesc('Renewal_Id')
                    ->get();

                $due = round((float) $remaining->where('Pay_Status', '!=', 2)->sum('Due_Amt'), 2);
                $lastPay = $remaining->where('Pay_Status', 2)->max('Receipt_Date');

                $customerUpdate = [
                    'Due_Amount' => $due < 0 ? 0 : $due,
                    'Last_PayDt' => $lastPay,
                ];

                $deletedUpto = substr((string) $renewal->Renew_Upto, 0, 10);
                $customerUpto = $customer ? substr((string) $customer->Renew_Upto, 0, 10) : '';

                if ($customer && $deletedUpto !== '' && $deletedUpto === $customerUpto) {
                    $latest = $remaining->first();
                    if ($latest) {
                        $customerUpdate['Renew_From'] = $latest->Renew_From;
                        $customerUpdate['Renew_Upto'] = $latest->Renew_Upto;
                        $customerUpdate['Package_Id'] = $latest->Plan_Id;
                        $customerUpdate['Plan_Amount'] = $latest->Renew_Amt;
                        $customerUpdate['GST'] = $latest->GST_Amt;
                        $customerUpdate['Total_Amount'] = $latest->Total_Amount;
                    } else {
                        $customerUpdate['Renew_From'] = null;
                        $customerUpdate['Renew_Upto'] = null;
                    }
                }

                DB::table('mst_customer')->where('Cust_Id', $renewal->Cust_Id)->update($customerUpdate);
            });

            return response()->json(['success' => true, 'message' => 'Renewal deleted.']);
        } catch (\Exception $e) {
            Log::channel('internet')->error('Renewal delete error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to delete renewal.'], 500);
        }
    }
}
