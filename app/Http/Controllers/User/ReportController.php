<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ReportController extends Controller
{
    public function customerRegister(Request $request)
    {
        $statusList = DB::select('CALL usp_getDropdownList(?)', [1]);
        $zones      = DB::select('CALL usp_getZone(0)');
        return view('User.customer-register', compact('statusList', 'zones'));
    }

    public function customerRegisterData(Request $request)
    {
        $request->validate([
            'from_date' => 'required|date',
            'to_date'   => 'required|date|after_or_equal:from_date',
            'status'    => 'nullable|integer',
            'zone_id'   => 'nullable|integer',
        ]);

        try {
            $result = DB::select('CALL usp_getCustomerRegister(?, ?, ?, ?, ?)', [
               $request->from_date,
            $request->to_date,
            $request->filled('status')  ? $request->status  : null,
            $request->filled('zone_id') ? $request->zone_id : null,
            session('counter_id'),
            ]);

            return response()->json([
                'success' => true,
                'data'    => $result,
                'total'   => count($result),
            ]);
        } catch (\Exception $e) {
            Log::channel('internet')->error('Customer register report error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Something went wrong.'], 500);
        }
    }



  public function customerLedger(Request $request)
{
    return view('User.customer-ledger', ['ledgerDataRoute' => 'customer.ledger.data']);
}

    public function customerLedgerData(Request $request)
    {
        try {
            $pdo  = DB::getPdo();
            $stmt = $pdo->prepare('CALL usp_getCustomerLedger(?, ?, ?, ?, ?, ?)');
            $stmt->execute([
                $request->filled('account') ? $request->account : null,
                $request->filled('userid')  ? $request->userid  : null,
                $request->filled('code')    ? $request->code    : null,
                $request->filled('name')    ? $request->name    : null,
                $request->filled('phone')   ? $request->phone   : null,
                session('counter_id'),
            ]);

            $customerInfo = $stmt->fetchAll(\PDO::FETCH_OBJ);
            $stmt->nextRowset();
            $ledgerRows = $stmt->fetchAll(\PDO::FETCH_OBJ);

            if (empty($customerInfo)) {
                return response()->json(['success' => false, 'message' => 'No customer found.']);
            }

            return response()->json([
                'success'  => true,
                'customer' => $customerInfo[0],
                'ledger'   => $ledgerRows,
            ]);
        } catch (\Exception $e) {
            Log::channel('internet')->error('Ledger data error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Something went wrong.'], 500);
        }
    }



    public function renewalRegister(Request $request)
{
    return view('User.renewal-register', ['dataRoute' => 'report.renewal.register.data']);
}

    public function renewalRegisterData(Request $request)
    {
        $request->validate([
            'from_date' => 'required|date',
            'to_date'   => 'required|date|after_or_equal:from_date',
        ]);
        try {
            $result = DB::select('CALL usp_getRenewalRegister(?, ?, ?, ?)', [
                $request->from_date,
                $request->to_date,
                session('counter_id'),
                1,
            ]);
            return response()->json(['success' => true, 'data' => $result, 'total' => count($result)]);
        } catch (\Exception $e) {
            Log::channel('internet')->error('Renewal register error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Something went wrong.'], 500);
        }
    }


    public function collectionRegister(Request $request)
{
    return view('User.collection-register', ['dataRoute' => 'report.collection.register.data']);
}

    public function collectionRegisterData(Request $request)
    {
        $request->validate([
            'from_date' => 'required|date',
            'to_date'   => 'required|date|after_or_equal:from_date',
        ]);
        try {
            $result = DB::select('CALL usp_getRenewalRegister(?, ?, ?, ?)', [
                $request->from_date,
                $request->to_date,
                session('counter_id'),
                2,
            ]);
            return response()->json(['success' => true, 'data' => $result, 'total' => count($result)]);
        } catch (\Exception $e) {
            Log::channel('internet')->error('Collection register error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Something went wrong.'], 500);
        }
    }


  public function dueRegister(Request $request)
{
    return view('User.due-register', ['dataRoute' => 'report.due.register.data']);
}


    public function dueRegisterData(Request $request)
    {
        $request->validate([
            'from_date' => 'required|date',
            'to_date'   => 'required|date|after_or_equal:from_date',
        ]);
        try {
            $result = DB::select('CALL usp_getRenewalRegister(?, ?, ?, ?)', [
                $request->from_date,
                $request->to_date,
                session('counter_id'),
                3,
            ]);
            return response()->json(['success' => true, 'data' => $result, 'total' => count($result)]);
        } catch (\Exception $e) {
            Log::channel('internet')->error('Due register error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Something went wrong.'], 500);
        }
    }



public function adminRenewalRegister(Request $request)
{
    return view('User.renewal-register', ['dataRoute' => 'admin.report.renewal.register.data']);
}

public function adminRenewalRegisterData(Request $request)
{
    $request->validate([
        'from_date' => 'required|date',
        'to_date'   => 'required|date|after_or_equal:from_date',
    ]);
    try {
        $result = DB::select('CALL usp_getRenewalRegister(?, ?, ?, ?)', [
            $request->from_date,
            $request->to_date,
            null,   // NULL = all counters for admin
            1,
        ]);
        return response()->json(['success' => true, 'data' => $result, 'total' => count($result)]);
    } catch (\Exception $e) {
        Log::channel('internet')->error('Admin renewal register error: ' . $e->getMessage());
        return response()->json(['success' => false, 'message' => 'Something went wrong.'], 500);
    }
}

public function adminCollectionRegister(Request $request)
{
    return view('User.collection-register', ['dataRoute' => 'admin.report.collection.register.data']);
}

public function adminCollectionRegisterData(Request $request)
{
    $request->validate([
        'from_date' => 'required|date',
        'to_date'   => 'required|date|after_or_equal:from_date',
    ]);
    try {
        $result = DB::select('CALL usp_getRenewalRegister(?, ?, ?, ?)', [
            $request->from_date,
            $request->to_date,
            null,   // NULL = all counters for admin
            2,
        ]);
        return response()->json(['success' => true, 'data' => $result, 'total' => count($result)]);
    } catch (\Exception $e) {
        Log::channel('internet')->error('Admin collection register error: ' . $e->getMessage());
        return response()->json(['success' => false, 'message' => 'Something went wrong.'], 500);
    }
}

public function adminDueRegister(Request $request)
{
    return view('User.due-register', ['dataRoute' => 'admin.report.due.register.data']);
}

public function adminDueRegisterData(Request $request)
{
    $request->validate([
        'from_date' => 'required|date',
        'to_date'   => 'required|date|after_or_equal:from_date',
    ]);
    try {
        $result = DB::select('CALL usp_getRenewalRegister(?, ?, ?, ?)', [
            $request->from_date,
            $request->to_date,
            null,   // NULL = all counters for admin
            3,
        ]);
        return response()->json(['success' => true, 'data' => $result, 'total' => count($result)]);
    } catch (\Exception $e) {
        Log::channel('internet')->error('Admin due register error: ' . $e->getMessage());
        return response()->json(['success' => false, 'message' => 'Something went wrong.'], 500);
    }
}


public function adminCustomerLedger(Request $request)
{
    return view('User.customer-ledger', ['ledgerDataRoute' => 'admin.customer.ledger.data']);
}

public function adminCustomerLedgerData(Request $request)
{
    try {
        $pdo  = DB::getPdo();
        $stmt = $pdo->prepare('CALL usp_getCustomerLedger(?, ?, ?, ?, ?, ?)');
        $stmt->execute([
            $request->filled('account') ? $request->account : null,
            $request->filled('userid')  ? $request->userid  : null,
            $request->filled('code')    ? $request->code    : null,
            $request->filled('name')    ? $request->name    : null,
            $request->filled('phone')   ? $request->phone   : null,
            null, // admin sees all counters
        ]);

        $customerInfo = $stmt->fetchAll(\PDO::FETCH_OBJ);
        $stmt->nextRowset();
        $ledgerRows = $stmt->fetchAll(\PDO::FETCH_OBJ);

        if (empty($customerInfo)) {
            return response()->json(['success' => false, 'message' => 'No customer found.']);
        }

        return response()->json([
            'success'  => true,
            'customer' => $customerInfo[0],
            'ledger'   => $ledgerRows,
        ]);
    } catch (\Exception $e) {
        Log::channel('internet')->error('Admin ledger data error: ' . $e->getMessage());
        return response()->json(['success' => false, 'message' => 'Something went wrong.'], 500);
    }
}


}
