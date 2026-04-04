<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Vision UI - Admin Dashboard</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Display:wght@200;300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- CSS / JS Vite -->
    @vite(['resources/js/admin.tsx'])
</head>
<body style="margin: 0; padding: 0; background: #0f1535; height: 100vh;">
    <div id="admin-root" data-props="{{ json_encode($stats) }}">
    </div>
</body>

</html>
