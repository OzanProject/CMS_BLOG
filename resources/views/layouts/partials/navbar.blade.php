<!-- Navbar Start -->
<nav class="navbar navbar-expand bg-secondary navbar-dark sticky-top px-4 py-0">
    <a href="{{ route('dashboard') }}" class="navbar-brand d-flex d-lg-none me-4">
        <h2 class="text-primary mb-0"><i class="fa fa-user-edit"></i></h2>
    </a>
    <a href="#" class="sidebar-toggler flex-shrink-0">
        <i class="fa fa-bars"></i>
    </a>
    <form class="d-none d-md-flex ms-4">
        <input class="form-control bg-dark border-0" type="search" placeholder="Search">
    </form>
    <div class="navbar-nav align-items-center ms-auto">
        
        <!-- Language Switcher -->
        <div class="nav-item dropdown me-3">
            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                <i class="fa fa-globe me-lg-2"></i>
                <span class="d-none d-lg-inline-flex">{{ strtoupper(app()->getLocale()) }}</span>
            </a>
            <div class="dropdown-menu dropdown-menu-end bg-secondary border-0 rounded-0 rounded-bottom m-0">
                <a href="{{ route('lang.switch', 'en') }}" class="dropdown-item {{ app()->getLocale() == 'en' ? 'active' : '' }}">English</a>
                <a href="{{ route('lang.switch', 'id') }}" class="dropdown-item {{ app()->getLocale() == 'id' ? 'active' : '' }}">Indonesia</a>
            </div>
        </div>

        <!-- Message/Comment Notifications -->
        <div class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                <i class="fa fa-envelope me-lg-2"></i>
                <span class="d-none d-lg-inline-flex">Comments</span>
                <span id="nav-comment-badge" class="badge rounded-pill bg-danger ms-1" style="{{ $navbarCommentsCount > 0 ? '' : 'display:none;' }}">
                    {{ $navbarCommentsCount }}
                </span>
            </a>
            <div class="dropdown-menu dropdown-menu-end bg-secondary border-0 rounded-0 rounded-bottom m-0">
                <div id="nav-comment-list">
                    @forelse($navbarComments as $comment)
                    <a href="{{ route('admin.comments.index', ['status' => 'pending']) }}" class="dropdown-item">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center fw-bold" style="width: 40px; height: 40px;">
                                {{ substr($comment->name, 0, 1) }}
                            </div>
                            <div class="ms-2">
                                <h6 class="fw-normal mb-0">{{ $comment->name }} sent a comment</h6>
                                <small>{{ $comment->created_at->diffForHumans() }}</small>
                            </div>
                        </div>
                    </a>
                    <hr class="dropdown-divider">
                    @empty
                    <a href="#" class="dropdown-item text-center">No new comments</a>
                    @endforelse
                </div>
                <hr class="dropdown-divider">
                <a href="{{ route('admin.comments.index') }}" class="dropdown-item text-center">See all comments</a>
            </div>
        </div>

        <div class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle d-flex align-items-center" data-bs-toggle="dropdown">
                @if(auth()->user()->photo)
                    <img class="rounded-circle me-lg-2" src="{{ asset('storage/' . auth()->user()->photo) }}" alt="" style="width: 40px; height: 40px; object-fit: cover;">
                @else
                    <div class="rounded-circle bg-white d-flex align-items-center justify-content-center text-primary fw-bold me-lg-2" style="width: 40px; height: 40px;">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                @endif
                <span class="d-none d-lg-inline-flex">{{ auth()->user()->name }}</span>
            </a>
            <div class="dropdown-menu dropdown-menu-end bg-secondary border-0 rounded-0 rounded-bottom m-0">
                <a href="{{ route('profile.edit') }}" class="dropdown-item">{{ __('menu.profile') }}</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="dropdown-item">{{ __('menu.logout') }}</button>
                </form>
            </div>
        </div>
    </div>
</nav>
<!-- Navbar End -->

<script>
    document.addEventListener('DOMContentLoaded', function() {
        setInterval(function() {
            fetch('{{ route('admin.comments.count') }}', {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                const badge = document.getElementById('nav-comment-badge');
                if (data.count > 0) {
                    badge.innerText = data.count;
                    badge.style.display = 'inline-block';
                } else {
                    badge.style.display = 'none';
                }
                
                // Optionally update list content here if needed, 
                // but usually count is enough for quick notification.
            })
            .catch(error => console.error('Error fetching notifications:', error));
        }, 30000); // Poll every 30 seconds
    });
</script>
