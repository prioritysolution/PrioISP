<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ZoneController extends Controller
{
    public function index()
    {
        $zones    = DB::select('CALL usp_getZone(?)', [0]);
        return view('Admin.zone', compact('zones'));
    }

    public function save(Request $request)
    {
        $request->validate([
            'Zone_Cd'       => 'required|string|max:20',
            'LCO_Name'      => 'required|string|max:50',
            'Operator_Name' => 'required|string|max:50',
            'Comm_Pct'      => 'required|numeric|min:0|max:100',  
            'Eff_From' => ($request->Zone_Id ? 'required' : 'nullable') . '|date',
            'Is_Active'     => 'required|in:0,1',
        ]);

        try {
            $result = DB::select('CALL usp_saveZone(?,?,?,?,?,?,?,?)', [
                $request->Zone_Id ?? 0,
                $request->Zone_Cd,
                $request->LCO_Name,
                $request->Operator_Name,
                $request->Comm_Pct ?? 0,
                $request->Eff_From, 
                $request->Is_Active,
                 session('user_id'),
            ]);

            $row = $result[0];
            if ($row->Error_No < 0) {
                return response()->json(['success' => false, 'message' => $row->Message]);
            }

            return response()->json([
                'success' => true,
                'message' => $request->Zone_Id ? 'Zone updated successfully.' : 'Zone saved successfully.'
            ]);

        } catch (\Exception $e) {
            Log::channel('internet')->error('Zone save error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function delete(Request $request)
{
    $request->validate(['Zone_Id' => 'required|integer']);
    try {
        $result = DB::select('CALL usp_deleteZone(?)', [$request->Zone_Id]);
        $row = $result[0];
        if ($row->Error_No < 0) {
            return response()->json(['success' => false, 'message' => $row->Message]);
        }
        return response()->json(['success' => true, 'message' => $row->Message]);
    } catch (\Exception $e) {
        Log::channel('internet')->error('Zone delete error: ' . $e->getMessage());
        return response()->json(['success' => false, 'message' => 'Failed to delete zone.'], 500);
    }
}

}
