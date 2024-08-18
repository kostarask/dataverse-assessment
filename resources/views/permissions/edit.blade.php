@extends('template')

@section('content')
    <div class="container m-t-5">
        <div class="card-header">
            <h2>{{ __('Edit Permission') }}</h2>
        </div>
        <div class="card-body">
            @include('permissions.form', ['form_id_name' => 'editPermissionForm'])
        </div>
    </div>
@stop
