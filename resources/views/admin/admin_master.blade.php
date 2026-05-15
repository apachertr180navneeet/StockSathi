<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>@yield('title', 'StockSathi')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" href="{{ asset('backend/assets/images/favicon.ico') }}">

    <link href="{{ asset('backend/assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend/assets/libs/boxicons/css/boxicons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend/assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />

    <link href="{{ asset('backend/assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend/assets/libs/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend/assets/libs/datatables.net-keytable-bs5/css/keyTable.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend/assets/libs/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend/assets/libs/datatables.net-select-bs5/css/select.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />

    <style>
        /* Skote missing CSS variables */
        :root {
            --bs-header-bg: #ffffff;
            --bs-header-item-color: #555;
            --bs-topbar-search-bg: #f8f9fa;
        }

        /* Avatar utility classes */
        .avatar-xs { height: 1.5rem; width: 1.5rem; }
        .avatar-sm { height: 2.25rem; width: 2.25rem; }
        .avatar-md { height: 3.5rem; width: 3.5rem; }
        .avatar-lg { height: 4.5rem; width: 4.5rem; }
        .avatar-xl { height: 6rem; width: 6rem; }
        .avatar-xxl { height: 7.5rem; width: 7.5rem; }
        .avatar-title { align-items: center; color: #fff; display: flex; height: 100%; justify-content: center; width: 100%; }

        /* Badge soft variants */
        .badge-soft-primary { color: #556ee6; background-color: rgba(85, 110, 230, 0.18); box-shadow: none; }
        .badge-soft-secondary { color: #74788d; background-color: rgba(116, 120, 141, 0.18); box-shadow: none; }
        .badge-soft-success { color: #34c38f; background-color: rgba(52, 195, 143, 0.18); box-shadow: none; }
        .badge-soft-info { color: #50a5f1; background-color: rgba(80, 165, 241, 0.18); box-shadow: none; }
        .badge-soft-warning { color: #f1b44c; background-color: rgba(241, 180, 76, 0.18); box-shadow: none; }
        .badge-soft-danger { color: #f46a6a; background-color: rgba(244, 106, 106, 0.18); box-shadow: none; }
        .badge-soft-light { color: #eff2f7; background-color: rgba(239, 242, 247, 0.18); box-shadow: none; }
        .badge-soft-dark { color: #343a40; background-color: rgba(52, 58, 64, 0.18); box-shadow: none; }

        /* Soft background utility */
        .bg-soft { background-color: rgba(var(--bs-primary-rgb), 0.12) !important; }

        /* Font size utilities */
        .font-size-10 { font-size: 10px !important; }
        .font-size-11 { font-size: 11px !important; }
        .font-size-12 { font-size: 12px !important; }
        .font-size-13 { font-size: 13px !important; }
        .font-size-14 { font-size: 14px !important; }
        .font-size-15 { font-size: 15px !important; }
        .font-size-16 { font-size: 16px !important; }
        .font-size-17 { font-size: 17px !important; }
        .font-size-18 { font-size: 18px !important; }
        .font-size-20 { font-size: 20px !important; }
        .font-size-22 { font-size: 22px !important; }
        .font-size-24 { font-size: 24px !important; }

        /* Card breadcrumb styling */
        .breadcrumb-item + .breadcrumb-item::before { font-family: "Material Design Icons"; }

        /* Page loader */
        #page-loader {
            position: fixed;
            width: 100%;
            height: 100%;
            background: #ffffff;
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            transition: opacity 0.3s ease;
        }
        .loader-content p {
            margin-top: 10px;
            font-size: 14px;
            color: #555;
        }
        .spinner {
            width: 45px;
            height: 45px;
            border: 4px solid #eee;
            border-top: 4px solid #556ee6;
            border-radius: 50%;
            animation: spin 0.7s linear infinite;
        }
        @keyframes spin {
            100% { transform: rotate(360deg); }
        }
        .table-scroll {
            max-height: 400px;
            overflow-y: auto;
        }
        .table-scroll thead {
            position: sticky;
            top: 0;
            z-index: 1;
        }
        .table-scroll thead th {
            background: #f0f4f7;
            position: sticky;
            top: 0;
        }
        .toastr-margin {
            margin-top: 70px;
        }
    </style>

    @yield('css')
</head>

<body data-sidebar="dark">

    <div id="page-loader">
        <div class="loader-content text-center">
            <div class="spinner"></div>
            <p>Loading...</p>
        </div>
    </div>

    <div id="layout-wrapper">

        @include('admin.body.header')

        @include('admin.body.sidebar')

        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    @yield('admin')
                </div>
            </div>
            @include('admin.body.footer')
        </div>

    </div>

    <script src="{{ asset('backend/assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/feather-icons/feather.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="{{ asset('backend/assets/js/app.js') }}"></script>

    <script>
        (function() {
            var paths = {
                bs: '{{ asset('backend/assets/css/bootstrap.min.css') }}',
                app: '{{ asset('backend/assets/css/app.min.css') }}'
            };
            var fixLinks = function() {
                var bs = document.getElementById('bootstrap-style');
                var app = document.getElementById('app-style');
                if (bs && bs.href && !bs.href.startsWith(window.location.origin + '/')) {
                    bs.href = paths.bs;
                }
                if (app && app.href && !app.href.startsWith(window.location.origin + '/')) {
                    app.href = paths.app;
                }
            };
            fixLinks();
            document.querySelectorAll('#light-mode-switch, #dark-mode-switch, #rtl-mode-switch, #dark-rtl-mode-switch').forEach(function(el) {
                el.addEventListener('change', function() { setTimeout(fixLinks, 10); });
            });
        })();
    </script>

    <script>
        feather.replace();
    </script>

    <script src="{{ asset('backend/assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/pages/datatable.init.js') }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">

    <script>
        @if (Session::has('message'))
            var type = "{{ Session::get('alert-type', 'info') }}"
            switch (type) {
                case 'info': toastr.info("{{ Session::get('message') }}"); break;
                case 'success': toastr.success("{{ Session::get('message') }}"); break;
                case 'warning': toastr.warning("{{ Session::get('message') }}"); break;
                case 'error': toastr.error("{{ Session::get('message') }}"); break;
            }
        @endif
    </script>

    <script>
        window.addEventListener("load", function() {
            var loader = document.getElementById("page-loader");
            loader.style.opacity = "0";
            setTimeout(function() {
                loader.style.display = "none";
            }, 300);
        });
    </script>

    @yield('scripts')
</body>
</html>
