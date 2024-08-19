<a href="{{ route('role.edit', $role->id) }}" data-toggle="tooltip" data-original-title="Edit" class="btn btn-success @cannot('update', $role) disabled @endcannot">
    {{ __("Edit") }}
</a>
<a href="javascript:void(0)" data-url="{{ route('role.delete', $role->id) }}" data-toggle="tooltip" class="btn btn-danger delete-role-button @cannot('delete', $role) disabled @endcannot">
    {{ __("Delete") }}
</a>

<script type="text/javascript">
    $(document).ready(function() {

        let csrfToken = '{{ csrf_token() }}';

        $(document).on('click', '.delete-role-button', function() {

            let roleDeleteURL = $(this).data('url');
            let flashSuccess = $(".flash-notification-success");
            let flashError = $(".flash-notification-error");

            if (confirm("Are you sure you want to delete this role?") === true) {
                $.ajax({
                    url: roleDeleteURL,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    dataType: 'json',
                    success: function(data) {

                        $('#roles-table').DataTable().ajax.reload();
                        if (data.success) {

                            flashSuccess.text(data.message).show(data.message);
                            flashSuccess.fadeTo(2000, 500).slideUp(500, function(){
                                flashSuccess.slideUp(500);
                            });
                        } else {
                            flashError.text(data.message).show(data.message);
                            flashError.fadeTo(2000, 500).slideUp(500, function(){
                                flashError.slideUp(500);
                            });

                        }
                    },
                    error: function (error) {
                        let responseError = error.responseJSON;
                        let message = responseError['message'];
                        flashError.text(message).show(message);
                        flashError.fadeTo(2000, 500).slideUp(500, function(){
                            flashError.slideUp(500);
                        });
                    }
                });
            }

        });

    });
</script>
