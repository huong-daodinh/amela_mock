<?php

namespace App\Http\Controllers;

use App\Http\Resources\Employee;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    public function index() {
        if (Gate::allows('admin')) {
            $users = User::query()->paginate(15);
        } else {
            $users = User::query()->where('is_admin', 0)->paginate(15);
        }
        return view('employee.index', compact('users'));
    }

    public function sort(Request $request) {
        $column = $request->query('column');
        $direction = $request->query('direction');
        $users = User::query()->orderBy($column, $direction)->paginate(15);
        $users->appends(['column' => $column, 'direction' => $direction]);
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

    public function update(UpdateUserRequest $request, $id) {
        $user = User::query()->find($id);
        // save: $path = $request->file('avatar')->store('avatars'); // 12222222121.jpg
        // dd(file_get_contents($file->getRealPath()));
        $validated_data = $request->validated();
        // dd($validated_data);
        if (isset($validated_data['avatar'])) {
            if ($user->avatar) {
                Storage::delete(asset('storage/avatars/' . $user->avatar));
            }
            $file = $validated_data['avatar'];
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $path = $request->file('avatar')->storeAs('avatars', $fileName, 'public');
            $user->avatar = $fileName;
        }
        $user->name = $validated_data['name'];
        $user->email = $validated_data['email'];
        if (isset($validated_data['password'])) {
            $user->password = Hash::make($validated_data['password']);
        }
        $user->date_of_birth = $validated_data['date_of_birth'];
        $user->gender = $validated_data['gender'];
        $user->department_id = $validated_data['department'];
        $user->save();
        return redirect()->route('employee')->with('success', 'Employee updated successfully');
    }
}
