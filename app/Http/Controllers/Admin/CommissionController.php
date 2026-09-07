<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CommissionController extends Controller
{
  

    public function commissionRegister()
{
    $zones = DB::select('CALL usp_getZone(?)', [0]);
    return view('Admin.commission-register', compact('zones'));
}

public function commissionRegisterSummary(Request $request)
{
    $request->validate([
        'from_date' => 'required|date',
        'to_date'   => 'required|date|after_or_equal:from_date',
    ]);
    try {
        $data = DB::select('CALL usp_getCommissionRegisterSummary(?, ?)', [
            $request->from_date,
            $request->to_date,
        ]);
        return response()->json(['success' => true, 'data' => $data]);
    } catch (\Exception $e) {
        Log::channel('internet')->error('Commission register summary error: ' . $e->getMessage());
        return response()->json(['success' => false, 'message' => 'Failed to load summary.'], 500);
    }
}

public function commissionRegisterDetail(Request $request)
{
    $request->validate([
        'from_date' => 'required|date',
        'to_date'   => 'required|date|after_or_equal:from_date',
        'zone_id'   => 'nullable|integer',
    ]);
    try {
        $data = DB::select('CALL usp_getCommissionRegisterDetail(?, ?, ?)', [
            $request->from_date,
            $request->to_date,
            $request->zone_id ?: null,
        ]);
        return response()->json(['success' => true, 'data' => $data]);
    } catch (\Exception $e) {
        Log::channel('internet')->error('Commission register detail error: ' . $e->getMessage());
        return response()->json(['success' => false, 'message' => 'Failed to load detail.'], 500);
    }
}














public function counterCommissionRegister()
{
    return view('User.commission-register');
}

public function counterCommissionData(Request $request)
{
    $request->validate([
        'from_date' => 'required|date',
        'to_date'   => 'required|date|after_or_equal:from_date',
    ]);

    try {
        $data = DB::select('CALL usp_getCounterCommissionRegister(?,?,?)', [
            $request->from_date,
            $request->to_date,
            session('counter_id'),
        ]);
        return response()->json(['success' => true, 'data' => $data]);
    } catch (\Exception $e) {
        Log::channel('internet')->error('Counter commission error: ' . $e->getMessage());
        return response()->json(['success' => false, 'message' => 'Failed to load data.'], 500);
    }
}






public function commissionPayout()
{
    $counters = DB::select('CALL usp_getCounter(?)', [0]);
    $zones    = DB::select('CALL usp_getZone(?)', [0]);
    $payModes = DB::select('CALL usp_getPayMode(?)', [0]);
    return view('Admin.commission-payout', compact('counters', 'zones', 'payModes'));
}

public function getCommissionDue(Request $request)
{
    $request->validate([
        'type'   => 'required|in:1,2',
        'ref_id' => 'required|integer',
    ]);
    try {
        $data = DB::select('CALL usp_CommissionPayout(1,?,?,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL)', [
            $request->type,
            $request->ref_id,
            
        ]);
        return response()->json(['success' => true, 'data' => $data[0]]);
    } catch (\Exception $e) {
        Log::channel('internet')->error('Commission due error: ' . $e->getMessage());
        return response()->json(['success' => false, 'message' => 'Failed to load.'], 500);
    }
}

public function saveCommissionPayout(Request $request)
{
    $request->validate([
        'type'       => 'required|in:1,2',
        'ref_id'     => 'required|integer',
        'ref_name'   => 'required|string',
        'from_date'  => 'required|date',
        'to_date'    => 'required|date',
        'total_comm' => 'required|numeric',
        'paid_amt'   => 'required|numeric',
        'pay_mode'   => 'required|integer',
        'pay_date'   => 'required|date',
        'remarks'    => 'nullable|string|max:150',
    ]);
    try {
        $result = DB::select('CALL usp_CommissionPayout(2,?,?,?,?,?,?,?,?,?,?,?)', [
            $request->type,
            $request->ref_id,
            $request->ref_name,
            $request->from_date,
            $request->to_date,
            $request->total_comm,
            $request->paid_amt,
            $request->pay_mode,
            $request->pay_date,
            $request->remarks,
            session('user_id'),
        ]);
        $row = $result[0];
        if ($row->Error_No < 0) {
            return response()->json(['success' => false, 'message' => $row->Message]);
        }
        return response()->json(['success' => true, 'message' => $row->Message]);
    } catch (\Exception $e) {
        Log::channel('internet')->error('Commission payout save error: ' . $e->getMessage());
        return response()->json(['success' => false, 'message' => 'Failed to save payout.'], 500);
    }
}

public function getPayoutHistory(Request $request)
{
    try {
        $data = DB::select('CALL usp_CommissionPayout(3,?,?,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL)', [
            $request->type  ?? 0,
            $request->ref_id ?? 0,
        ]);
        return response()->json(['success' => true, 'data' => $data]);
    } catch (\Exception $e) {
        Log::channel('internet')->error('Payout history error: ' . $e->getMessage());
        return response()->json(['success' => false, 'message' => 'Failed to load history.'], 500);
    }
}









public function counterCommissionRegisterAdmin()
{
    $counters = DB::select('CALL usp_getCounter(?)', [0]);
    return view('Admin.commission-register-counter', compact('counters'));
}
public function counterCommissionRegisterAdminData(Request $request)
{
    $request->validate([
        'from_date'  => 'required|date',
        'to_date'    => 'required|date|after_or_equal:from_date',
        'counter_id' => 'required|integer',
    ]);
    try {
        $data = DB::select('CALL usp_getCounterCommissionRegister(?,?,?)', [
            $request->from_date,
            $request->to_date,
            $request->counter_id,
        ]);
        return response()->json(['success' => true, 'data' => $data]);
    } catch (\Exception $e) {
        Log::channel('internet')->error('Counter commission admin error: ' . $e->getMessage());
        return response()->json(['success' => false, 'message' => 'Failed to load data.'], 500);
    }
}




}
