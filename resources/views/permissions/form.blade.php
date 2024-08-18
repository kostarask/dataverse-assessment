<form action="javascript:void(0)" id="{{ $form_id_name }}" name="{{ $form_id_name }}" class="form-horizontal" method="POST" enctype="multipart/form-data">
    <div class="row gy-2 overflow-hidden">
        <input type="hidden" name="id" value="{{ isset($permission) ? $permission->id : null}}"/>
        <div class="col-12">
            <div class="form-floating mb-3">
                <div class="col-sm-12">
                    <label class="form-control-label">{{ __('Name') }}</label>
                    <input type="text" class="form-control " id="name" name="name" value="{{ isset($permission) ? $permission->name : "" }}" placeholder="Enter Name" maxlength="50" {{ isset($permission) ? "disabled" : "" }}>
                    <span class="text-danger validation-message" id="validation-error-name"></span>
                </div>
            </div>
        </div>
        <label class="form-control-label">{{ __('Roles') }}</label>
        @foreach($roles as $role)
            <div class="col-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="{{ $role->id }}" name="roles[]" id="roles[{{ $role->id }}]" {{ isset($permission) && $permission?->roles?->contains($role) ? 'checked' : ''}}>
                    <label class="form-check-label" for="roles[{{ $role->id }}]">
                        {{ __($role->name) }}
                    </label>
                </div>
            </div>
        @endforeach
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

    $('#createPermissionForm').submit(function(e) {
        e.preventDefault();

        let formData = new FormData(this);

        $.ajax({
            url: "{{ route('permission.store') }}",
            type:'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            data: formData,
            cache:false,
            contentType: false,
            processData: false,
            success: (data) => {
                $("#permission-create-modal").modal('hide');
                $('#permissions-table').DataTable().ajax.reload();
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

    $('#editPermissionForm').submit(function(e) {
        e.preventDefault();

        let formData = new FormData(this);

        $.ajax({
            url: "{{ route('permission.update', $permission ?? '') }}",
            type:'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
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
