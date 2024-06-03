@extends('front.layout.master')

@section('main')
        <section class=" p-3 p-md-4 p-xl-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12 col-md-9 col-lg-7 col-xl-6 col-xxl-5">
                        <div class="card border border-light-subtle rounded-4">
                            <div class="card-body p-3 p-md-4 p-xl-5">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="mb-5">
                                            <h4 class="text-center">Register Here</h4>
                                        </div>
                                    </div>

                                    @if(Session::has('success'))
                                    <p class="btn btn-success">{{ Session::get('success') }}</p>
                                    @endif
                                    @if(Session::has('error'))
                                    <p class="btn btn-danger">{{ Session::get('error') }}</p>
                                    @endif

                                </div>
                                <form action="" method="POST" name="registerForm" id="registerForm">
                                    @csrf
                                    <div class="row gy-3 overflow-hidden">
                                        <div class="col-12">
                                            <div class="form-floating mb-3">
                                                <input type="text" class="form-control" name="name" id="name" placeholder="Name" value="{{ old('name') }}" >
                                                <label for="text" class="form-label">Name</label>                                                
                                            </div>
                                            <div style="color: red" id="error_name"></div>                                          
                                        </div>
                                        <div class="col-12">
                                            <div class="form-floating mb-3">
                                                <input type="text" class="form-control" name="email" id="email" placeholder="name@example.com" value="{{ old('email') }}" >
                                                <label for="text" class="form-label">Email</label>
                                            </div>
                                            <div style="color: red" id="error_email"></div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-floating mb-3">
                                                <input type="password" class="form-control" name="password" id="password" value="" placeholder="Password" >
                                                <label for="password" class="form-label">Password</label>
                                            </div>
                                            <div style="color: red" id="error_password"></div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-floating mb-3">
                                                <input type="password" class="form-control" name="confirm_password" id="confirm_password" value="" placeholder="Confirm Password" >
                                                <label for="password" class="form-label">Confirm Password</label>
                                            </div>
                                            <div style="color: red" id="error_confirm_password"></div>
                                        </div>
                                        <div class="col-12">
                                            <div class="d-grid">
                                                <button class="btn bsb-btn-xl btn-primary py-3" type="submit">Register Now</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <div class="row">
                                    <div class="col-12">
                                        <hr class="mt-5 mb-4 border-secondary-subtle">
                                        <div class="d-flex gap-2 gap-md-4 flex-column flex-md-row justify-content-center">
                                            <a href="{{ route('account.login') }}" class="link-secondary text-decoration-none">Click here to login</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
@endsection


@section('customJs')

<script type="text/javascript">

    $("#registerForm").submit(function(e){
        e.preventDefault();

        $.ajax({
            url : "{{ route('account.registerProcess') }}",
            type : 'POST',
            data : $('#registerForm').serialize(),
            dataType : 'json',
            success:function(response){
                if(response.status == false){
                    var errors = response.errors
                    if(errors.name){
                        $('#error_name').html(errors.name[0]);
                    }else{
                        $('#error_name').html('');
                    }
                    if(errors.email){
                        $('#error_email').html(errors.email[0]);
                    }else{
                        $('#error_email').html('');
                    }
                    if(errors.password){
                        $('#error_password').html(errors.password[0]);
                    }else{
                        $('#error_password').html('');
                    }
                    if(errors.confirm_password){
                        $('#error_confirm_password').html(errors.confirm_password[0]);
                    }else{
                        $('#error_confirm_password').html('');
                    }
                }else{
                    window.location.href = "{{ route('account.login') }}";
                }
            }
        });
    })

</script>




@endsection
