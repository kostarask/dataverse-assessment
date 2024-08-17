<?php

namespace App\Http\Controllers\Async;

use App\Datatables\RolesDatatable;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Exceptions\Exception;

class RoleController extends Controller
{
    /**
     * @throws Exception
     */
    public function getDatatableData()
    {
        return (new RolesDatatable())->json();
    }
}
