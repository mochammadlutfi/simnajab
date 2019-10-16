<!doctype html>
<html lang="en" class="no-focus">
    <head>

        @include('layouts.meta')

        <!-- Stylesheets -->

        <!-- Page JS Plugins CSS -->
        <link rel="stylesheet" href="{{ asset('assets/js/plugins/select2/css/select2.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/js/plugins/slick/slick.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/js/plugins/slick/slick-theme.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/js/plugins/datatables/dataTables.bootstrap4.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/js/plugins/sweetalert2/sweetalert2.min.css') }}">
        <link rel="stylesheet" id="css-main" href="{{ asset('assets/css/file-input/fileinput.min.css') }}">
        <link rel="stylesheet" id="css-main" href="{{ asset('assets/css/file-input/input_file.css') }}">

        <!-- Fonts and Codebase framework -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Muli:300,400,400i,600,700">
        <link rel="stylesheet" id="css-main" href="{{ asset('assets/css/codebase.css') }}">
        <style>
            .has-error .select2-selection {
                border-color: rgb(185, 74, 72) !important;
            }
        </style>
        <!-- You can include a specific file from css/themes/ folder to alter the default color theme of the template. eg: -->
        <!-- <link rel="stylesheet" id="css-theme" href="assets/css/themes/flat.min.css"> -->
        <!-- END Stylesheets -->
    </head>
    <body>

            <div id="page-container" class="sidebar-inverse side-scroll page-header-fixed main-content-boxed">

            @include('layouts.sidebar')
            <!-- END Sidebar -->

            <!-- Header -->
            @include('layouts.header')
            <!-- END Header -->

            <!-- Main Container -->
            <main id="main-container">

                <!-- Page Content -->
                @yield('content')
                <!-- END Page Content -->

            </main>
            <!-- END Main Container -->

            <!-- Footer -->
            <footer id="page-footer" class="opacity-0">
                <div class="content py-20 font-size-xs clearfix">
                    <div class="float-right">
                        Crafted with <i class="fa fa-heart text-pulse"></i> by <a class="font-w600" href="#" target="_blank">Pintasku</a>
                    </div>
                    <div class="float-left">
                        <a class="font-w600" href="#" target="_blank">SIMNAJAB</a> &copy; <span class="js-year-copy">2019</span>
                    </div>
                </div>
            </footer>
            <!-- END Footer -->
        </div>
        <!-- END Page Container -->
        {{-- <script src="{{ asset('assets/js/app.js') }}"></script> --}}

        <script src="{{ asset('assets/js/codebase.core.min.js') }}"></script>
        <script src="{{ asset('assets/js/codebase.app.min.js') }}"></script>
        <script src="{{ asset('assets/js/laroute.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pusher/5.0.0/pusher.min.js" integrity="sha256-rumnpK3SJCNuEMjj5oRs5bACsVmCP/TKHg6R6MIWiPo=" crossorigin="anonymous"></script>
        <!-- Page JS Plugins -->
        <script src="{{ asset('assets/js/plugins/bootstrap-wizard/jquery.bootstrap.wizard.js') }}"></script>
        <script src="{{ asset('assets/js/plugins/select2/js/select2.full.min.js') }}"></script>
        <script src="{{ asset('assets/js/plugins/bootstrap-notify/bootstrap-notify.min.js') }}"></script>
        <script src="{{ asset('assets/js/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
        <script src="{{ asset('assets/js/plugins/bootstrap-datepicker/locales/bootstrap-datepicker.id.min.js') }}"></script>
        <script src="{{ asset('assets/js/plugins/chartjs/Chart.bundle.min.js') }}"></script>
        <script src="{{ asset('assets/js/plugins/slick/slick.min.js') }}"></script>
        <script src="{{ asset('assets/js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('assets/js/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('assets/js/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
        <script src="{{ asset('assets/js/file-input/fileinput.js') }}"></script>
        <script src="{{ asset('assets/js/file-input/theme.js') }}"></script>
        <script src="{{ asset('assets/js/file-input/locales/id.js') }}"></script>

        <!-- Page JS Code -->
        <script src="{{ asset('assets/js/pages/be_pages_dashboard.min.js') }}"></script>
        @stack('scripts')
        <script>
            jQuery(function(){ Codebase.helpers(['datepicker', 'select2',]); });
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        </script>
    </body>
</html>
