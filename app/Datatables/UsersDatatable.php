<?php

namespace App\Datatables;

use App\Models\User;
use Yajra\DataTables\DataTableAbstract;
use Yajra\DataTables\Exceptions\Exception;

class UsersDatatable
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
        $users = User::with('roles')->select('*');

        return datatables()->of($users)
            ->addColumn('roles', function ($user) {
                return view('users.user-roles-table', [
                    'roles' => $user->roles->pluck('name')->toArray(),
                ]);
            })
            ->addColumn('actions', function ($user) {
                return view('users.actions', [
                    'user' => $user,
                ]);
            })
            ->addIndexColumn()
            ->order(function ($query) {
                $query->orderBy(request()->order[0]['name'] ?? 'id', request()->order[0]['dir'] ?? 'desc');
            });
    }
}
