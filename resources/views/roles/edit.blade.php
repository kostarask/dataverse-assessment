@extends('template')

@section('content')
    <div class="container m-t-5">
        <div class="card-header">
            <h2>{{ __('Edit Role') }}</h2>
        </div>
        <div class="card-body">
            @include('roles.form', ['form_id_name' => 'editRoleForm'])
        </div>
    </div>
@stop
