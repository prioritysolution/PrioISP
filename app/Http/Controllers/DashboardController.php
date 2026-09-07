<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PDO;

class DashboardController extends Controller
{
    public function index()
    {
        try {
            if (session('is_admin') == 1) {
                return $this->adminDashboard();
            }

            return $this->counterDashboard();
        } catch (\Exception $e) {
            Log::channel('internet')->error('Dashboard error: ' . $e->getMessage());
            return view(session('is_admin') == 1 ? 'Dashboard.admindashboard' : 'Dashboard.dashboard', [
                'kpi' => (object) [],
                'recentCollections' => [],
                'counterCollections' => [],
                'counters' => [],
                'recentReceipts' => [],
                'unpaidDemands' => [],
            ]);
        }
    }

    public function recentCollections(Request $request)
    {
        if ((int) session('is_admin') !== 1) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $filter = (int) $request->input('filter', 0);

        try {
            $rows = DB::select('CALL usp_getAdminRecentCollections(?)', [$filter]);
            return response()->json(['success' => true, 'rows' => $rows]);
        } catch (\Exception $e) {
            Log::channel('internet')->error('Recent collections filter error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to load collections.'], 500);
        }
    }

    private function adminDashboard()
    {
        $pdo = DB::getPdo();
        $stmt = $pdo->prepare('CALL usp_getAdminDashboard()');
        $stmt->execute();

        $kpiRows = $stmt->fetchAll(PDO::FETCH_OBJ);
        $kpi = $kpiRows[0] ?? (object) [];

        $stmt->nextRowset();
        $recentCollections = $stmt->fetchAll(PDO::FETCH_OBJ);

        $stmt->nextRowset();
        $counterCollections = $stmt->fetchAll(PDO::FETCH_OBJ);
        $stmt->closeCursor();

        $maxColl = 0;
        foreach ($counterCollections as $row) {
            $maxColl = max($maxColl, (float) $row->Coll_Amt);
        }
        foreach ($counterCollections as $row) {
            $row->Bar_Pct = $maxColl > 0 ? round(((float) $row->Coll_Amt / $maxColl) * 100) : 0;
        }

        $counters = DB::select('SELECT Counter_Id, Counter_Name FROM mst_counter WHERE Is_Active = 1 ORDER BY Counter_Name');

        return view('Dashboard.admindashboard', compact('kpi', 'recentCollections', 'counterCollections', 'counters'));
    }

    private function counterDashboard()
    {
        $counterId = (int) (session('counter_id') ?: 0);

        if ($counterId && !session('counter_name')) {
            $ctr = DB::selectOne(
                'SELECT Counter_Name FROM mst_counter WHERE Counter_Id = ? LIMIT 1',
                [$counterId]
            );
            if ($ctr) {
                session(['counter_name' => $ctr->Counter_Name]);
            }
        }

        $pdo = DB::getPdo();
        $stmt = $pdo->prepare('CALL usp_getCounterDashboard(?)');
        $stmt->execute([$counterId]);

        $kpiRows = $stmt->fetchAll(PDO::FETCH_OBJ);
        $kpi = $kpiRows[0] ?? (object) [];

        $stmt->nextRowset();
        $recentReceipts = $stmt->fetchAll(PDO::FETCH_OBJ);

        $stmt->nextRowset();
        $unpaidDemands = $stmt->fetchAll(PDO::FETCH_OBJ);
        $stmt->closeCursor();

        return view('Dashboard.dashboard', compact('kpi', 'recentReceipts', 'unpaidDemands'));
    }
}
