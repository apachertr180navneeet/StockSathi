<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title> StockSathi </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc." />
    <meta name="author" content="Zoyothemes" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('backend/assets/images/favicon.ico') }}">

    <!-- Datatables css -->
    <link href="{{ asset('backend/assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}"
        rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend/assets/libs/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css') }}"
        rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend/assets/libs/datatables.net-keytable-bs5/css/keyTable.bootstrap5.min.css') }}"
        rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend/assets/libs/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css') }}"
        rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend/assets/libs/datatables.net-select-bs5/css/select.bootstrap5.min.css') }}"
        rel="stylesheet" type="text/css" />

    <!-- App css -->
    <link href="{{ asset('backend/assets/css/app.min.css') }}" rel="stylesheet" type="text/css" id="app-style" />

    <!-- Icons -->
    <link href="{{ asset('backend/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        .d-flex.justify-content-between {
            margin: 0px 13px;
        }

        .app-sidebar-menu {
            position: fixed;
            width: 250px;
            z-index: 100;
            /* LOWER */
            transition: transform 0.3s ease-in-out;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 2px 0 15px rgba(0,0,0,0.05);
        }

        .content-page {
            margin-left: 250px;
            transition: margin-left 0.3s ease-in-out;
        }

        @media (max-width: 991px) {

            .content-page {
                margin-left: 0 !important;
            }

            .app-sidebar-menu {
                transform: translateX(-100%);
                z-index: 999;
                /* ONLY when open */
            }

            body.sidebar-open .app-sidebar-menu {
                transform: translateX(0);
            }
        }

        .sidebar-overlay {
            position: fixed;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(3px);
            z-index: 150;
            display: none;
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
        }

        body.sidebar-open .sidebar-overlay {
            display: block;
            opacity: 1;
        }

        body.sidebar-open .sidebar-overlay {
            display: block;
        }

        /* 🔥 PAGE LOADER */
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
            border-top: 4px solid #4f46e5;
            border-radius: 50%;
            animation: spin 0.7s linear infinite;
        }

        @keyframes spin {
            100% {
                transform: rotate(360deg);
            }
        }
    </style>

</head>

<!-- body start -->

<body data-menu-color="light" data-sidebar="default">
    <!-- 🔥 PAGE LOADER -->
    <div id="page-loader">
        <div class="loader-content text-center">
            <div class="spinner"></div>
            <p>Loading...</p>
        </div>
    </div>
    <!-- Begin page -->
    <div id="app-layout">
        <!-- Sidebar Overlay -->
        <div class="sidebar-overlay"></div>
        <!-- Topbar Start -->
        @include('admin.body.header')
        <!-- end Topbar -->

        <!-- Left Sidebar Start -->
        @include('admin.body.sidebar')
        <!-- Left Sidebar End -->

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="content-page">

            @yield('admin')

            <!-- content -->

            <!-- Footer Start -->
            @include('admin.body.footer')
            <!-- end Footer -->

        </div>
        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->

    </div>
    <!-- END wrapper -->

    <!-- Vendor -->
    <script src="{{ asset('backend/assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/waypoints/lib/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/jquery.counterup/jquery.counterup.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/feather-icons/feather.min.js') }}"></script>



    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="{{ asset('backend/assets/js/code.js') }}"></script>
    <script src="{{ asset('backend/assets/js/custome.js') }}"></script>

    <script src="{{ asset('backend/assets/js/validate.min.js') }}"></script>
    <!-- App js-->
    <script src="{{ asset('backend/assets/js/app.js') }}"></script>

    <!-- Datatables js -->
    <script src="{{ asset('backend/assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>

    <!-- dataTables.bootstrap5 -->
    <script src="{{ asset('backend/assets/libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>

    <!-- Datatable Demo App Js -->
    <script src="{{ asset('backend/assets/js/pages/datatable.init.js') }}"></script>


    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        @if (Session::has('message'))
            var type = "{{ Session::get('alert-type', 'info') }}"
            switch (type) {
                case 'info':
                    toastr.info(" {{ Session::get('message') }} ");
                    break;

                case 'success':
                    toastr.success(" {{ Session::get('message') }} ");
                    break;

                case 'warning':
                    toastr.warning(" {{ Session::get('message') }} ");
                    break;

                case 'error':
                    toastr.error(" {{ Session::get('message') }} ");
                    break;
            }
        @endif
    </script>
    <script>
        window.addEventListener("load", function() {
            let loader = document.getElementById("page-loader");
            loader.style.opacity = "0";

            setTimeout(() => {
                loader.style.display = "none";
            }, 300);
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toggleButton = document.querySelector('.button-toggle-menu');
            const body = document.body;
            const overlay = document.querySelector('.sidebar-overlay');

            if(toggleButton) {
                toggleButton.addEventListener('click', function(e) {
                    e.preventDefault();
                    body.classList.toggle('sidebar-open');
                });
            }

            if(overlay) {
                overlay.addEventListener('click', function() {
                    body.classList.remove('sidebar-open');
                });
            }
            
            window.addEventListener('resize', function() {
                if (window.innerWidth > 991) {
                    body.classList.remove('sidebar-open');
                }
            });
        });
    </script>

    @yield('scripts')
</body>

</html>
