<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="_token" content="{{ csrf_token() }}" />
    <title>KURS INDONESIA | ADMIN</title>
    <!-- base:css -->
    <link rel="stylesheet" href="{{ asset('assets/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/base/vendor.bundle.base.css') }}">
    <!-- endinject -->
    <!-- plugin css for this page -->
    <link rel="stylesheet" href="{{ asset('assets/vendors/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/select2-bootstrap-theme/select2-bootstrap.min.css') }}">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="{{ asset('assets/css/vertical-layout-light/style.css') }}">
    <!-- endinject -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" />
    <script>
        function generateNotification($alert_type, $message) {
                var html = '<div class="alert alert-' + $alert_type + '"><button type="button" class="close" data-dismiss="alert">&times;</button>';
                html += '<p>' + $message + '</p>';
                html += '</div>';

                return $.parseHTML(html);
            }
    </script>
    @yield('css-content')
</head>

<body class="sidebar-toggle-display ">
    <div class="container-scroller">
        <!-- partial:../../partials/_navbar.html -->
        <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
            <div class="text-left navbar-brand-wrapper d-flex align-items-center justify-content-between">
            <h4 style="color:white"> KURS ID</h4>
                <button class="navbar-toggler align-self-center" type="button" data-toggle="minimize">
                    <span class="mdi mdi-menu"></span>
                </button>
            </div>
            <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
                <ul class="navbar-nav">
                    <li class="nav-item dropdown align-items-center d-lg-flex d-none">
                        <a class="dropdown-toggle btn btn-outline-secondary btn-fw" href="#" data-toggle="dropdown"
                            id="appDropdown">
                            <span class="nav-profile-name">More</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="appDropdown">
                            <a class="dropdown-item" href="{{url('admin/logout')}}">
                                <i class="mdi mdi-logout text-primary"></i>
                                Logout
                            </a>
                        </div>
                    </li> 
                </ul>
            </div>
        </nav>
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            @include('template.sidebar')
            <!-- partial -->
            <div class="main-panel">
                @yield('main-content')
                <!-- content-wrapper ends -->
                <!-- partial:../../partials/_footer.html -->
                <div class="footer-wrapper">
                    <footer class="footer">
                        <div class="d-sm-flex justify-content-center justify-content-sm-between">
                            <span class="text-center text-sm-left d-block d-sm-inline-block">Copyright &copy; 2019. All
                                rights reserved. </span>
                          
                        </div>
                    </footer>
                </div>
                <!-- partial -->
            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- base:js -->
    <script src="{{ asset('assets/vendors/base/vendor.bundle.base.js') }}"></script>
    <!-- endinject -->
    <!-- inject:js -->
    <script src="{{ asset('assets/js/off-canvas.js') }}"></script>
    <script src="{{ asset('assets/js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('assets/js/template.js') }}"></script>
    <script src="{{ asset('assets/js/settings.js') }}"></script>
    <script src="{{ asset('assets/js/todolist.js') }}"></script>
    <!-- endinject -->
    <!-- plugin js for this page -->
    <script src="{{ asset('assets/vendors/typeahead.js/typeahead.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/select2/select2.min.js') }}"></script>
    <!-- End plugin js for this page -->
    <!-- Custom js for this page-->
    <script src="{{ asset('assets/js/file-upload.js') }}"></script>
    <script src="{{ asset('assets/js/typeahead.js') }}"></script>
    <script src="{{ asset('assets/js/select2.js') }}"></script>
    <script src="{{ asset('assets/vendors/moment/min/moment.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/parsleyjs/dist/parsley.min.js') }}"></script>
    <script src="{{ asset('js/moment-timezone-with-data.js') }}"></script>
    
    <script type="text/javascript">
        var app_route = "{{ url('') }}";  
        var _token = $('meta[name="_token"]').attr('content');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
    </script>
    @yield('js-content')
    <!-- End custom js for this page-->
</body>

</html>