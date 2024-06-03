@extends('front.layout.master')

@section('main')

    <div class="container">
        <div class="row my-5">
            
        @include('front.books.sidebar')
        <div class="col-md-9">

            @if(Session::has('success'))
            <p>{{ Session::get('success') }}</p>
            @endif

            @if(Session::has('error'))
            <p>{{ Session::get('error') }}</p>
            @endif
                
            <div class="card border-0 shadow">
                <div class="card-header  text-white">
                    Reviews
                </div>
                <div class="card-body pb-0">  
                   
                        <div class="d-flex justify-content-end mt-1">
                        <div class="d-flex ">
                            <form action="" name="searchForm" id="searchForm" method="get">
                            <input type="text" value="{{ Request::get('keyword') }}" name="keyword" placeholder="KeyWord">                           
                            <button  type="submit" class="btn btn-primary ms-1 me-1">Search</button>
                        </form>
                            <a href="{{ route('book.reviews') }}" class="btn btn-secondary ms-1 me-1">Clear</a>
                        </div>
                    </div>   
                             
                    <table class="table  table-striped mt-3">
                        <thead class="table-dark">
                            <tr>
                                <th>Book</th>
                                <th>Review</th>
                                <th>Rating</th>
                                <th>User</th>
                                <th>date</th>
                                <th>Status</th> 
                                                                 
                                <th width="100">Action</th>
                            </tr>
                            <tbody>
                               @if($reviews->isNotEmpty())
                                @foreach ($reviews as $review ) 
                                <tr>
                                    <td>{{ $review->book->title }}</td>
                                    <td>{{ $review->review }}</td>                                        
                                    <td><i class="fa-regular fa-star"></i>{{ $review->rating }}</td>
                                    <td>{{ $review->user->name }}</td>
                                    <td>{{ \Carbon\Carbon::parse($review->created_at)->format('d M,Y') }}</td>
                                    @if($review->status == 1)
                                    <td>Active</td>
                                    @else
                                    <td>Block</td>
                                    @endif
                                    <td>
                                        <a href="{{ route('book.editReview',$review->id) }}" class="btn btn-primary btn-sm"><i class="fa-regular fa-pen-to-square"></i>
                                        </a>
                                        <a href="#" onclick="deleteReview({{ $review->id }})" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                                @endif                         
                            </tbody>
                        </thead>
                    </table>   
                  {{ $reviews->links() }}              
                </div>
                
            </div>                
        </div>

@endsection

@section('customJs')

<script type="text/javascript">

function deleteReview(id) {
    if(confirm('are you sure ?')){
        $.ajax({
            url: "{{ route('book.deleteReview',$review->id) }}",
            type: "delete",
            data: {id : id},
            dataType: 'json',
            success: function(response){
                if(response.status == true){
                    window.location.href = "{{ route('book.reviews') }}";

                }

            }

        });
    }
    
}





</script>



@endsection
