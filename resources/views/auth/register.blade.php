@extends('template')

@section('content')
    <section class="bg-light py-3 py-md-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5 col-xxl-4">
                    <div class="card border border-light-subtle rounded-3 shadow-sm">
                        <div class="card-body p-3 p-md-4 p-xl-5">
                            <h2 class="fs-6 fw-normal text-center text-secondary mb-4">Enter your details to register</h2>
                            <form action="javascript:void(0)" id="userCreateForm" name="userCreateForm" class="form-horizontal" method="POST" enctype="multipart/form-data">
                                <div class="row gy-2 overflow-hidden">
                                    <div class="col-12">
                                        <div class="form-floating mb-3">
                                            <div class="col-sm-12">
                                                <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" maxlength="50">
                                                <span class="text-danger validation-message" id="validation-error-name"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-floating mb-3">
                                            <div class="col-sm-12">
                                                <input type="text" class="form-control" id="username" name="username" placeholder="Enter Username" required="">
                                                <span class="text-danger validation-message" id="validation-error-username"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-floating mb-3">
                                            <div class="col-sm-12">
                                                <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password" required="">
                                                <span class="text-danger validation-message" id="validation-error-password"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-floating mb-3">
                                            <div class="col-sm-12">
                                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password" >
                                                <span class="text-danger validation-message" id="validation-error-password_confirmation"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-floating mb-3">
                                            <div class="col-sm-12">
                                                <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email" maxlength="50" required="">
                                                <span class="text-danger validation-message" id="validation-error-email"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-offset-2 col-sm-10"><br/>
                                        <button type="submit" class="btn btn-primary" id="btn-save">Submit</button>
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
        $('#userCreateForm').submit(function (e) {
            e.preventDefault();
            console.log('adasda');
            let formData = new FormData(this);
            formData.append('is_active', 1);
            $.ajax({
                url: "{{ route('user.register') }}",
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
                    $('.form-control').removeClass('is-invalid').addClass('is-valid');
                    $('.validation-message').text('');

                    for (let validationError in validationErrors) {
                        $("#" + validationError).addClass('is-invalid');
                        $("#validation-error-" + validationError).text(validationErrors[validationError][0]);
                    }
                }
            });
        });
    });
</script>
