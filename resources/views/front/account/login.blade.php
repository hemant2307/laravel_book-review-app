
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
                                  <h4 class="text-center">Login Here</h4><br>
                                  @if(Session::has('success'))
                                  <div style="color: rgb(100, 24, 192)" >{{ Session::get('success') }}</div>
                                   @endif
                                   @if(Session::has('error'))
                                   <div style="color: rgb(236, 16, 16),font-size: 30px" >{{ Session::get('error') }}</div>
                                    @endif
                              </div>                            
                          </div>                        
                      </div>
                      <form action="" method="" id="loginForm" name="loginForm">
                        @csrf
                          <div class="row gy-3 overflow-hidden">
                              <div class="col-12">
                                  <div class="form-floating mb-3">
                                      <input type="email" class="form-control" name="email" id="email" placeholder="name@example.com">
                                      <label for="email" class="form-label">Email</label>
                                  </div>
                                  <div style="color: red" id="error_email"></div>
                              </div>
                              <div class="col-12">
                                  <div class="form-floating mb-3">
                                      <input type="password" class="form-control" name="password" id="password" value="" placeholder="Password">
                                      <label for="password" class="form-label">Password</label>
                                  </div>                                 
                                  <div style="color: red" id="error_password"></div>
                              </div>
                              <div class="col-12">
                                  <div class="d-grid">
                                      <button class="btn bsb-btn-xl btn-primary py-3" type="submit">Log In Now</button>
                                  </div>
                              </div>
                          </div>
                      </form>
                      <div class="row">
                          <div class="col-12">
                              <hr class="mt-5 mb-4 border-secondary-subtle">
                              <div class="d-flex gap-2 gap-md-4 flex-column flex-md-row justify-content-center">
                                  <a href="{{ route('account.register') }}" class="link-secondary text-decoration-none">Create new account</a>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
  <div class="" style="font-size: 30px"></div>
</section>

@endsection



@section('customJs')

<script>

  $("#loginForm").submit(function(e){
    e.preventDefault();


    $.ajax({
      url: "{{ route('account.authentication') }}",
      type: "POST",
      data: $(this).serialize(),
      dataType: "json",
      success:function(response){
        if(response.status == false){
          var errors = response.errors;
          if(errors.email){
            $("#error_email").html(errors.email[0]);
          }else{
            $("#error_email").html("");
          }
          if(errors.password){
            $("#error_password").html(errors.password[0]);
          }else{
            $("#error_password").html("");
          }
        }else{
          window.location.href = "{{ route('account.profile') }}";
        }

      }

    });







  })




</script>




@endsection