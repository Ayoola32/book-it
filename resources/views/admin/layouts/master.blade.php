<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>BookingEase - Admin Dashboard</title>

    <!-- CSS files -->
    <link href="{{ asset('admin/assets/dist/css/tabler.min.css?1692870487') }}" rel="stylesheet" />
    <link href="{{ asset('admin/assets/dist/css/demo.min.css?1692870487') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons@latest/iconfont/tabler-icons.min.css">

    <!-- Vite compiled CSS -->
    @vite(['resources/css/admin.css'])


    <style>
        @import url('https://rsms.me/inter/inter.css');

        :root {
            --tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
        }

        body {
            font-feature-settings: "cv03", "cv04", "cv11";
        }
    </style>
</head>

<body>
    {{-- Dark and Ligh theme script --}}
    <script src="{{ asset('admin/assets/dist/js/demo-theme.min.js?1692870487') }}"></script>

    <div class="page">
        <!-- Sidebar -->
        @include('admin.layouts.sidebar')


        <!-- Navbar -->
        @include('admin.layouts.header')


        <div class="page-wrapper">

            {{-- Content --}}
            @yield('content')

            {{-- Footer --}}
            @include('admin.layouts.footer')
        </div>
    </div>
    
    {{-- JQuery --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Tabler Core -->
    <script src="{{ asset('admin/assets/dist/js/tabler.min.js?1692870487') }}" defer></script>
    <script src="{{ asset('admin/assets/dist/js/demo.min.js?1692870487') }}" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Vite compiled JS -->
    @vite(['resources/js/admin/admin.js'])


    @stack('scripts')

</body>

</html>
