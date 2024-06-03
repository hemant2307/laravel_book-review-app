@extends('front.layout.master')

@section('main')
    <div class="container">
        <div class="row my-5">
            @include('front.account.sidebar')           
            <div class="col-md-9">
                <div class="card border-0 shadow">
                    <div class="card-header  text-white">
                        Profile
                        @if(Session::has('success'))
                        <div style="color: rgb(9, 232, 20)" >{{ Session::get('success') }}</div>
                        @endif
                     </div>
                   
                    <div class="card-body">
                        <form action="" method="POST" id="profileForm" name="profileForm" enctype="multipart/form-data">                           
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text"  class="form-control" placeholder="Name" name="name" id="name" value="{{ $user->name }}" />
                        </div>
                        <div style="color: red" id="error_name"></div> 
                        <div class="mb-3">
                            <label for="name" class="form-label">Email</label>
                            <input type="text"  class="form-control" placeholder="Email"  name="email" id="email" value="{{ $user->email }}" />
                        </div>
                        <div style="color: red" id="error_email"></div> 
                        <div class="mb-3">
                            <label for="name" class="form-label">Image</label>
                            <input type="file" name="image" id="image" class="form-control">
                            @if(Auth::user()->image != "")
                            <img src="{{ asset('uploads/profile/thumb/'.Auth::user()->image) }}" class="img-fluid mt-4" alt="Luna John" >
                            @else
                            <img src="{{ asset('assets/images/profile-img-1.jpg') }}" class="img-fluid mt-4" alt="Luna John" >
                        @endif
                        </div>   
                        <button class="btn btn-primary mt-2">Update</button>    
                    </form>                 
                    </div>
               
                </div>                
            </div>
        </div>       
    </div>

@endsection

@section('customJs')
<script type="text/javascript">
    $("#profileForm").submit(function(e){
        e.preventDefault();
        var formData = new FormData(this);
      
        $.ajax({
            url : "{{ route('account.updateProfile') }}",
            type : "POST",
            data : formData,
            // dataType : 'json',
            processData : false,
            contentType : false,
            success:function(response){
                // alert('hello');
                if(response.status == true){
               
                   window.location.href = "{{ route('account.profile') }}";
                }else{
                    var errors = response.errors;
                    if(errors.name){
                        $("#error_name").html(errors.name[0]);
                    }else{
                        $("#error_name").html("");
                    }
                    if(errors.email){
                        $("#error_email").html(errors.email[0]);
                    }else{
                        $("#error_email").html("");
                    }
                    if(errors.image){
                        $("#error_image").html(errors.image[0]);
                    }else{
                        $("#error_image").html("");
                    }                    
                }
            }
        })
    })

</script>

@endsection
