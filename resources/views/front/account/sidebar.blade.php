<div class="col-md-3">
    <div class="card border-0 shadow-lg">
        <div class="card-header  text-white">
            Welcome, John Doe                        
        </div>
        <div class="card-body">
            <div class="text-center mb-3">
                @if(Auth::user()->image != '')
                <img src="{{ asset('uploads/profile/thumb/'.Auth::user()->image) }}" class="img-fluid rounded-circle" alt="Luna John">                            
            @else
            <img src="{{ asset('assets/images/profile-img-1.jpg') }}" class="img-fluid rounded-circle" alt="Luna John">
            @endif
        </div>
            <div class="h5 text-center">
                <strong>John Doe</strong>
                <p class="h6 mt-2 text-muted">5 Reviews</p>
            </div>
        </div>
    </div>
    <div class="card border-0 shadow-lg mt-3">
        <div class="card-header  text-white">
            Navigation
        </div>
        <div class="card-body sidebar">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="{{ route('book.list') }}">Books</a>                               
                </li>
                <li class="nav-item">
                    <a href="{{ route('book.reviews') }}">Reviews</a>                               
                </li>
                <li class="nav-item">
                    <a href="{{ route('account.profile') }}">Profile</a>                               
                </li>
                <li class="nav-item">
                    <a href="my-reviews.html">My Reviews</a>
                </li>
                <li class="nav-item">
                    <a href="change-password.html">Change Password</a>
                </li> 
                <li class="nav-item">
                    <a href="{{ route('account.logout') }}">Logout</a>
                </li>                           
            </ul>
        </div>
    </div>
</div>
