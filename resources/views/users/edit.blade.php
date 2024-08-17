@extends('template')

@section('content')

    <div class="container m-t-5">
        <div class="card-header">
            <h2>{{ __('Edit User') }}</h2>
        </div>
        <div class="card-body">
            @include('users.form', ['form_id_name' => 'editUserForm'])
        </div>
    </div>
@stop
