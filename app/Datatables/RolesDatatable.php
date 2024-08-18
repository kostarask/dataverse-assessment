<?php

namespace App\Datatables;

use App\Models\Role;
use Yajra\DataTables\DataTableAbstract;
use Yajra\DataTables\Exceptions\Exception;

class RolesDatatable
{
    /**
     * @throws Exception
     */
    public function json()
    {
        return $this->datatable()->make(true);
    }

    /**
     * @throws Exception
     */
    protected function datatable(): DataTableAbstract
    {
        $roles = Role::select('*');

        return datatables()->of($roles)
            ->addColumn('actions', function ($role) {
                return view('roles.actions', [
                    'role' => $role,
                ]);
            })
            ->addColumn('created_at', function ($role) {
                return $role->created_at->format('Y-m-d H:i:s');
            })
            ->addIndexColumn()
            ->order(function ($query) {
                $query->orderBy(request()->order[0]['name'] ?? 'id', request()->order[0]['dir'] ?? 'desc');
            });
    }
}
