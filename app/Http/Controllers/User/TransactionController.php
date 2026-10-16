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
                return response()->json(['success' => false, 'message' => $result[0]->Message]);
            }

            return response()->json(['success' => true, 'demands' => $result]);
        } catch (\Exception $e) {
            Log::channel('internet')->error('Demand search error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Something went wrong.'], 500);
        }
    }

    public function collect(Request $request)
    {
        $request->validate([
            'Renewal_Ids'  => 'required|string',
            'Cust_Id'      => 'required|integer',
            'Receipt_Date' => 'required|date',
            'Mode_Id'      => 'required|integer',
            'Discount'     => 'nullable|numeric',
            'Net_Amt'      => 'required|numeric',
            'Txn_Id'       => 'nullable|string|max:30',
        ]);

        $modeName = DB::table('mst_mode')->where('Mode_Id', $request->Mode_Id)->value('Mode');
        $txnId = trim((string) $request->input('Txn_Id', ''));
        if (!$modeName || strcasecmp($modeName, 'Cash') === 0) {
            $txnId = '';
        }

        try {
            $pdo  = DB::getPdo();
            $stmt = $pdo->prepare('CALL usp_collectPayment(?,?,?,?,?,?,?,?,?)');
            $stmt->execute([
                $request->Renewal_Ids,
                $request->Cust_Id,
                $request->Receipt_Date,
                $request->Mode_Id,
                $request->Discount ?? 0,
                $request->Net_Amt,
                session('user_id'),
                session('is_admin') == 1 ? null : session('counter_id'),
                $txnId !== '' ? $txnId : null,
            ]);

            $first = $stmt->fetchAll(\PDO::FETCH_OBJ);

            // check if first result set is an error (single row with Error_No)
            if (!empty($first) && isset($first[0]->Error_No)) {
                return response()->json(['success' => false, 'message' => $first[0]->Message]);
            }

            $renewals = $first;
            $stmt->nextRowset();
            $row = $stmt->fetch(\PDO::FETCH_OBJ);

            if ($row->Error_No < 0) {
                $stmt->closeCursor();
                return response()->json(['success' => false, 'message' => $row->Message]);
            }

            $stmt->closeCursor();

            Log::channel('internet')->info('Receipt generated:', ['data', $renewals]);
            $receipt  = $renewals[0];
            $details  = [];
            $totalAmt = 0;
            $totalDisc = 0;

            foreach ($renewals as $r) {
                $details[]  = 'Rs. ' . number_format($r->Receipt_Amt, 2) . '/- against Renew '
                    . $r->Package_Name . ' package for '
                    . date('d M Y', strtotime($r->Renew_From)) . ' to '
                    . date('d M Y', strtotime($r->Renew_Upto));
                $totalAmt  += $r->Receipt_Amt;
                $totalDisc += $r->Disc_Amount ?? 0;
            }

            $receiptData = [
                'receipt_no'   => $receipt->Receipt_No,
                'date'         => date('d M Y', strtotime($receipt->Receipt_Date)),
                'cust_name'    => $receipt->Cust_Name,
                'cust_code'    => $receipt->Cust_Code      ?? '-',
                'address'      => $receipt->Billing_Address ?? '-',
                'account_no'   => $receipt->Account_No,
                'user_id'      => $receipt->User_Id,
                'amount'       => number_format($totalAmt, 2),
                'amount_words' => $this->numberToWords($totalAmt),
                'pay_mode'     => $receipt->Pay_Mode        ?? '-',
                'package_name' => $receipt->Package_Name    ?? '-',
                'period'       => implode(', ', $details),
                'discount'     => number_format($totalDisc, 2),
            ];

            return response()->json([
                'success' => true,
                'message' => $row->Message,
                'receipt' => $receiptData,
            ]);
        } catch (\Exception $e) {
            Log::channel('internet')->error('Demand collect error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to collect payment.'], 500);
        }
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
                    'date'         => date('d M Y', strtotime($r->Receipt_Date)),
                    'cust_name'    => $r->Cust_Name,
                    'cust_code'    => $r->Cust_Code,
                    'address'      => $r->Billing_Address,
                    'account_no'   => $r->Account_No,
                    'user_id'      => $r->User_Id,
                    'amount'       => number_format($r->Receipt_Amt, 2),
                    'amount_words' => $this->numberToWords($r->Receipt_Amt),
                    'package_name' => $r->Package_Name,
                    'renew_from'   => date('d-M-Y', strtotime($r->Renew_From)),
                    'renew_upto'   => date('d-M-Y', strtotime($r->Renew_Upto)),
                    'pay_mode'     => $r->Pay_Mode,
                    'period'       => date('d M Y', strtotime($r->Renew_From)) . ' to ' . date('d M Y', strtotime($r->Renew_Upto)),
                    'discount'     => number_format($r->Disc_Amount ?? 0, 2),
                ]
            ]);
        } catch (\Exception $e) {
            Log::channel('internet')->error('Bill print error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Something went wrong.'], 500);
        }
    }
}
