@extends('template')

@section('content')

    <div class="container m-t-5">
        <div class="card-header">
           <h2>{{ __('Roles') }}</h2>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-12 margin-tb">
                    <div class="pull-right mb-2">
                        <a class="btn btn-success " onClick="add()" href="javascript:void(0)">{{ __("Create Role") }} </a>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table id="roles-table" class="table table-striped table-vmiddle table-bordered">
                    <thead>
                    <tr>
                        <th>{{ __('ID') }}</th>
                        <th>{{ __('Name') }}</th>
                        <th>{{ __('Active') }}</th>
                        <th>{{ __('Created At') }}</th>
                        <th>{{ __('Actions') }}</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    @include('roles.create_modal')
@stop

<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdn.datatables.net/2.1.3/js/dataTables.js"></script>
<script>

    $(document).ready(function() {
        let oTable = $('#roles-table').DataTable({
            processing: true,
            serverSide: true,
            filter: true,
            ajax: {
                url: '{!! route('roles.getDatatableData', Request::all()) !!}',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            },
            columnDefs: [{
                targets: [0],
                visible: false,
                searchable: false
            }],
            columns: [
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'is_active', name: 'is_active'},
                {data: 'created_at', name: 'created_at'},
                {data: 'actions', name: 'actions'}
            ],
            order: [[0, 'desc']]
        });
    });

    function add(){
        $('#role-create').trigger("reset");
        $('#role-create-modal').modal('show');
        $('#id').val('');
    }

</script>
