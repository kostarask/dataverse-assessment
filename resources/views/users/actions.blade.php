<a href="{{ route('user.edit', $user->id) }}" data-toggle="tooltip" data-original-title="Edit" class="edit btn btn-success edit">
    {{ __("Edit") }}
</a>
<a href="javascript:void(0)" data-url="{{ route('user.delete', $user->id) }}" data-toggle="tooltip" class="btn btn-danger delete-user-button">
    {{ __("Delete") }}
</a>

<script type="text/javascript">
    $(document).ready(function() {

        let csrfToken = '{{ csrf_token() }}';

        $(document).on('click', '.delete-user-button', function() {

            let userDeleteURL = $(this).data('url');
            let flashSuccess = $(".flash-notification-success");
            let flashError = $(".flash-notification-error");

            if (confirm("Are you sure you want to delete this user?") === true) {
                $.ajax({
                    url: userDeleteURL,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    dataType: 'json',
                    success: function(data) {
                        console.log(data);
                        $('#users-table').DataTable().ajax.reload();
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
                        flashError.text(error.message).show(error.message);
                        flashError.fadeTo(2000, 500).slideUp(500, function(){
                            flashError.slideUp(500);
                        });
                    }
                });
            }

        });

    });
</script>
