@extends('front.layout.master')

@section('main')

    <div class="container">
        <div class="row my-5">

            @include('front.books.sidebar')
            
            <div class="col-md-9">
                
                <div class="card border-0 shadow">
                    <div class="card-header  text-white">
                        Books
                    </div>
                    @if(Session::has('success'))
                   <p>{{ Session::get('success') }}</p>
                   @endif

                    <div class="card-body pb-0">
                        <div class="d-flex justify-content-between mt-1">                       
                            <a href="{{ route('book.create') }}" class="btn btn-primary ms-1">Add Book</a>    
                        <div class="d-flex ">
                            <form action="" name="searchForm" id="searchForm" method="get">
                            <input type="text" value="{{ Request::get('keyword') }}" name="keyword" placeholder="KeyWord">                           
                            <button  type="submit" class="btn btn-primary ms-1 me-1">Search</button>
                        </form>
                            <a href="{{ route('book.list') }}" class="btn btn-secondary ms-1 me-1">Clear</a>
                        </div>
                    </div>        
                       
                        <table class="table  table-striped mt-3">
                            <thead class="table-dark">
                                <tr>
                                    <th>Title</th>
                                    <th>Author</th>
                                    <th>Rating</th>
                                    <th>Status</th>
                                    <th width="150">Action</th>
                                </tr>
                                <tbody>
                                     @if($books->isNotEmpty())                                   
                                    @foreach ($books  as $book)
                                    <tr>
                                        <td>{{ $book->title }}</td>
                                        <td>{{ $book->author }}</td>
                                        <td>3.0 (3 Reviews)</td>
                                        @if($book->status == 1)
                                        <td>Active</td>
                                        @else
                                        <td>InActive</td>
                                        @endif
                                        <td>
                                            <a href="{{ route('index.detail',$book->id) }}" class="btn btn-success btn-sm"><i class="fa-regular fa-star"></i></a>
                                            <a href="{{ route('book.edit',$book->id) }}" class="btn btn-primary btn-sm"><i class="fa-regular fa-pen-to-square"></i>
                                            </a>
                                            <a href="#" onclick="deleteBook({{ $book->id }})" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></a>
                                        </td>
                                    </tr>                                        
                                    @endforeach                                   
                                    @else
                                    <tr>
                                        <td colspan="5">
                                            <div class="jumbotron  jumbotron-fluid mt-5">
                                                <div class="container">
                                                  <h1> No such book found in Db</h1>
                                                  <p>please Try with proper name of the book or author.</p>
                                                </div>
                                              </div>
                                        </td>
                                    </tr>                                    
                                    @endif  
                                </tbody>
                            </thead>
                        </table>   
                      {{  $books->links();}}
                                    
                    </div>
                    
                </div>                
            </div>
        </div>       
    </div>

@endsection


@section('customJs')

   <script type="text/javascript">

   function deleteBook(id){
    if(confirm('are you sure ?')){
        $.ajax({
            url: "{{ route('book.delete') }}",
            type: 'delete',
            data: {id: id},
            // dataType: 'json',
            success:function(response){
                // if(response.status == true){
                   
                    window.location.href = "{{ route('book.list') }}";

                // }

            }

        });

    }
   }








</script>


@endsection
