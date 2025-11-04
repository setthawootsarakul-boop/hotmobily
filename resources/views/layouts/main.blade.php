<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Hotmobily')</title>

    {{-- ✅ Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- ✅ Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    {{-- ✅ Custom CSS --}}
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body>

    {{-- ✅ Navbar (อยู่ใน partials) --}}
    @include('partials.navbar')

    {{-- ✅ Main content --}}
    <main>
        @yield('content')
    </main>

    {{-- ✅ Footer (อยู่ใน partials) --}}
    @include('partials.footer')

    {{-- ✅ Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>