<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PDO;

class NewCustomerController extends Controller
{
    public function index(Request $request)
    {
        try {
            $zones       = DB::select('CALL usp_getZone(0)');
            $packages    = DB::select('CALL usp_getPackage(?,?)', [1, 0]);
            $actionMenus = DB::select('CALL usp_getActionMenus()');
            $statusList  = DB::select('CALL usp_getDropdownList(?)', [1]);
            $counts      = DB::select('CALL usp_getCustomerCounts(?)', [0]);
            $summary     = $counts[0];

            $perPage = (int) $request->input('per_page', 25);
            if (!in_array($perPage, [10, 25, 50, 100], true)) {
                $perPage = 25;
            }
            $page = max(1, (int) $request->input('page', 1));

            $hasFilter = $request->filled('filter_status')    ||
                $request->filled('filter_name')      ||
                $request->filled('filter_wildcard')  ||
                $request->filled('filter_payment')   ||
                $request->filled('filter_package')   ||
                $request->filled('filter_zone')      ||
                $request->filled('filter_from_date') ||
                $request->filled('filter_to_date');

            $pdo = DB::getPdo();

            if ($hasFilter) {
                $stmt = $pdo->prepare('CALL usp_searchCustomers(?,?,?,?,?,?,?,?,?,?,?)');
                $stmt->execute([
                    $request->filled('filter_status')    ? $request->filter_status    : null,
                    $request->filled('filter_name')      ? $request->filter_name      : null,
                    $request->filled('filter_wildcard')  ? $request->filter_wildcard  : null,
                    $request->filled('filter_payment')   ? $request->filter_payment   : null,
                    $request->filled('filter_package')   ? $request->filter_package   : null,
                    null,
                    $request->filled('filter_zone')      ? $request->filter_zone      : null,
                    $request->filled('filter_from_date') ? $request->filter_from_date : null,
                    $request->filled('filter_to_date')   ? $request->filter_to_date   : null,
                    $page,
                    $perPage,
                ]);
            } else {
                $stmt = $pdo->prepare('CALL usp_getCustomersAdmin(?,?)');
                $stmt->execute([$page, $perPage]);
            }

            $rows = $stmt->fetchAll(PDO::FETCH_OBJ);
            $stmt->nextRowset();
            $countData = $stmt->fetchAll(PDO::FETCH_OBJ);
            $total = (int) ($countData[0]->Total_Count ?? 0);
            $stmt->closeCursor();

            $customers = new LengthAwarePaginator(
                $rows,
                $total,
                $perPage,
                $page,
                [
                    'path'  => $request->url(),
                    'query' => $request->query(),
                ]
            );

            return view('Admin.new-customer', compact('zones', 'packages', 'customers', 'actionMenus', 'total', 'summary', 'statusList'));
        } catch (\Exception $e) {
            Log::channel('internet')->error('Customer index error: ' . $e->getMessage());
            return back()->with('error', 'Something went wrong. Please try again.');
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'Join_Date'       => 'required|date',
            'Cust_Code'       => 'required|string|max:6',
            'Cust_Name'       => 'required|string|max:50',
            'Billing_Address' => 'required|string|max:100',
            'User_Id'         => 'required|string|max:75',
            'Account_No'      => 'required|string|max:75',
            'Contact_No'      => 'required|string|max:10',
            'Mail_Id'         => 'nullable|email|max:50',
            'IP_Addrs'        => 'required|string|max:25',
            'Package_Id'      => 'required|integer',
            'Zone_Id'         => 'required|integer',
            'Router_Dtls'     => 'nullable|string|max:25',
            'Remarks'         => 'nullable|string|max:150',
        ]);

        try {
            DB::beginTransaction();

            $result = DB::select('CALL usp_InsertCustomer(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)', [
                $request->Join_Date,
                $request->Cust_Code,
                $request->Cust_Name,
                $request->Billing_Address,
                $request->User_Id,
                $request->Account_No,
                $request->Contact_No,
                $request->Mail_Id,
                $request->IP_Addrs,
                $request->Package_Id,
                $request->Zone_Id,
                $request->Router_Dtls,
                $request->Remarks,
                null,
                null,
                1,
                session('user_id'),
                0
            ]);

            if ($result && isset($result[0]->Error_No) && $result[0]->Error_No == -1) {
                DB::rollBack();
                return response()->json(['success' => false, 'message' => $result[0]->Message], 400);
            }

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Customer saved successfully!']);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::channel('internet')->error('Customer save error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to save customer.'], 500);
        }
    }

    public function update(Request $request)
    {
        $request->validate([
            'Cust_Id'         => 'required|integer',
            'Join_Date'       => 'required|date',
            'Cust_Code'       => 'required|string|max:6',
            'Cust_Name'       => 'required|string|max:50',
            'Billing_Address' => 'required|string|max:100',
            'User_Id'         => 'required|string|max:75',
            'Account_No'      => 'required|string|max:75',
            'Contact_No'      => 'required|string|max:10',
            'Mail_Id'         => 'nullable|email|max:50',
            'IP_Addrs'        => 'required|string|max:25',
            'Package_Id'      => 'required|integer',
            'Zone_Id'         => 'required|integer',
            'Router_Dtls'     => 'nullable|string|max:25',
            'Remarks'         => 'nullable|string|max:150',
        ]);

        try {
            DB::beginTransaction();

            $result = DB::select('CALL usp_InsertCustomer(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)', [
                $request->Join_Date,
                $request->Cust_Code,
                $request->Cust_Name,
                $request->Billing_Address,
                $request->User_Id,
                $request->Account_No,
                $request->Contact_No,
                $request->Mail_Id,
                $request->IP_Addrs,
                $request->Package_Id,
                $request->Zone_Id ?: null,
                $request->Router_Dtls,
                $request->Remarks,
                null,
                null,
                1,
                session('user_id'),
                $request->Cust_Id
            ]);

            if ($result && isset($result[0]->Error_No) && $result[0]->Error_No == -1) {
                DB::rollBack();
                return response()->json(['success' => false, 'message' => $result[0]->Message], 400);
            }

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Customer updated successfully!']);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Customer update error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to update customer.'], 500);
        }
    }

    public function export(Request $request)
    {
        try {
            $customers = DB::select('CALL usp_exportCustomers(?,?,?,?,?,?,?,?,?)', [
                $request->filled('filter_status')    ? $request->filter_status    : null,
                $request->filled('filter_name')      ? $request->filter_name      : null,
                $request->filled('filter_wildcard')  ? $request->filter_wildcard  : null,
                $request->filled('filter_payment')   ? $request->filter_payment   : null,
                $request->filled('filter_package')   ? $request->filter_package   : null,
                $request->filled('filter_counter')   ? $request->filter_counter   : null,
                $request->filled('filter_zone')      ? $request->filter_zone      : null,
                $request->filled('filter_from_date') ? $request->filter_from_date : null,
                $request->filled('filter_to_date')   ? $request->filter_to_date   : null,
            ]);

            $filename = 'customers_' . date('Ymd_His') . '.csv';
            $headers  = [
                'Content-Type'        => 'text/csv',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ];

            $callback = function () use ($customers) {
                $file = fopen('php://output', 'w');
                fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

                fputcsv($file, [
                    'Cust Code', 'Cust Name', 'Join Date', 'User ID',
                    'Account No', 'Contact No', 'Mail ID', 'IP Address',
                    'Package', 'Renew From', 'Renew Upto', 'Status', 'Payment Status'
                ]);

                foreach ($customers as $c) {
                    fputcsv($file, [
                        $c->Cust_Code,
                        $c->Cust_Name,
                        $c->Join_Date,
                        $c->User_Id,
                        $c->Account_No,
                        $c->Contact_No,
                        $c->Mail_Id,
                        $c->IP_Addrs,
                        $c->Package,
                        $c->Renew_From,
                        $c->Exp_Date,
                        $c->Status == 1 ? 'Active' : ($c->Status == 2 ? 'Suspended' : 'Disabled'),
                        $c->Payment_Status,
                    ]);
                }
                fclose($file);
            };

            return response()->stream($callback, 200, $headers);
        } catch (\Exception $e) {
            Log::channel('internet')->error('Customer export error: ' . $e->getMessage());
            return back()->with('error', 'Export failed. Please try again.');
        }
    }

    public function delete(Request $request)
    {
        $request->validate(['Cust_Id' => 'required|integer']);
        try {
            $result = DB::select('CALL usp_deleteCustomer(?)', [$request->Cust_Id]);
            $row = $result[0];
            if ($row->Error_No < 0) {
                return response()->json(['success' => false, 'message' => $row->Message]);
            }
            return response()->json(['success' => true, 'message' => $row->Message]);
        } catch (\Exception $e) {
            Log::channel('internet')->error('Customer delete error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to delete customer.'], 500);
        }
    }
}
