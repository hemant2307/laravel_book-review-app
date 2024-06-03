@extends('front.layout.master')

@section('main')
    <div class="container">
        <div class="row my-5">
            @include('front.account.sidebar')           
            <div class="col-md-9">
                <div class="card border-0 shadow">
                    <div class="card-header  text-white">
                      Edit Review
                        @if(Session::has('success'))
                        <div style="color: rgb(9, 232, 20)" >{{ Session::get('success') }}</div>
                        @endif
                     </div>
                   
                    <div class="card-body">
                        <form action="" method="POST" id="editReviewForm" name="editReviewForm" >                           
                        <div class="mb-3">
                            <label for="name" class="form-label">review</label>
                            <textarea class="form-control" placeholder="review" name="review" id="review" cols="30" rows="5">{{ old('review',$review->review) }}</textarea>
                        </div>
                        <div style="color: red" id="error_review"></div> 
                        
                        <div class="mb-3">
                            <label for="name" class="form-label">status</label>
                        <select class="form-control" name="status" id="status">
                            <option value="0" {{ ($review->status == 0)? 'selected' : "" }}>Block</option>
                            <option value="1" {{ ($review->status == 1)? 'selected' : "" }}>Active</option>
                        </select>
                        </div>
                        <div style="color: red" id="error_status"></div> 
                         
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
    $("#editReviewForm").submit(function(e){
        e.preventDefault();
        // var formData = new FormData(this);
      
        $.ajax({
            url : "{{ route('book.updateReview',$review->id) }}",
            type : "POST",
            data : $("#editReviewForm").serialize(),
            dataType : 'json',
            // processData : false,
            // contentType : false,
            success:function(response){
                // alert('hello');
                if(response.status == true){
               
                   window.location.href = "{{ route('book.reviews') }}";
                }else{
                    var errors = response.errors;
                    if(errors.review){
                        $("#error_review").html(errors.review[0]);
                    }else{
                        $("#error_review").html("");
                    }
                    if(errors.status){
                        $("#error_status").html(errors.status[0]);
                    }else{
                        $("#error_status").html("");
                    }
                                      
                }
            }
        })
    })

</script>

@endsection
