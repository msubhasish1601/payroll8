@include('include.hcm-dashboard-head')

<body>
    @if(Session::get('admin'))
    <div class="header">
        <div class="container-fluid">
            <div class="row">
            <div class="col-md-4">
			<img src="{{ asset('theme/images/payroll-logo.png') }}" width="83px">
			</div>
                <div class="col-md-8">
                    <div  style="float:right;">
                    <a style="display: block;overflow: hidden;float:left;padding: 20px 15px 0 0;" class="home" href="{{url('dashboard')}}"><img style="width:25px;" src="{{ asset('images/home-black.png') }}" alt="Logo"></a>
                    <a title="Logout" style="display: block;overflow: hidden;float:left;padding: 25px 15px 0 0;" class="home" href="{{url('logout')}}"><img style="width:25px;" src="{{ asset('images/logout-black.png') }}" alt="Logo"></a>

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
				    <h1><span>FM</span> Finance Management</h1>
				</div>
                @php
                    $payroll = '';
                    $attendance = '';
                    $leave_application = '';
                @endphp
                @if(Session::get('admin'))
                    @foreach($Roledata as $roles)
                        @if(Session::get('admin')->email==$roles->member_id)
                            @if($roles->sub_module_name=='payroll')
                            <?php $payroll = 'payroll';?>
                            @endif
                            @if($roles->sub_module_name=='Leave application')
                            <?php $leave_application = 'Leave_application';?>

                            @endif
                            @if($roles->sub_module_name=='attendance')
                            <?php $attendance = 'attendance';?>

                            @endif

                        <?php $module_name = $roles->sub_module_name;?>
                        @endif
                    @endforeach
                @endif
                <div class="text-center col-lg-12" style="padding:0;">
                    <div class="payroll-main">
                        <div class="row">
                            @if(Session::get('admin')->user_type=='user')
                                @php $submenus = array();
                                    foreach ($Roledata as $roleaccess) {
                                        $submenus[] = $roleaccess->sub_module_name;
                                    }
                                    $submenuslist = array_unique($submenus);
                                @endphp
                                <?php if (in_array("Payroll", $submenuslist)) {?>
                                    <div class="col-md-4">
                                        <div class="hcm">
                                            <div class="row">
                                                <div class="col-md-4 col-4 pr0">
                                                    <div class="hcm-icon">
                                                        <img class="" src="{{ asset('theme/images/payroll.png') }}" alt="">
                                                    </div>
                                                </div>
                                                <div class="col-md-8 col-8 pl0">
                                                    <div class="hcm-name">
                                                        <p>Payroll</p>
                                                        <a href="{{ url('payroll/dashboard') }}"><img class="" src="{{ asset('theme/images/arrow.png') }}" alt=""></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="hcm" style="margin: 40px 30px 40px 0;">
                                            <div class="row">
                                                <div class="col-md-4 col-4 pr0">
                                                    <div class="hcm-icon green">
                                                        <img class="" src="{{ asset('theme/images/leave-application-icon.png') }}" alt=""style="max-width:120px;">
                                                    </div>
                                                </div>
                                                <div class="col-md-8 col-8 pl0">
                                                    <div class="hcm-name green">
                                                        <p>Loans</p>
                                                        <a href="{{ url('loans/view-loans') }}"><img class="" src="{{ asset('theme/images/arrow.png') }}" alt=""></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="hcm" style="margin: 40px 30px 40px 0;">
                                            <div class="row">
                                                <div class="col-md-4 col-4 pr0">
                                                    <div class="hcm-icon green">
                                                        <img class="" src="{{ asset('theme/images/leave-application-icon.png') }}" alt=""style="max-width:120px;">
                                                    </div>
                                                </div>
                                                <div class="col-md-8 col-8 pl0">
                                                    <div class="hcm-name green">
                                                        <p>Income Tax</p>
                                                        <a href="{{ url('itax/dashboard') }}"><img class="" src="{{ asset('theme/images/arrow.png') }}" alt=""></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php }?>
                            @else
                            <div class="col-md-4">
                                <div class="hcm" style="margin: 40px 30px 40px 0;">
                                    <div class="row">
                                        <div class="col-md-4 col-4 pr0">
                                            <div class="hcm-icon green">
                                                <img class="" src="{{ asset('theme/images/leave-application-icon.png') }}" alt=""style="max-width:120px;">
                                            </div>
                                        </div>
                                        <div class="col-md-8 col-8 pl0">
                                            <div class="hcm-name green">
                                                <p>Payroll</p>
                                                <a href="{{ url('payroll/dashboard') }}"><img class="" src="{{ asset('theme/images/arrow.png') }}" alt=""></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="hcm" style="margin: 40px 30px 40px 0;">
                                    <div class="row">
                                        <div class="col-md-4 col-4 pr0">
                                            <div class="hcm-icon green">
                                                <img class="" src="{{ asset('theme/images/leave-application-icon.png') }}" alt=""style="max-width:120px;">
                                            </div>
                                        </div>
                                        <div class="col-md-8 col-8 pl0">
                                            <div class="hcm-name green">
                                                <p>Loans</p>
                                                <a href="{{ url('loans/view-loans') }}"><img class="" src="{{ asset('theme/images/arrow.png') }}" alt=""></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="hcm" style="margin: 40px 30px 40px 0;">
                                    <div class="row">
                                        <div class="col-md-4 col-4 pr0">
                                            <div class="hcm-icon green">
                                                <img class="" src="{{ asset('theme/images/leave-application-icon.png') }}" alt=""style="max-width:120px;">
                                            </div>
                                        </div>
                                        <div class="col-md-8 col-8 pl0">
                                            <div class="hcm-name green">
                                                <p>Income Tax</p>
                                                <a href="{{ url('itax/dashboard') }}"><img class="" src="{{ asset('theme/images/arrow.png') }}" alt=""></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>



                        </div>

                        </div>




@endif


</div>

        </div>

        <footer><p>&copy; Copyright {{date('Y')}} {{ config('app.name', 'Laravel') }} | All Right Reserved</p></footer>

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