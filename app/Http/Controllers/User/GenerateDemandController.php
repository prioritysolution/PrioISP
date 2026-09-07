<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
            $pdo  = DB::getPdo();
            $stmt = $pdo->prepare('CALL usp_searchCustomerDemand(?,?,?,?,?)');
            $stmt->execute([
                $request->filled('account') ? $request->account : null,
                $request->filled('userid')  ? $request->userid  : null,
                $request->filled('code')    ? $request->code    : null,
                $request->filled('name')    ? $request->name    : null,
                session('counter_id'),
            ]);

            $customers = $stmt->fetchAll(\PDO::FETCH_OBJ);
            $stmt->nextRowset();
            $renewals = $stmt->fetchAll(\PDO::FETCH_OBJ);

            if (empty($customers)) {
                return response()->json(['success' => false, 'message' => 'No customer found.']);
            }

            return response()->json(['success' => true, 'customer' => $customers[0], 'renewals' => $renewals]);
        } catch (\Exception $e) {
            Log::channel('internet')->error('Generate demand search error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Something went wrong.'], 500);
        }
    }

    public function generate(Request $request)
    {
        $request->validate([
            'Cust_Id'    => 'required|integer',
            'Renew_From' => 'required|date',
            'Renew_Upto' => 'required|date|after:Renew_From',
            'Package_Id' => 'nullable|integer',
        ]);

        try {
            $result = DB::select('CALL usp_generateDemandManual(?,?,?,?,?,?)', [
                $request->Cust_Id,
                $request->Renew_From,
                $request->Renew_Upto,
                session('user_id'),
                session('is_admin') == 1 ? null : session('counter_id'),
                $request->Package_Id ?: null,
            ]);

            $row = $result[0];
            if ($row->Error_No < 0) {
                return response()->json(['success' => false, 'message' => $row->Message]);
            }

            return response()->json(['success' => true, 'message' => $row->Message]);
        } catch (\Exception $e) {
            Log::channel('internet')->error('Generate demand error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to generate renewal.'], 500);
        }
    }
}
