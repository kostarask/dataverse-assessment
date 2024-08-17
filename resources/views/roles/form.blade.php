<form action="javascript:void(0)" id="{{ $form_id_name }}" name="{{ $form_id_name }}" class="form-horizontal" method="POST" enctype="multipart/form-data">
    <div class="row gy-2 overflow-hidden">
        <input type="hidden" name="id" value="{{ isset($role) ? $role->id : null}}"/>
        <div class="col-12">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="0" id="is_active" {{ (isset($role) && $role->is_active) ? 'checked' : ''}}>
                <span class="text-danger validation-message" id="validation-error-is_active"></span>
                <label class="form-check-label" for="is_active">
                    Active
                </label>
            </div>
        </div>
        <div class="col-12">
            <div class="form-floating mb-3">
                <div class="col-sm-12">
                    <label class="form-control-label">{{ __('Name') }}</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ isset($role) ? $role->name : "" }}" placeholder="Enter Name" maxlength="50">
                    <span class="text-danger validation-message" id="validation-error-name"></span>
                </div>
            </div>
        </div>
        <div class="col-sm-offset-2 col-sm-10"><br/>
            <button type="submit" class="btn btn-primary" id="btn-save">Submit</button>
        </div>
    </div>
</form>

<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdn.datatables.net/2.1.3/js/dataTables.js"></script>

<script>

    let flashSuccess = $(".flash-notification-success");
    let flashError = $(".flash-notification-error");

    let csrfToken = '{{ csrf_token() }}';
    let oTable = $('#roles-table').DataTable({
        processing: true,
        serverSide: true,
        filter: true,
        ajax: {
            url: '{!! route('roles.getDatatableData', Request::all()) !!}',
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            }
        },
        columnDefs: [{
            targets: [0],
            visible: false,
            searchable: false
        }],
        columns: [
            { data: 'id', name:'id' },
            { data: 'name', name:'name' },
            { data: 'is_active', name:'is_active' },
            { data: 'actions', name:'actions' }
        ],
        order: [[0, 'desc']]
    });


    $('#createRoleForm').submit(function(e) {
        e.preventDefault();

        let formData = new FormData(this);
        let isChecked = $('#is_active').is(':checked');
        formData.append('is_active', isChecked ? 1 : 0);
        $.ajax({
            url: "{{ route('role.store') }}",
            type:'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            data: formData,
            cache:false,
            contentType: false,
            processData: false,
            success: (data) => {
                $("#role-create-modal").modal('hide');
                oTable.draw(false);
                $("#btn-save").html('Submit');
                $("#btn-save").attr("disabled", false);

                if (data.success) {
                    flashSuccess.text(data.message).show(data.message);
                    flashSuccess.fadeTo(2000, 500).slideUp(500, function () {
                        flashSuccess.slideUp(500);
                    });
                } else{
                    flashError.text(data.message).show(data.message);
                    flashError.fadeTo(2000, 500).slideUp(500, function(){
                        flashError.slideUp(500);
                    });
                }
            },
            error: function(error){
                let validationErrors = error.responseJSON.errors;
                $('.is-invalid').removeClass('is-invalid').addClass('is-valid');
                $('.validation-message').text('');

                for (let validationError in validationErrors) {
                    $("#" + validationError).addClass('is-invalid');
                    $("#validation-error-" + validationError).text(validationErrors[validationError][0]);
                }
            }
        });
    });

    $('#editRoleForm').submit(function(e) {
        e.preventDefault();

        let formData = new FormData(this);
        let isChecked = $('#is_active').is(':checked');
        formData.append('is_active', isChecked ? 1 : 0);
        $.ajax({
            url: "{{ route('role.update', $role ?? '') }}",
            type:'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            data: formData,
            cache:false,
            contentType: false,
            processData: false,
            success: (data) => {
                if (data.success) {
                    flashSuccess.text(data.message).show(data.message);
                    flashSuccess.fadeTo(2000, 500).slideUp(500, function () {
                        flashSuccess.slideUp(500);
                    });
                } else{
                    flashError.text(data.message).show(data.message);
                    flashError.fadeTo(2000, 500).slideUp(500, function(){
                        flashError.slideUp(500);
                    });
                }
            },
            error: function(error){
                let validationErrors = error.responseJSON.errors;
                $('.is-invalid').removeClass('is-invalid').addClass('is-valid');
                $('.validation-message').text('');

                for (let validationError in validationErrors) {
                    $("#" + validationError).addClass('is-invalid');
                    $("#validation-error-" + validationError).text(validationErrors[validationError][0]);
                }
            }
        });
    });
</script>
