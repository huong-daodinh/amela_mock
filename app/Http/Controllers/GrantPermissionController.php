<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserPermission;
use App\Models\Permission;

class GrantPermissionController extends Controller
{
    public function index(Request $request) {
        $query = User::query();
        $column = $request->query('column');
        $direction = $request->query('direction');
        $search = $request->input('search');
        $query->search($request->input('search'));

        if (isset($column) && isset($direction)) {
            $query->orderBy($column, $direction);
        }

        $users = $query->paginate(15)->appends(['search' => $search])->appends($request->query());
        return view('grant_permission.index', compact('users'));
    }

    public function show($id) {
        $user = User::find($id);
        $permissions = Permission::all();
        $userPermissions = [];
        foreach($user->permissions()->get() as $item) {
            $userPermissions[] = $item->id;
        }
        // dd($permissions);
        return view('grant_permission.grant', compact('user', 'permissions', 'userPermissions'));
    }

    public function grant(Request $request, $id) {
        $permissionRecords = Permission::all();
        $dataMap = [];
        foreach($permissionRecords as $record) {
            $dataMap[$record->name] = $record->id;
        }
        // dd($dataMap);
        // $permissionInput = ;
        //* quyền admin chỉnh sửa
        $permissions = array_slice(array_keys($request->input()), 1);

        $user = User::find($id);
        // *quyền người dùng đang có
        $userPermissions = [];
        foreach($user->permissions()->get() as $item) {
            $userPermissions[] = $item->name;
        }
        // dd($permissions, $userPermissions);

        if (!empty($permissions)) {
            //* thêm quyền mới
            foreach($permissions as $permission) {
                if (!in_array($permission, $userPermissions)) {
                    // echo 'Quyền mới ' . $permission . ', id: ' . $dataMap[$permission] . '</br>';
                    UserPermission::create([
                        'user_id' => $user->id,
                        'permission_id' => $dataMap[$permission],
                    ]);
                }
            }
            // * xoá quyền cũ đã có
            foreach($userPermissions as $userPermission) {
                if (!in_array($userPermission, $permissions)) {
                    // echo 'Quyền cũ ' . $userPermission . ', id: ' . $dataMap[$userPermission] . '</br>';
                    $record = UserPermission::where([
                        ['user_id', '=', $user->id],
                        ['permission_id', '=', $dataMap[$userPermission]],
                    ])->first();
                    $record->delete();
                }
            }
        }
        return redirect()->route('permission.index')->with('success', 'Action performed successfully');
    }
}
