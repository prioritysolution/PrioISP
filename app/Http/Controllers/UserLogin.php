<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Exception;

class UserLogin extends Controller
{
    public function login_index()
    {
        return view('Auth.login');
    }

    public function forgot_pass_index()
    {
        return view('Auth.forgot-pass');
    }

    public function process_login(Request $request)
    {
        $request->validate([
            'pUser_Name' => 'required',
            'pUser_Pass' => 'required'
        ]);

        try {
            $result = DB::select("CALL USP_PUSH_USER_LOGIN(?)", [$request->pUser_Name]);

            $row = $result[0];

            if ($row->Error_No < 0) {
                return response()->json(['status' => 'error', 'message' => $row->Message], 200);
            }

            if (!Hash::check($request->pUser_Pass, $row->Usr_Pwd)) {
                return response()->json(['status' => 'error', 'message' => 'Invalid Password Entered !!'], 200);
            }

            $counterName = null;
            if (!empty($row->Counter_Id)) {
                $ctr = DB::selectOne(
                    'SELECT Counter_Name FROM mst_counter WHERE Counter_Id = ? LIMIT 1',
                    [$row->Counter_Id]
                );
                $counterName = $ctr->Counter_Name ?? null;
            }

            session([
                'user_id'   => $row->User_Id,
                'user_name' => $row->User_Name,
                'full_name' => $row->Full_Name,
                'is_admin'  => $row->Is_Admin,
                'counter_id' => $row->Counter_Id,
                'counter_name' => $counterName,
                'is_login'  => true
            ]);

            request()->session()->regenerate();

            $redirect = '/dashboard';

            return response()->json(['status' => 'success', 'message' => 'Login Successfully', 'redirect' => $redirect], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    public function logout()
    {
        session()->flush();
        return redirect()->route('login');
    }

}
