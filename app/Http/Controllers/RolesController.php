<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $with = [
            'roles' => Role::all(),
        ];

        return view('roles.index', $with);
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
    public function store(RoleRequest $request)
    {
        $formData = $request->validated();

        try{
            DB::beginTransaction();

            Role::create($formData);

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
        $with = [
            'role' => $role,
        ];

        return view('roles.edit', $with);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RoleRequest $request, Role $role)
    {
        $formData = $request->validated();

        try{
            DB::beginTransaction();

            $role->update($formData);

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
            DB::beginTransaction();

            $role->users()->detach();
            $role->delete();

            DB::commit();
        }catch (\Exception $e){
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()]);
        }

        return response()->json(['success' => true, 'message' => 'Role deleted successfully'], 201);
    }
}
