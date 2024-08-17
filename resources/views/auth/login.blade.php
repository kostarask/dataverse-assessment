@extends('template')

@section('content')
    <section class="bg-light py-3 py-md-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5 col-xxl-4">
                    <div class="card border border-light-subtle rounded-3 shadow-sm">
                        <div class="card-body p-3 p-md-4 p-xl-5">
                            <h2 class="fs-6 fw-normal text-center text-secondary mb-4">{{ __('Sign in to your account') }}</h2>
                            <span class="text-danger validation-message" id="validation-error-message"></span>
                            <form action="javascript:void(0)" id="userLoginForm" name="userLoginForm" class="form-horizontal" method="POST" enctype="multipart/form-data">
                                <div class="row gy-2 overflow-hidden">
                                    <div class="col-12">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" name="username" id="username" placeholder="Username" required>
                                            <span class="text-danger validation-message" id="validation-error-username"></span>
                                            <label for="username" class="form-label">Username</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-floating mb-3">
                                            <input type="password" class="form-control" name="password" id="password" value="" placeholder="Password" required>
                                            <span class="text-danger validation-message" id="validation-error-password"></span>
                                            <label for="password" class="form-label">Password</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="d-grid my-3">
                                            <button class="btn btn-primary btn-lg" type="submit">Log in</button>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <p class="m-0 text-secondary text-center">Don't have an account? <a href="{{ route('user.registration') }}" class="link-primary text-decoration-none">Sign up</a></p>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop

<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script>
    $(document).ready( function () {
        let csrfToken = '{{ csrf_token() }}';

        $('#userLoginForm').submit(function (e) {
            e.preventDefault();

            let formData = new FormData(this);

            $.ajax({
                url: "{{ route('user.authenticate') }}",
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: (data) => {
                    window.location.replace(
                        data.intended
                    );
                },
                error: function (error) {
                    let validationErrors = error.responseJSON.errors;
                    $('#username').removeClass('is-invalid').addClass('is-valid');
                    $('.validation-message').text('');

                    for (let validationError in validationErrors) {
                        console.log(validationError)
                        console.log(validationErrors[validationError][0])
                        $("#" + validationError).addClass('is-invalid');
                        $("#validation-error-" + validationError).text(validationErrors[validationError][0]);
                    }
                }
            });
        });
    });
</script>
