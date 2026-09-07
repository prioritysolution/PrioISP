<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserSetupController extends Controller
{
    public function index()
    {
        $pdo  = DB::getPdo();
        $stmt = $pdo->query('CALL usp_getUsers()');
        $users    = $stmt->fetchAll(\PDO::FETCH_OBJ);
        Log::channel('internet')->info('Stored procedure executed',['data are',$users]);
        $stmt->nextRowset();
        $counters = $stmt->fetchAll(\PDO::FETCH_OBJ);

        return view('Admin.user-setup', compact('users', 'counters'));
    }

    public function save(Request $request)
    {
        $isNew = !$request->filled('User_Id');

        $rules = [
            'Full_Name'  => 'required|string|max:50',
            'User_Name'  => 'required|string|max:50',
            'Is_Admin'   => 'required|in:0,1',
            'Is_Active'  => 'required|in:0,1',
            'User_Type'  => 'required|in:0,1,2',
            'Counter_Id' => 'required|integer',
        ];

        if ($isNew) {
            $rules['Password'] = 'required|string|min:6';
             $rules['Counter_Id'] = 'required|integer';
        } else {
            $rules['Password'] = 'nullable|string|min:6';
        }

        $request->validate($rules);

        try {
            $hashedPassword = '';
            if ($request->filled('Password')) {
                $hashedPassword = Hash::make($request->Password);
            }

            $result = DB::select('CALL usp_saveUser(?,?,?,?,?,?,?,?)', [
                $request->User_Id ?? 0,
                $request->Full_Name,
                $request->User_Name,
                $hashedPassword,
                $request->filled('Is_Admin') ? $request->Is_Admin : 0,
                $request->Is_Active,
                $request->User_Type,
                $request->Counter_Id ?? 0,
            ]);

            $row = $result[0];
            if ($row->Error_No < 0) {
                return response()->json(['success' => false, 'message' => $row->Message]);
            }

            return response()->json(['success' => true,
               'message' => $row->Message,
               'new_user_id' => $row->New_User_Id ?? null,
               'is_new'      => $isNew,
               ]);

        } catch (\Exception $e) {
            Log::channel('internet')->error('User save error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to save user.'], 500);
        }
    }

    public function delete(Request $request)
{
    $request->validate(['User_Id' => 'required|integer']);
    try {
        $result = DB::select('CALL usp_deleteUser(?)', [$request->User_Id]);
        $row = $result[0];
        if ($row->Error_No < 0) {
            return response()->json(['success' => false, 'message' => $row->Message]);
        }
        return response()->json(['success' => true, 'message' => $row->Message]);
    } catch (\Exception $e) {
        Log::channel('internet')->error('User delete error: ' . $e->getMessage());
        return response()->json(['success' => false, 'message' => 'Failed to delete user.'], 500);
    }
}


public function getMenus(Request $request)
{
    $allMenus  = DB::select('CALL usp_GetMenus()');
    $userMenus = DB::select('CALL usp_getUserMenus(?)', [$request->user_id]);
    $assigned  = collect($userMenus)->pluck('Menu_Sl')->toArray();

    // filter out admin-only menus
    $allMenus = collect($allMenus)
        ->filter(fn($m) => is_null($m->OnlyAdm))
        ->values();

    return response()->json([
        'success'  => true,
        'menus'    => $allMenus,
        'assigned' => $assigned,
    ]);
}

// add saveMenus()
public function saveMenus(Request $request)
{
    try {
        $result = DB::select('CALL usp_saveUserMenus(?, ?)', [
            $request->user_id,
            $request->menu_sls ?? '',
        ]);
        $row = $result[0];
        if ($row->Error_No < 0) {
            return response()->json(['success' => false, 'message' => $row->Message]);
        }
        return response()->json(['success' => true, 'message' => $row->Message]);
    } catch (\Exception $e) {
        Log::channel('internet')->error('Save user menus error: ' . $e->getMessage());
        return response()->json(['success' => false, 'message' => 'Failed to save menus.'], 500);
    }
}
}
