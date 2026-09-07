<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PackageController extends Controller
{
    public function index()
    {
        $packages = DB::select('CALL usp_getPackage(?,?)', [0,1]);
        $packTypes = DB::select('CALL usp_getPackageType()');
        return view('Admin.package', compact('packages','packTypes'));
    }

    public function save(Request $request)
    {
        $request->validate([
            'Pack_Type'    => 'required|integer',
            'Package_Name' => 'required|string|max:75',
            'Basic_Amt'    => 'required|numeric|min:0|max:99999.99',
            'GST_Amt'      => 'required|numeric|min:0|max:99999.99',
            'Total_Amt'    => 'required|numeric|min:0|max:99999.99',
            'Plan_Days'    => 'required|integer|min:1|max:9999',
            'Comm_Amt'     => 'nullable|numeric|min:0|max:99999.99',
            'Is_Active'    => 'required|in:0,1',
        ]);

        try {
            $result = DB::select('CALL usp_savePackage(?,?,?,?,?,?,?,?,?,?)', [
                $request->Package_Id ?? 0,
                $request->Pack_Type,
                $request->Package_Name,
                $request->Basic_Amt,
                $request->GST_Amt,
                $request->Total_Amt,
                $request->Plan_Days,
                $request->Comm_Amt ?? 1,
                $request->Is_Active,
                0

            ]);

            $row = $result[0];
            if ($row->Error_No < 0) {
                return response()->json(['success' => false, 'message' => $row->Message]);
            }

            return response()->json([
                'success' => true,
                'message' => $request->Package_Id ? 'Package updated successfully.' : 'Package saved successfully.'
            ]);
        } catch (\Exception $e) {
            Log::channel('internet')->error('Package save error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
    public function delete(Request $request)
    {
        try {
            $result = DB::select('CALL usp_savePackage(?,?,?,?,?,?,?,?,?,?)', [
                $request->Package_Id,
                0,
                null,
                0,
                0,
                0,
                0,
                0,
                0,
                1,  // pAction = Delete
            ]);
            $row = $result[0];
            if ($row->Error_No < 0) {
                return response()->json(['success' => false, 'message' => $row->Message]);
            }
            return response()->json(['success' => true, 'message' => 'Package deleted successfully.']);
        } catch (\Exception $e) {
            Log::channel('internet')->error('Package delete error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to delete package.'], 500);
        }
    }
}
