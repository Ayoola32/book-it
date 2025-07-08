<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>BookingEase - User Dashboard</title>

    <!-- CSS files -->
    <link href="{{ asset('admin/assets/dist/css/tabler.min.css?1692870487') }}" rel="stylesheet" />
    <link href="{{ asset('admin/assets/dist/css/demo.min.css?1692870487') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons@latest/iconfont/tabler-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">

    @stack('styles')
    <!-- Vite compiled CSS -->
    @vite(['resources/css/admin.css', 'resources/css/app.css'])

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
        @include('layouts.sidebar')


        <!-- Navbar -->
        @include('layouts.header')


        <div class="page-wrapper">

            {{-- Content --}}
            @yield('content')

            {{-- Footer --}}
            @include('layouts.footer')
        </div>
    </div>
    
    {{-- JQuery --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Tabler Core -->
    <script src="{{ asset('admin/assets/dist/js/tabler.min.js?1692870487') }}" defer></script>
    <script src="{{ asset('admin/assets/dist/js/demo.min.js?1692870487') }}" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>


    <!-- Vite compiled JS -->
    @vite(['resources/js/app.js', 'resources/js/admin/admin.js'])
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('body').on('click', '.delete-item', function(e) {
                e.preventDefault();
                const deleteUrl = $(this).attr('href'); 
                const button = $(this);

                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "DELETE",
                            url: deleteUrl,
                            data: {_token: "{{ csrf_token() }}"},
                            success: function(response) {
                                if (response.status === 'error') {
                                    Swal.fire({
                                        title: "Error!",
                                        text: "Cannot Delete Holiday, it has been Approved or Rejected",
                                        icon: "error"
                                    });
                                } else {
                                    Swal.fire({
                                        title: "Deleted!",
                                        text: response.message,
                                        icon: "success"
                                    });
                                }
                                $('#holiday-table').DataTable().ajax.reload(null, false); // ✅ Reloads table
                            },
                            error: function(xhr, status, error) {
                                Swal.fire({
                                    title: "Error!",
                                    text: "Something went wrong.",
                                    icon: "error"
                                });
                            }
                        });
                    }
                });
            });
        });
    </script>

    @stack('scripts')

</body>

</html>
