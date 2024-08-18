<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', User::class);
        $with = [
            'users' => User::all(),
            'roles' => Role::all(),
        ];

        return view('users.index', $with);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        $formData = Arr::except($request->validated(), 'roles');
        $roles = $request->validated()['roles'] ?? null;

        try{
            Gate::authorize('create', User::class);
            DB::beginTransaction();

            $user = User::create($formData);
            $user->roles()->sync($roles);

            DB::commit();
        }catch (\Exception $e){
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()]);
        }

        return response()->json(['success' => true, 'message' => 'User created successfully'], 201);
    }

    public function edit(User $user)
    {
        $with = [
            'user' => $user,
            'roles' => Role::all(),
        ];

        return view('users.edit', $with);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, User $user)
    {
        $formData = Arr::except($request->validated(), 'roles');
        $roles = $request->validated()['roles'] ?? null;

        try{
            Gate::authorize('update', $user);
            DB::beginTransaction();

            $user->update($formData);
            $user->roles()->sync($roles);

            DB::commit();
        }catch (\Exception $e){
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()]);
        }

        return response()->json(['success' => true, 'message' => 'User updated successfully'], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        try{
            Gate::authorize('delete', $user);
            DB::beginTransaction();

            $user->roles()->detach();
            $user->delete();

            DB::commit();
        }catch (\Exception $e){
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()]);
        }

        return response()->json(['success' => true, 'message' => 'User deleted successfully'], 201);
    }
}
