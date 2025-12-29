<!-- Sidebar Start -->
<div class="sidebar pe-4 pb-3">
    <nav class="navbar bg-secondary navbar-dark">
        <a href="{{ route('dashboard') }}" class="navbar-brand mx-4 mb-3">
            <h3 class="text-primary">
                @if(isset($settings['site_logo']))
                    <img src="{{ asset('storage/' . $settings['site_logo']) }}" alt="Logo" style="width: 40px; height: 40px;" class="rounded-circle me-2">
                @else
                    <i class="fa fa-user-edit me-2"></i>
                @endif
                {{ $settings['site_name'] ?? 'DeepBlog' }}
            </h3>
        </a>
        <div class="d-flex align-items-center ms-4 mb-4">
            <div class="position-relative">
                @if(auth()->user()->photo)
                    <img class="rounded-circle" src="{{ asset('storage/' . auth()->user()->photo) }}" alt="" style="width: 40px; height: 40px; object-fit: cover;">
                @else
                    <div class="rounded-circle bg-white d-flex align-items-center justify-content-center text-primary fw-bold" style="width: 40px; height: 40px;">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                @endif
                <div class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1"></div>
            </div>
            <div class="ms-3">
                <h6 class="mb-0">{{ auth()->user()->name }}</h6>
                <span>{{ auth()->user()->role == 1 ? 'Administrator' : 'Start User' }}</span>
            </div>
        </div>
        
        <div class="navbar-nav w-100">
            <!-- Dashboard -->
            <a href="{{ route('dashboard') }}" class="nav-item nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="fa fa-tachometer-alt me-2"></i>{{ __('menu.dashboard') }}
            </a>
            
            <!-- Content Group -->
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle {{ request()->routeIs('admin.articles.*') || request()->routeIs('admin.categories.*') || request()->routeIs('admin.pages.*') ? 'active' : '' }}" data-bs-toggle="dropdown">
                    <i class="fa fa-pencil-alt me-2"></i>Content
                </a>
                <div class="dropdown-menu bg-transparent border-0 {{ request()->routeIs('admin.articles.*') || request()->routeIs('admin.categories.*') || request()->routeIs('admin.pages.*') ? 'show' : '' }}">
                    <a href="{{ route('admin.articles.index') }}" class="dropdown-item {{ request()->routeIs('admin.articles.*') ? 'active' : '' }}">
                        <i class="fa fa-newspaper me-2"></i>{{ __('menu.articles') }}
                    </a>
                    @if(auth()->user()->role == 1)
                    <a href="{{ route('admin.categories.index') }}" class="dropdown-item {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                        <i class="fa fa-th me-2"></i>{{ __('menu.categories') }}
                    </a>
                    <a href="{{ route('admin.pages.index') }}" class="dropdown-item {{ request()->routeIs('admin.pages.*') ? 'active' : '' }}">
                        <i class="fa fa-file-alt me-2"></i>{{ __('menu.pages') ?? 'Pages' }}
                    </a>
                    @endif
                </div>
            </div>

            <!-- Community Group -->
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle {{ request()->routeIs('admin.comments.*') || request()->routeIs('admin.users.*') || request()->routeIs('admin.subscribers.*') || request()->routeIs('admin.messages.*') ? 'active' : '' }}" data-bs-toggle="dropdown">
                    <i class="fa fa-users me-2"></i>Community
                </a>
                <div class="dropdown-menu bg-transparent border-0 {{ request()->routeIs('admin.comments.*') || request()->routeIs('admin.users.*') || request()->routeIs('admin.subscribers.*') || request()->routeIs('admin.messages.*') ? 'show' : '' }}">
                    <a href="{{ route('admin.comments.index') }}" class="dropdown-item {{ request()->routeIs('admin.comments.*') ? 'active' : '' }}">
                        <i class="fa fa-comments me-2"></i>{{ __('menu.comments') }}
                    </a>
                    @if(auth()->user()->role == 1)
                    <a href="{{ route('admin.users.index') }}" class="dropdown-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                        <i class="fa fa-user me-2"></i>{{ __('menu.users') }}
                    </a>
                    <a href="{{ route('admin.subscribers.index') }}" class="dropdown-item {{ request()->routeIs('admin.subscribers.*') ? 'active' : '' }}">
                        <i class="fa fa-envelope-open me-2"></i>Subscribers
                    </a>
                    <a href="{{ route('admin.messages.index') }}" class="dropdown-item {{ request()->routeIs('admin.messages.*') ? 'active' : '' }}">
                        <i class="fa fa-inbox me-2"></i>Inbox
                        @if(isset($unreadMessagesCount) && $unreadMessagesCount > 0)
                            <span class="badge bg-danger ms-1">{{ $unreadMessagesCount }}</span>
                        @endif
                    </a>
                    @endif
                </div>
            </div>

            <!-- System Group (Admin Only) -->
            @if(auth()->user()->role == 1)
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle {{ request()->routeIs('admin.backups.*') || request()->routeIs('admin.settings.*') ? 'active' : '' }}" data-bs-toggle="dropdown">
                    <i class="fa fa-cogs me-2"></i>System
                </a>
                <div class="dropdown-menu bg-transparent border-0 {{ request()->routeIs('admin.backups.*') || request()->routeIs('admin.settings.*') ? 'show' : '' }}">
                    <a href="{{ route('admin.backups.index') }}" class="dropdown-item {{ request()->routeIs('admin.backups.*') ? 'active' : '' }}">
                        <i class="fa fa-database me-2"></i>Backup
                    </a>
                    <a href="{{ route('admin.settings.index') }}" class="dropdown-item {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                        <i class="fa fa-cog me-2"></i>{{ __('menu.settings') }}
                    </a>
                </div>
            </div>
            @endif

        </div>
    </nav>
</div>
<!-- Sidebar End -->
