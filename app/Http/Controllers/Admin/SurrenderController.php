<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SurrenderController extends Controller
{
   public function index()
{
    $pdo  = DB::getPdo();
    $stmt = $pdo->prepare('CALL usp_getSurrenderCustomers(NULL, NULL, NULL, NULL)');
    $stmt->execute();
    $stmt->fetchAll(); // discard customers
    $stmt->nextRowset();
    $statuses = $stmt->fetchAll(\PDO::FETCH_OBJ);

    return view('Admin.surrender', compact('statuses'));
}

    public function save(Request $request)
    {
        $request->validate([
            'Cust_Id' => 'required|integer',
            'Status'  => 'required|integer',
        ]);

        try {
            $result = DB::select('CALL usp_updateCustomerStatus(?,?,?)', [
                $request->Cust_Id,
                $request->Status,
                session('user_id'),
            ]);

            $row = $result[0];
            if ($row->Error_No < 0) {
                return response()->json(['success' => false, 'message' => $row->Message]);
            }

            return response()->json(['success' => true, 'message' => 'Customer status updated successfully.']);

        } catch (\Exception $e) {
            Log::channel('internet')->error('Surrender save error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to update status.'], 500);
        }
    }
    public function search(Request $request)
{
    try {
        $pdo  = DB::getPdo();
        $stmt = $pdo->prepare('CALL usp_getSurrenderCustomers(?, ?, ?, ?)');
        $stmt->execute([
            $request->filled('account') ? $request->account : null,
            $request->filled('userid')  ? $request->userid  : null,
            $request->filled('code')    ? $request->code    : null,
            $request->filled('name')    ? $request->name    : null,
        ]);
        $data = $stmt->fetchAll(\PDO::FETCH_OBJ);
        return response()->json(['success' => true, 'data' => $data]);
    } catch (\Exception $e) {
        Log::channel('internet')->error('Surrender search error: ' . $e->getMessage());
        return response()->json(['success' => false, 'message' => 'Something went wrong.'], 500);
    }
}
}
