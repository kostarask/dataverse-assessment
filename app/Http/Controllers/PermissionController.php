<?php

namespace App\Http\Controllers;

use App\Http\Requests\PermissionRequest;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', Permission::class);
        $with = [
            'permissions' => Permission::all(),
            'roles' => Role::all()
        ];

        return view('permissions.index', $with);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PermissionRequest $request)
    {
        $formData = Arr::except($request->validated(), 'roles');
        $roles = $request->validated()['roles'] ?? null;

        try{
            Gate::authorize('create', Permission::class);
            DB::beginTransaction();

            $permission = Permission::create($formData);
            $permission->roles()->sync($roles);

            DB::commit();
        }catch (\Exception $e){
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()]);
        }

        return response()->json(['success' => true, 'message' => 'Permission created successfully'], 201);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Permission $permission)
    {
        Gate::authorize('update', $permission);
        $with = [
            'permission' => $permission,
            'roles' => Role::all(),
        ];

        return view('permissions.edit', $with);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PermissionRequest $request, Permission $permission)
    {
        $roles = $request->validated()['roles'] ?? null;

        try{
            Gate::authorize('update', $permission);
            DB::beginTransaction();

            $permission->roles()->sync($roles);

            DB::commit();
        }catch (\Exception $e){
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()]);
        }

        return response()->json(['success' => true, 'message' => 'Permission updated successfully'], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission)
    {
        try{
            Gate::authorize('delete', $permission);
            DB::beginTransaction();

            $permission->roles()->detach();
            $permission->delete();

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

        return response()->json(['success' => true, 'message' => 'Permission deleted successfully'], 201);
    }
}
