<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CounterController extends Controller
{
    public function index()
    {
        $counters = DB::select('CALL usp_getCounter(?)' ,[0]);
        return view('Admin.counter', compact('counters'));
    }

    public function save(Request $request)
    {
        $request->validate([
            'Counter_Name'    => 'required|string|max:50',
            'Counter_Address' => 'nullable|string|max:100',
            'Contact_No'      => 'nullable|string|max:10',
            'Email_Id'        => 'nullable|email|max:75',
            'Is_Active'       => 'required|in:0,1',
        ]);

        try {
            $result = DB::select('CALL usp_saveCounter(?,?,?,?,?,?)', [
                $request->Counter_Id ?? 0,
                $request->Counter_Name,
                $request->Counter_Address,
                $request->Contact_No,
                $request->Email_Id,
                $request->Is_Active,
            ]);

            $row = $result[0];
            if ($row->Error_No < 0) {
                return response()->json(['success' => false, 'message' => $row->Message]);
            }

            return response()->json([
                'success' => true,
                'message' => $request->Counter_Id ? 'Counter updated successfully.' : 'Counter saved successfully.'
            ]);

        } catch (\Exception $e) {
            Log::channel('internet')->error('Counter save error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to save counter.'], 500);
        }
    }

    public function delete(Request $request)
{
    $request->validate(['Counter_Id' => 'required|integer']);
    try {
        $result = DB::select('CALL usp_deleteCounter(?)', [$request->Counter_Id]);
        $row = $result[0];
        if ($row->Error_No < 0) {
            return response()->json(['success' => false, 'message' => $row->Message]);
        }
        return response()->json(['success' => true, 'message' => $row->Message]);
    } catch (\Exception $e) {
        Log::channel('internet')->error('Counter delete error: ' . $e->getMessage());
        return response()->json(['success' => false, 'message' => 'Failed to delete counter.'], 500);
    }
}

}
