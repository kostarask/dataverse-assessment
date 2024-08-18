<?php

namespace App\Http\Controllers;

use App\Http\Requests\PermissionRequest;
use App\Http\Requests\UpdatePermissionRequest;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $with = [
            'permissions' => Permission::all(),
            'roles' => Role::all()
        ];

        return view('permissions.index', $with);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PermissionRequest $request)
    {
        $formData = Arr::except($request->validated(), 'roles');
        $roles = $request->validated()['roles'] ?? null;

        try{
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
        $formData = Arr::except($request->validated(), 'roles');
        $roles = $request->validated()['roles'] ?? null;

        try{
            DB::beginTransaction();

            $permission->update($formData);
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
            DB::beginTransaction();

            $permission->roles()->detach();
            $permission->delete();

            DB::commit();
        }catch (\Exception $e){
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()]);
        }

        return response()->json(['success' => true, 'message' => 'Permission deleted successfully'], 201);
    }
}
