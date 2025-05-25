@include('include.hcm-dashboard-head')

<body>
    <?php $admin = Session::get('admin');?>
    @if($admin->user_type=='user')
    <div class="header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4">
                    <img src="{{ asset('theme/images/payroll-logo.png') }}" width="83px">
                </div>
                <div class="col-md-8">
                    <div  style="float:right;">
                        <a style="display: block;overflow: hidden;float:left;padding: 20px 15px 0 0;" class="home"
                            href="{{url('dashboard')}}"><img style="width:25px;"
                                src="{{ asset('images/home-black.png') }}" alt="Logo"></a>
                        <a title="Logout" style="display: block;overflow: hidden;float:left;padding: 25px 15px 0 0;"
                            class="home" href="{{url('logout')}}"><img style="width:25px;"
                                src="{{ asset('images/logout-black.png') }}" alt="Logo"></a>

                    </div>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4">
                    <img src="{{ asset('theme/images/payroll-logo.png') }}" width="83px">
                </div>
                <div class="col-md-8">
                    <div style="float:right;">
                        <a style="display: block;overflow: hidden;float:left;padding: 20px 15px 0 0;" class="home"
                            href="{{url('dashboard')}}"><img style="width:25px;"
                                src="{{ asset('images/home-black.png') }}" alt="Logo"></a>
                        <a title="Logout" style="display: block;overflow: hidden;float:left;padding: 25px 15px 0 0;"
                            class="home" href="{{url('logout')}}"><img style="width:25px;"
                                src="{{ asset('images/logout-black.png') }}" alt="Logo"></a>

                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    <div class="main-body">
        <div class="container-fluid">
            <div class="inner-dashboard">
                <div class="hcm-head">
                    <h1><span>HCM</span> Human Capital Management</h1>
                </div>
                @php
                $payroll = '';
                $attendance = '';
                $leave_application = '';
                @endphp

                @if($admin->user_type=='user')
                @foreach($Roledata as $roles)
                @if(Session::get('adminusernmae')==$roles->member_id)
                @if($roles->sub_module_name=='payroll')
                @php $payroll = 'payroll'; @endphp
                @endif
                @if($roles->sub_module_name=='Leave application')
                @php $leave_application = 'Leave_application'; @endphp
                @endif
                @if($roles->sub_module_name=='attendance')
                @php $attendance = 'attendance'; @endphp
                @endif

                @php $module_name = $roles->sub_module_name; @endphp
                @endif
                @endforeach
                @endif

                <div class="hcm-inner">
                    <div class="row">
                        @if(Session('admin')->user_type=='user')
                        @php $submenus = array();
                        foreach ($Roledata as $roleaccess) {
                        $submenus[] = $roleaccess->sub_module_name;
                        }
                        $submenuslist = array_unique($submenus);
                        @endphp

                        @if(in_array("Employee", $submenuslist))
                        <div class="col-md-4">
                            <div class="hcm">
                                <div class="row">
                                    <div class="col-md-4 col-4 pr0">
                                        <div class="hcm-icon">
                                            <img class="" src="{{ asset('theme/images/hr.png') }}" alt="">
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-8 pl0">
                                        <div class="hcm-name">
                                            <p>Employee</p>
                                            <a href="{{ url('employee/dashboard') }}"><img class=""
                                                    src="{{ asset('theme/images/arrow.png') }}" alt=""></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif


                        @if(in_array("Leave Management", $submenuslist))

                        <div class="col-md-4">
                            <div class="hcm">
                                <div class="row">
                                    <div class="col-md-4 col-4 pr0">
                                        <div class="hcm-icon green">
                                            <img class="" src="{{ asset('theme/images/payroll.png') }}" alt="">
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-8 pl0">
                                        <div class="hcm-name green">
                                            <p>Leave Management</p>
                                            <a href="{{ url('leavemanagement/dashboard') }}"><img class=""
                                                    src="{{ asset('theme/images/arrow.png') }}" alt=""></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @endif

                        @if(in_array("Holiday Management", $submenuslist))
                        <div class="col-md-4">
                            <div class="hcm">
                                <div class="row">
                                    <div class="col-md-4 col-4 pr0">
                                        <div class="hcm-icon vio">
                                            <img class="" src="{{ asset('theme/images/intervw.png') }}" alt="">
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-8 pl0">
                                        <div class="hcm-name vio">
                                            <p>Holiday Management</p>
                                            <a href="{{ url('holiday/dashboard') }}"><img class=""
                                                    src="{{ asset('theme/images/arrow.png') }}" alt=""></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif


                        @if(in_array("Leave application", $submenuslist))
                        <div class="col-md-4">
                            <div class="hcm">
                                <div class="row">
                                    <div class="col-md-4 col-4 pr0">
                                        <div class="hcm-icon vio">
                                            <img class="" src="{{ asset('theme/images/intervw.png') }}" alt="">
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-8 pl0">
                                        <div class="hcm-name vio">
                                            <p>Employee Corner</p>
                                            <a href="{{ url('employee-corner/dashboard') }}"><img class=""
                                                    src="{{ asset('theme/images/arrow.png') }}" alt=""></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        @if(in_array("Leave & Tour Approver", $submenuslist))
                        <div class="col-md-4">
                            <div class="hcm">
                                <div class="row">
                                    <div class="col-md-4 col-4 pr0">
                                        <div class="hcm-icon vio">
                                            <img class="" src="{{ asset('theme/images/intervw.png') }}" alt="">
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-8 pl0">
                                        <div class="hcm-name vio">
                                            <p>Approver Corner</p>
                                            <a href="{{ url('leave-approver/dashboard') }}"><img class=""
                                                    src="{{ asset('theme/images/arrow.png') }}" alt=""></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        @if (in_array("Attendance", $submenuslist))
                        <div class="col-md-4">
                            <div class="hcm">
                                <div class="row">
                                    <div class="col-md-4 col-4 pr0">
                                        <div class="hcm-icon red">
                                            <img class="" src="{{ asset('theme/images/role.png') }}" alt="">
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-8 pl0">
                                        <div class="hcm-name red">
                                            <p>Attendance</p>
                                            <a href="{{ url('attendance/dashboard') }}"><img class=""
                                                    src="{{ asset('theme/images/arrow.png') }}" alt=""></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        <!-- </div> -->
                        @else
                        <div class="col-md-4">
                            <div class="hcm">
                                <div class="row">
                                    <div class="col-md-4 col-4 pr0">
                                        <div class="hcm-icon">
                                            <img class="" src="{{ asset('theme/images/hr.png') }}" alt="">
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-8 pl0">
                                        <div class="hcm-name">
                                            <p>Employee</p>
                                            <a href="{{ url('employee/dashboard') }}"><img class=""
                                                    src="{{ asset('theme/images/arrow.png') }}" alt=""></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="hcm">
                                <div class="row">
                                    <div class="col-md-4 col-4 pr0">
                                        <div class="hcm-icon green">
                                            <img class="" src="{{ asset('theme/images/payroll.png') }}" alt="">
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-8 pl0">
                                        <div class="hcm-name green">
                                            <p>Leave Management</p>
                                            <a href="{{ url('leavemanagement/dashboard') }}"><img class=""
                                                    src="{{ asset('theme/images/arrow.png') }}" alt=""></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="hcm">
                                <div class="row">
                                    <div class="col-md-4 col-4 pr0">
                                        <div class="hcm-icon vio">
                                            <img class="" src="{{ asset('theme/images/intervw.png') }}" alt="">
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-8 pl0">
                                        <div class="hcm-name vio">
                                            <p>Holiday Management</p>
                                            <a href="{{ url('holiday/dashboard') }}"><img class=""
                                                    src="{{ asset('theme/images/arrow.png') }}" alt=""></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="hcm">
                                <div class="row">
                                    <div class="col-md-4 col-4 pr0">
                                        <div class="hcm-icon sky">
                                            <img class="" src="{{ asset('theme/images/Leave-Approve-icon.png') }}"
                                                alt="">
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-8 pl0">
                                        <div class="hcm-name sky">
                                            <p>Leave & Tour Approver</p>
                                            <a href="{{ url('leave-approver/dashboard') }}"><img class=""
                                                    src="{{ asset('theme/images/arrow.png') }}" alt=""></a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                         <div class="col-md-4">
                            <div class="hcm">
                                <div class="row">
                                    <div class="col-md-4 col-4 pr0">
                                        <div class="hcm-icon red">
                                            <img class="" src="{{ asset('theme/images/role.png') }}" alt="">
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-8 pl0">
                                        <div class="hcm-name red">
                                            <p>Attendance</p>
                                            <a href="{{ url('attendance/dashboard') }}"><img class=""
                                                    src="{{ asset('theme/images/arrow.png') }}" alt=""></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                         </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>
    </div>

    <footer>
        <p>&copy; Copyright {{date('Y')}} {{ config('app.name', 'Laravel') }} | All Right Reserved</p>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@2.2.4/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.4/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-match-height@0.7.2/dist/jquery.matchHeight.min.js"></script>
    <script src="{{ asset('theme/assets/js/main.js') }}"></script>

    <!--<script src="dragonfly.js"></script>-->
    <script src="{{ asset('theme/assets/js/jquery.js') }}" type='text/javascript'></script>
    <script src="{{ asset('theme/assets/js/jquery.gridly.js') }}" type='text/javascript'></script>
    <script src="{{ asset('theme/assets/js/sample.js') }}" type='text/javascript'></script>
    <script src="{{ asset('theme/assets/js/rainbow.js') }}" type='text/javascript'></script>
</body>

</html>