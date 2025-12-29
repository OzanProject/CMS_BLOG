<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Under Maintenance - Ozan Project</title>
    
    <!-- Favicon -->
    @php
        $settings = \App\Models\Configuration::pluck('value', 'key');
        $favicon = isset($settings['site_favicon']) ? asset('storage/' . $settings['site_favicon']) : asset('nextpage-lite/assets/img/favicon.png');
    @endphp
    <link rel="icon" href="{{ $favicon }}" type="image/png">

    <!-- Use Frontend Assets for consistency -->
    <link rel="stylesheet" href="{{ asset('nextpage-lite/assets/css/vendor.css') }}">
    <link rel="stylesheet" href="{{ asset('nextpage-lite/assets/css/style.css') }}">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <style>
        body {
            background-color: #f3f4f6;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Inter', sans-serif;
        }
        .maintenance-card {
            background: #ffffff;
            max-width: 550px;
            width: 90%;
            border-radius: 16px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.08);
            padding: 50px 30px;
            text-align: center;
            position: relative;
            overflow: hidden;
            border-top: 5px solid #0d6efd;
        }
        .icon-wrapper {
            width: 100px;
            height: 100px;
            background: rgba(13, 110, 253, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 30px;
            color: #0d6efd;
            animation: pulse 2s infinite;
        }
        .title {
            font-weight: 800;
            color: #1f2937;
            margin-bottom: 15px;
            font-size: 28px;
        }
        .description {
            color: #6b7280;
            line-height: 1.6;
            margin-bottom: 30px;
            font-size: 16px;
        }
        .spinner-custom {
            width: 3rem;
            height: 3rem;
            border-width: 0.25em;
        }
        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 rgba(13, 110, 253, 0.4); }
            70% { box-shadow: 0 0 0 20px rgba(13, 110, 253, 0); }
            100% { box-shadow: 0 0 0 0 rgba(13, 110, 253, 0); }
        }
        .bg-pattern {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0.03;
            background-image: radial-gradient(#0d6efd 1px, transparent 1px);
            background-size: 20px 20px;
            pointer-events: none;
        }
    </style>
</head>
<body>

    <div class="maintenance-card">
        <div class="bg-pattern"></div>
        
        <div class="icon-wrapper">
            <i class="fa fa-cogs fa-3x"></i>
        </div>

        <h1 class="title">System Maintenance</h1>
        
        <p class="description">
            {{ $message ?? 'We are currently updating our website to provide you with a better experience. Please check back soon.' }}
        </p>

        <div class="d-flex justify-content-center mb-4">
            <div class="spinner-border text-primary spinner-custom" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>

        <p class="text-muted small mb-0">
            &copy; {{ date('Y') }} Ozan Project. All rights reserved.
        </p>
    </div>

</body>
</html>
