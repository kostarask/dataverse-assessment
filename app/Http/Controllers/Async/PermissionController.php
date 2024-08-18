<?php

namespace App\Http\Controllers\Async;

use App\Datatables\PermissionsDatatable;
use App\Datatables\RolesDatatable;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Exceptions\Exception;

class PermissionController extends Controller
{
    /**
     * @throws Exception
     */
    public function getDatatableData()
    {
        return (new PermissionsDatatable())->json();
    }
}
