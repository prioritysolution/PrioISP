<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RectifyController extends Controller
{
   public function index()
{
    $pdo  = DB::getPdo();
    $stmt = $pdo->prepare('CALL usp_getRectifyRenewals(NULL, NULL, NULL, NULL, NULL)');
    $stmt->execute();
    $stmt->fetchAll(); // discard renewals
    $stmt->nextRowset();
    $modes = $stmt->fetchAll(\PDO::FETCH_OBJ);


    $searchRoute = request()->routeIs('admin.*') ? 'admin.rectify.search' : 'rectify.search';
    $saveRoute   = request()->routeIs('admin.*') ? 'admin.rectify.save'   : 'rectify.save';

    return view('Admin.rectify', compact('modes','searchRoute', 'saveRoute'));
}

    public function save(Request $request)
    {
        $request->validate([
            'Renewal_Id'  => 'required|integer',
            'Cust_Id'     => 'required|integer',
            'New_Mode_Id' => 'required|integer',
            'Old_Mode'    => 'nullable|string',
            'New_Mode'    => 'required|string',
        ]);

        try {
            $result = DB::select('CALL usp_saveRectify(?,?,?,?,?,?)', [
                $request->Renewal_Id,
                $request->Cust_Id,
                $request->New_Mode_Id,
               'Mode changed from ' . ($request->Old_Mode ?? 'N/A') . ' to ' . $request->New_Mode,
                session('user_id'),   // ← correct
                now()->toDateString(),
            ]);


            $row = $result[0];
            if ($row->Error_No < 0) {
                return response()->json(['success' => false, 'message' => $row->Message]);
            }

            return response()->json(['success' => true, 'message' => 'Receipt mode updated successfully.']);
        } catch (\Exception $e) {
            Log::channel('internet')->error('Rectify save error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to update.'], 500);
        }
    }


public function search(Request $request)
{
    try {
        $pdo  = DB::getPdo();
        $stmt = $pdo->prepare('CALL usp_getRectifyRenewals(?, ?, ?, ?,?)');
        $stmt->execute([
            $request->filled('account') ? $request->account : null,
            $request->filled('userid')  ? $request->userid  : null,
            $request->filled('code')    ? $request->code    : null,
            $request->filled('name')    ? $request->name    : null,
             $request->filled('receipt_date')  ? $request->receipt_date  : null,
        ]);
        $data = $stmt->fetchAll(\PDO::FETCH_OBJ);
        return response()->json(['success' => true, 'data' => $data]);
    } catch (\Exception $e) {
        Log::channel('internet')->error('Rectify search error: ' . $e->getMessage());
        return response()->json(['success' => false, 'message' => 'Something went wrong.'], 500);
    }
}

}
