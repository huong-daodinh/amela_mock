<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Resources\v1\UserResource;
use App\Http\Resources\v1\UserCollection;
use App\Filters\v1\UserFilter;
use App\Http\Requests\v1\StoreUserRequest;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // dd($request->query('name'));
        $filter = new UserFilter();
        $filterItems = $filter->transform($request);

        $includeDepartment = $request->query('includeDepartment');
        // dd($filterItems);
        // dd($includeDepartment);
        $user = User::query()->where($filterItems);
        if ($includeDepartment) {
            $user = $user->with('department');
        }
        return new UserCollection($user->paginate(5)->appends($request->query()));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        return new UserResource(User::create($request->all()));
        // return ['message' => 'success'];
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::find($id);
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
