<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleRequest;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', Role::class);

        $with = [
            'roles' => Role::all(),
            'permissions' => Permission::all(),
        ];

        return view('roles.index', $with);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoleRequest $request)
    {
        $formData = Arr::except($request->validated(), 'permissions');
        $permissions = $request->validated()['permissions'] ?? null;

        try{
            Gate::authorize('create', Role::class);
            DB::beginTransaction();

            $role = Role::create($formData);
            $role->permissions()->sync($permissions);

            DB::commit();
        }catch (\Exception $e){
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()]);
        }

        return response()->json(['success' => true, 'message' => 'Role created successfully'], 201);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        Gate::authorize('update', $role);
        $with = [
            'role' => $role,
            'permissions' => Permission::all(),
        ];

        return view('roles.edit', $with);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RoleRequest $request, Role $role)
    {
        $formData = Arr::except($request->validated(), 'permissions');
        $permissions = $request->validated()['permissions'] ?? null;

        try{
            Gate::authorize('update', $role);
            DB::beginTransaction();

            $role->update($formData);
            $role->permissions()->sync($permissions);

            DB::commit();
        }catch (\Exception $e){
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()]);
        }

        return response()->json(['success' => true, 'message' => 'Role updated successfully'], 201);    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        try{
            Gate::authorize('delete', $role);
            DB::beginTransaction();

            $role->users()->detach();
            $role->permissions()->detach();
            $role->delete();

            DB::commit();
        }catch (AuthorizationException $authorizationException){
            DB::rollBack();
            return response()->json(['message' => $authorizationException->getMessage()], $authorizationException->getCode());
        }catch (QueryException $queryException){
            DB::rollBack();
            return response()->json(['message' => $queryException->getMessage()], 500);
        }catch (\Exception $e){
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()]);
        }

        return response()->json(['success' => true, 'message' => 'Role deleted successfully'], 201);
    }
}
