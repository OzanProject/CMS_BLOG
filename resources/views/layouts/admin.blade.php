<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>{{ $settings['site_name'] ?? config('app.name') }} - Admin Dashboard</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    @if(isset($settings['site_favicon']))
        <link rel="icon" href="{{ asset('storage/' . $settings['site_favicon']) }}" type="image/x-icon">
    @else
        <link href="{{ asset('darkpan/img/favicon.ico') }}" rel="icon">
    @endif

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Roboto:wght@500;700&display=swap" rel="stylesheet"> 
    
    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{ asset('darkpan/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('darkpan/lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css') }}" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('darkpan/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{ asset('darkpan/css/style.css') }}" rel="stylesheet">

    <!-- Custom CSS for Laravel specific things if needed -->
    <style>
        .sidebar .navbar .navbar-nav .nav-link.active {
            color: var(--primary);
            background: #191C24;
            border-left: 3px solid var(--primary);
        }
    </style>
</head>

<body>
    <div class="container-fluid position-relative d-flex p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-dark position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->

        <!-- Sidebar -->
        @include('layouts.partials.sidebar')
        <!-- End Sidebar -->

        <!-- Content Start -->
        <div class="content d-flex flex-column min-vh-100">
            <!-- Navbar -->
            @include('layouts.partials.navbar')
            <!-- End Navbar -->

            <!-- Content Wrapper (Flex Grow) -->
            <div class="flex-grow-1">
                <!-- Flash Messages -->
                @if(session('success'))
                    <div class="container-fluid pt-4 px-4">
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fa fa-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="container-fluid pt-4 px-4">
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fa fa-exclamation-circle me-2"></i>{{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                @endif

                <!-- Main Content -->
                @yield('content')
                <!-- Main Content End -->
            </div>

            <!-- Footer -->
            @include('layouts.partials.footer')
            <!-- End Footer -->
        </div>
        <!-- Content End -->

        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('darkpan/lib/chart/chart.min.js') }}"></script>
    <script src="{{ asset('darkpan/lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('darkpan/lib/waypoints/waypoints.min.js') }}"></script>
    <script src="{{ asset('darkpan/lib/owlcarousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('darkpan/lib/tempusdominus/js/moment.min.js') }}"></script>
    <script src="{{ asset('darkpan/lib/tempusdominus/js/moment-timezone.min.js') }}"></script>
    <script src="{{ asset('darkpan/lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js') }}"></script>

    <!-- Template Javascript -->
    <script src="{{ asset('darkpan/js/main.js') }}"></script>
    @stack('scripts')
</body>

</html>
