<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
    {{-- <!-- Google Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap"> --}}
    <!-- Bootstrap core CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Material Design Bootstrap -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.1/css/mdb.min.css" rel="stylesheet">

    {{-- datatable --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">

    <link rel='stylesheet' id='wsl-widget-css'
        href='https://mdbcdn.b-cdn.net/wp-content/plugins/wordpress-social-login/assets/css/style.css?ver=5.6.2'
        type='text/css' media='all' />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.20.0/css/mdb.min.css">

    {{-- <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css"> --}}

    {{-- daterange --}}
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    {{-- select2 --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css">

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @yield('extra_css')
</head>

<body>
    <div class="page-wrapper chiller-theme">
        <nav id="sidebar" class="sidebar-wrapper">
            <div class="sidebar-content">
                <div class="sidebar-brand">
                    <a href="#">Hr Admin</a>
                    <div id="close-sidebar">
                        <i class="fas fa-times"></i>
                    </div>
                </div>
                <div class="sidebar-header">
                    <div class="user-pic">
                        <img class="img-responsive img-rounded" src="{{ auth()->user()->profile_img_path() }}"
                            alt="">
                    </div>
                    <div class="user-info">
                        <span class="user-name">
                            {{ auth()->user()->name }}
                        </span>
                        <span
                            class="user-role">{{ auth()->user()->department ? auth()->user()->department->title : 'No Department' }}</span>
                        <span class="user-status">
                            <i class="fa fa-circle"></i>
                            <span>Online</span>
                        </span>
                    </div>
                </div>
                <!-- sidebar-header  -->
                <!-- sidebar-search  -->
                <div class="sidebar-menu">
                    <ul>
                        <li class="header-menu">
                            <span>Menu</span>
                        </li>
                        <li>
                            <a href="{{ route('home') }}">
                                <i class="fas fa-home"></i>
                                <span>Home</span>
                            </a>
                        </li>
                        @can('view_company_setting')
                            <li>
                                <a href="{{ route('company-setting.show', 1) }}">
                                    <i class="fas fa-building"></i>
                                    <span>Company Setting</span>
                                </a>
                            </li>
                        @endcan
                        @can('view_employee')
                            <li>
                                <a href="{{ route('employee.index') }}">
                                    <i class="fas fa-users"></i>
                                    <span>Employees</span>
                                </a>
                            </li>
                        @endcan
                        @can('view_salary')
                            <li>
                                <a href="{{ route('salary.index') }}">
                                    <i class="fas fa-money-bill"></i>
                                    <span>Salary</span>
                                </a>
                            </li>
                        @endcan
                        @can('view_department')
                            <li>
                                <a href="{{ route('department.index') }}">
                                    <i class="fas fa-sitemap"></i>
                                    <span>Department</span>
                                </a>
                            </li>
                        @endcan
                        @can('view_role')
                            <li>
                                <a href="{{ route('role.index') }}">
                                    <i class="fas fa-user-shield"></i>
                                    <span>Role</span>
                                </a>
                            </li>
                        @endcan
                        @can('view_permission')
                            <li>
                                <a href="{{ route('permission.index') }}">
                                    <i class="fas fa-shield-alt"></i>
                                    <span>Permission</span>
                                </a>
                            </li>
                        @endcan
                        @can('view_project')
                            <li>
                                <a href="{{ route('project.index') }}">
                                    <i class="fas fa-toolbox"></i>
                                    <span>Project</span>
                                </a>
                            </li>
                        @endcan
                        @can('view_attendance')
                            <li>
                                <a href="{{ route('attendance.index') }}">
                                    <i class="fas fa-calendar-check"></i>
                                    <span>Attendance(Emp)</span>
                                </a>
                            </li>
                        @endcan
                        @can('view_attendance_overview')
                            <li>
                                <a href="{{ route('attendance.overview') }}">
                                    <i class="fas fa-calendar-check"></i>
                                    <span>Attendance(view)</span>
                                </a>
                            </li>
                        @endcan
                        @can('view_payroll')
                            <li>
                                <a href="{{ route('payroll') }}">
                                    <i class="fas fa-money-check"></i>
                                    <span>Payroll</span>
                                </a>
                            </li>
                        @endcan


                        {{-- <li class="sidebar-dropdown">
                            <a href="#">
                                <i class="fa fa-globe"></i>
                                <span>Maps</span>
                            </a>
                            <div class="sidebar-submenu">
                                <ul>
                                    <li>
                                        <a href="#">Google maps</a>
                                    </li>
                                    <li>
                                        <a href="#">Open street map</a>
                                    </li>
                                </ul>
                            </div>
                        </li> --}}
                    </ul>
                </div>
                <!-- sidebar-menu  -->
            </div>
            <!-- sidebar-content  -->

        </nav>
        <!-- sidebar-wrapper  -->
        <div class="app-bar">
            <div class="d-flex justify-content-center">
                <div class="col-md-10">
                    <div class="d-flex justify-content-between">
                        @if (request()->is('/'))
                            <a id="show-sidebar" href="#">
                                <i class="fas fa-bars"></i>
                            </a>
                        @else
                            <a id="back-btn" href="#">
                                <i class="fas fa-chevron-left"></i>
                            </a>
                        @endif

                        <h5 class="mb-0">@yield('title')</h5>
                        <a href=""></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="py-4 content">
            <div class="d-flex justify-content-center">
                <div class="col-md-10">
                    @yield('content')
                </div>
            </div>
        </div>
        <div class="bottom-bar">
            <div class="d-flex justify-content-center">
                <div class="col-md-10">
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('home') }}">
                            <i class="fas fa-home"></i>
                            <p class="mb-0">Home</p>
                        </a>
                        <a href="{{ route('attendance-scan') }}">
                            <i class="fas fa-user-clock"></i>
                            <p class="mb-0">Attendence</p>
                        </a>
                        <a href="">
                            <i class="fas fa-briefcase"></i>
                            <p class="mb-0">Project</p>
                        </a>
                        <a href="{{ route('profile.profile') }}">
                            <i class="fas fa-user"></i>
                            <p class="mb-0">Profile</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- JQuery -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Bootstrap tooltips -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.4/umd/popper.min.js"></script>
    <!-- Bootstrap core JavaScript -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.min.js">
    </script>
    <!-- MDB core JavaScript -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.1/js/mdb.min.js"></script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>

    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    {{-- datatable --}}
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    {{-- datatable search mark --}}
    <script src="https://cdn.jsdelivr.net/g/mark.js(jquery.mark.min.js)"></script>
    <script src="https://cdn.datatables.net/plug-ins/1.10.13/features/mark.js/datatables.mark.js"></script>

    {{-- daterange --}}
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    <!-- Laravel Javascript Validation -->
    <script type="text/javascript" src="{{ url('vendor/jsvalidation/js/jsvalidation.js') }}"></script>

    {{-- sweetalert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- sweetalert1 --}}
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    {{-- select2 --}}
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="{{ Vite::asset('resources/js/vendor/webauthn/webauthn.js') }}"></script>

    @vite(['resources/js/app.js'])
    {{-- side bar --}}
    <script>
        let Toast;
        $(function($) {
            let token = document.head.querySelector('meta[name="csrf-token"]');
            if (token) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': token.content
                    }
                });
            } else {
                console.error('CSRF Token not Found')
            }

            $(".sidebar-dropdown > a").click(function() {
                $(".sidebar-submenu").slideUp(200);
                if (
                    $(this).parent().hasClass("active")
                ) {
                    $(".sidebar-dropdown").removeClass("active");
                    $(this).parent().removeClass("active");
                } else {
                    $(".sidebar-dropdown").removeClass("active");
                    $(this).next(".sidebar-submenu").slideDown(200);
                    $(this).parent().addClass("active");
                }
            });

            $("#close-sidebar").click(function(e) {
                e.preventDefault();
                $(".page-wrapper").removeClass("toggled");
            });
            $("#show-sidebar").click(function(e) {
                e.preventDefault();
                $(".page-wrapper").addClass("toggled");
            });

            @if (request()->is('/'))
                document.addEventListener('click', function() {
                    if (document.getElementById('show-sidebar').contains(event.target)) {
                        $(".page-wrapper").addClass("toggled");
                    } else if (!document.getElementById('sidebar').contains(event.target)) {
                        $(".page-wrapper").removeClass("toggled");
                    }
                });
            @endif

            @if (session('create'))
                Swal.fire({
                    title: 'Successfully created',
                    text: "{{ session('create') }}",
                    icon: 'success',
                    confirmButtonText: 'Continue'
                })
            @endif
            @if (session('edit'))
                Swal.fire({
                    title: 'Successfully edited',
                    text: "{{ session('edit') }}",
                    icon: 'success',
                    confirmButtonText: 'Continue'
                })
            @endif
            $.extend(true, $.fn.dataTable.defaults, {
                responsive: true,
                processing: true,
                serverSide: true,
                mark: true,
                columnDefs: [{
                        target: 0,
                        class: "control"
                    },
                    {
                        target: "no-sort",
                        orderable: false
                    },
                    {
                        target: "no-search",
                        searchable: false
                    },
                    {
                        target: "hidden",
                        visible: false
                    },
                ],
                language: {
                    "paginate": {
                        "previous": "<i class='far fa-arrow-alt-circle-left'></i>",
                        "next": "<i class='far fa-arrow-alt-circle-right'></i>"
                    },
                    "processing": "<img src='/image/loading.gif' style='width:50%'/>"
                },
            });
            $('#back-btn').on('click', function(e) {
                e.preventDefault();
                window.history.go(-1);
                return false;
            })
            $('.select-customize').select2({
                placeholder: '--Please Choose--',
                allowClear: true,
                theme: 'bootstrap4',
            });
        });
        Toast = Swal.mixin({
            toast: true,
            position: "top",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        });
    </script>
    @yield('script')
</body>

</html>
