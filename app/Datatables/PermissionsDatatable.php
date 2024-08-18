<?php

namespace App\Datatables;

use App\Models\Permission;
use Yajra\DataTables\DataTableAbstract;
use Yajra\DataTables\Exceptions\Exception;

class PermissionsDatatable
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
        $permissions = Permission::select('*');

        return datatables()->of($permissions)
            ->addColumn('actions', function ($permission) {
                return view('permissions.actions', [
                    'permission' => $permission,
                ]);
            })
            ->addColumn('created_at', function ($permission) {
                return $permission->created_at->format('Y-m-d H:i:s');
            })
            ->addIndexColumn()
            ->order(function ($query) {
                $query->orderBy(request()->order[0]['name'] ?? 'id', request()->order[0]['dir'] ?? 'desc');
            });
    }
}
