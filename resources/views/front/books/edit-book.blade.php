@extends('front.layout.master')

@section('main')

    <div class="container">
        <div class="row my-5">
            
        @include('front.books.sidebar')

            <div class="col-md-9">
                <div class="card border-0 shadow">
                    <div class="card-header  text-white">
                        Edit Book
                    </div>
                    <div class="card-body">
                        <form action="" method="POST" name="editBookForm" id="editBookForm" enctype="multipart/form-data">
                        @csrf
                            <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control" placeholder="Title" value="{{ $book->title }}" name="title" id="title"/>
                        </div>
                        <div style="color: red" id="error_title"></div> 

                        <div class="mb-3">
                            <label for="author" class="form-label">Author</label>
                            <input type="text" class="form-control" placeholder="Author"  value="{{ $book->author }}"  name="author" id="author"/>
                        </div>
                        <div style="color: red" id="error_author"></div> 

                        <div class="mb-3">
                            <label for="author" class="form-label">Description</label>
                            <textarea name="description" id="description" class="form-control" placeholder="Description" cols="30" rows="5">{{ $book->description }}</textarea>
                        </div>
                        <div style="color: red" id="error_description"></div> 

                        <div class="mb-3">
                            <label for="Image" class="form-label">Image</label>
                            <input type="file" class="form-control"  name="image" id="image"/>
                        </div>
                        <div style="color: red" id="error_image"></div> 

                        @if($book->image != '')
                        <img class="w-25 h-35 my-3" src="{{ asset('uploads/books/thumb/'.$book->image) }}" alt="">
                        @endif

                        <div class="mb-3">
                            <label for="author" class="form-label">Status</label>
                            <select name="status" id="status" class="form-control">
                                <option value="1" {{ ($book->status == 1)? 'selected' : '' }}">Active</option>
                                <option value="0" {{ ($book->status == 0)? 'selected' : '' }}">Block</option>
                            </select>
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
    $("#editBookForm").submit(function(e){
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url : "{{ route('book.update',$book->id) }}",
            type : "POST",
            data : formData,
            // dataType : 'json',
            processData : false,
            contentType : false,
            success:function(response){
                // alert('hello');
                if(response.status == true){               
                   window.location.href = "{{ route('book.list') }}";
                }else{
                    var errors = response.errors;
                    if(errors.title){
                        $("#error_title").html(errors.title[0]);
                    }else{
                        $("#error_title").html("");
                    }
                    if(errors.author){
                        $("#error_author").html(errors.author[0]);
                    }else{
                        $("#error_author").html("");
                    }
                    if(errors.description){
                        $("#error_description").html(errors.description[0]);
                    }else{
                        $("#error_description").html("");
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
