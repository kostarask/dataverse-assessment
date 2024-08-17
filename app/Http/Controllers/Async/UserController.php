<?php

namespace App\Http\Controllers\Async;

use App\Datatables\UsersDatatable;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Exceptions\Exception;

class UserController extends Controller
{
    /**
     * @throws Exception
     */
    public function getDatatableData()
    {
        return (new UsersDatatable())->json();
    }
}
