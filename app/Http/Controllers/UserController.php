<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\CreateUserRequest;
use Illuminate\Support\Facades\File;

use function PHPUnit\Framework\fileExists;

class UserController extends Controller
{
    public function index(Request $request) {
        $search = $request->input('search');
        $query = User::query();
        $column = $request->query('column');
        $direction = $request->query('direction');

        if (Gate::allows('admin')) {
            $query->search($search);
        }
        else {
            $query->where('is_admin', '=', '0')->search($search);
        }

        if (isset($column) && isset($direction)) {
            $query->orderBy($column, $direction);
        }
        $users = $query->paginate(15)->appends(['search' => $search])->appends($request->query());
        return view('employee.index', compact('users'));
    }

    public function getUserById($id) {
        if (Gate::allows('update-user')) {
            $departments = Department::all();
            $user = User::query()->find($id);
            return view('employee.update', compact('user', 'departments'));
        }
        return redirect()->route('employee')->with('error', 'You dont have permission to perform this action');
    }

    public function profile($id) {
        $user = User::find($id);
        return view('employee.profile', compact('user'));
    }

    public function create() {
        if (Gate::allows('admin')) {
            $departments = Department::all();
            return view('employee.create', compact('departments'));
        }
        return redirect()->back()->with('error', 'You dont have permission to perform this action');
    }

    public function store(CreateUserRequest $request) {
        $validated_data = $request->validated();
        dd($validated_data);
    }

    public function update(UpdateUserRequest $request, $id) {
        $user = User::query()->find($id);
        $validated_data = $request->validated();
        if (isset($validated_data['avatar'])) {
            if ($user->avatar) {
                if (fileExists(public_path('storage/avatars/' . $user->avatar))) {
                    File::delete(public_path('storage/avatars/' . $user->avatar));
                }
            }
            $file = $validated_data['avatar'];
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $path = $request->file('avatar')->storeAs('avatars', $fileName, 'public');
            $user->avatar = $fileName;
        }
        $user->name = $validated_data['name'];
        $user->email = $validated_data['email'];
        $user->date_of_birth = $validated_data['date_of_birth'];
        $user->gender = $validated_data['gender'];
        $user->department_id = $validated_data['department'];
        $user->save();
        return redirect()->route('employee')->with('success', 'Employee updated successfully');
    }
}
