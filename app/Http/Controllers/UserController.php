<?php

namespace App\Http\Controllers;

use App\Http\Resources\Employee;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Models\Department;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    public function index() {
        $users = User::query()->paginate(15);
        return view('employee.index', compact('users'));
    }

    public function sort(Request $request) {
        $column = $request->query('column');
        $direction = $request->query('direction');

        // dd($request->input());
        // dd($direction, $column);

        $users = User::query()->orderBy($column, $direction)->paginate(15);
        return view('employee.index', compact('users'));
    }

    public function getUserById($id) {
        // if (Gate::allows('update-user')) {
        $departments = Department::all();
        $user = User::query()->find($id);
        return view('employee.update', compact('user', 'departments'));
        // }
        // return redirect()->route('dashboard')->with('error', 'You do not have permission to continue');
    }

    public function update(Request $request) {

    }

    // public function age() {
    //     return Carbon::parse()
    // }
}
