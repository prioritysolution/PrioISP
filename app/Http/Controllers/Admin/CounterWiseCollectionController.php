<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CounterWiseCollectionController extends Controller
{
    public function index()
    {
        $counters = DB::select('CALL usp_getCounter(?)', [0]);
        return view('Admin.counter-wise-collection', compact('counters'));
    }

    public function data(Request $request)
    {
        $request->validate([
            'from_date'  => 'required|date',
            'to_date'    => 'required|date|after_or_equal:from_date',
            'counter_id' => 'required|integer',
        ]);

        try {
            $result = DB::select('CALL usp_getCounterWiseCollection(?, ?, ?)', [
                $request->from_date,
                $request->to_date,
                $request->counter_id,
            ]);

            return response()->json(['success' => true, 'data' => $result]);
        } catch (\Exception $e) {
            Log::channel('internet')->error('Counter wise collection error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Something went wrong.'], 500);
        }
    }
}
