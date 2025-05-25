<?php

$emp_access_val = '';

foreach ($Roledata as $roles) {
    if (Session('admin')->email == $roles->member_id) {
        if ($roles->menu == 'Employee Access Value') {
            $emp_access_val = 'Emp_Access_Value';
        }

    }
}

?>
@if(Session('admin')->user_type=='user')



<!-- Left Panel -->
<aside id="left-panel" class="left-panel">
    <nav class="navbar navbar-expand-sm navbar-default">
        <div id="main-menu" class="main-menu collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li class="active">
                    <a href="{{ url('employee-corner/dashboard') }}"><img src="{{ asset('images/dashboard-icon.png') }}"
                            alt="" />Dashboard </a>
                </li>

                <?php $menus = array();
foreach ($Roledata as $roleaccess) {
    $menus[] = $roleaccess->menu;

}
$menuslist = array_unique($menus);?>
                <!--<li class="menu-title">UI elements</li>-->
                <!-- /.menu-title -->

                <li class="menu-item-has-children dropdown">
                    <?php if (in_array("3", $menuslist)) {?>
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false"> <img src="{{ asset('images/leave-app.png') }}" alt="" /> Employee
                        Access-Value</a>
                    <ul class="sub-menu children dropdown-menu">
                        <li><a href='{{url("employee-corner/employee-profile")}}'> <img
                                    src="{{ asset('images/leave-mng.png') }}" alt="" />User Profile</a></li>
                        <li><a href="{{ url('employee-corner/holiday-calendar') }}"><img
                                    src="{{ asset('images/leave-app.png') }}" alt="" />Holiday Calendar</a></li>
                        <li><a href="{{ url('employee-corner/apply-leave') }}"><img
                                    src="{{ asset('images/leave-app.png') }}" alt="" />Leave Application</a></li>
                        <!-- <li><a href="{{ url('employee-corner/tourlisting') }}"><img
                                    src="{{ asset('images/daily-att.png') }}" alt="" />Tour Application</a></li>
                        <li><a href="{{ url('employee-corner/apply-for-ltc') }}"><img
                                    src="{{ asset('images/daily-att.png') }}" alt="" />LTC Application</a></li> -->
                        <!-- <li><a href="{{ url('employee-corner/loanlisting') }}"><img
                                    src="{{ asset('images/daily-att.png') }}" alt="" /> Loan Apply</a></li> -->
                        <!--<li><i class="fa fa-bars"></i><a href="view-leave-status.php">View Leave Status</a></li>

							<li><a href="{{ url('leave/vw-loan-sanction') }}"><img src="{{ asset('images/leave-app.png') }}" alt="" />  Loan Sanction</a></li>
							<li><a href="{{ url('leave/salary-advance') }}"><img src="{{ asset('images/daily-att.png') }}" alt="" />  Salary Advance</a></li>-->
                        <li><a href="{{ url('employee/payslip') }}"><img src="{{ asset('images/payroll.png') }}"
                                    alt="" /> Employee Pay Slip</a></li>
                        <!-- <li><a href="{{ url('employee-corner/vw-login-logout-status') }}"><img src="{{ asset('images/login-logout.png') }}" alt="" /> Attendance Status</a></li> -->
                        <!-- <li><a href="{{ url('employee-corner/gpf-details') }}"><img
                                    src="{{ asset('images/login-logout.png') }}" alt="" /> PF View</a></li>
                        <li><a href="{{ url('employee-corner/pension') }}"><img
                                    src="{{ asset('images/login-logout.png') }}" alt="" /> Pension Apply</a></li> -->
                        <li><a target="_blank" href="{{ url('/') }}/HumanResourcesPolicy-QD.pdf"><img src="{{ asset('images/hand.png') }}" alt="" /> HR Policy</a></li>
                    </ul>
                    <?php }?>
                </li>



                <!--<li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <img src="{{ asset('images/daily-att.png') }}" alt="" /> Report Module</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><a href="employee-pay-slip.php"><img src="{{ asset('images/payroll.png') }}" alt="" /> Employee Pay Slip</a></li>

                        </ul>
                    </li>-->


            </ul>
        </div><!-- /.navbar-collapse -->
    </nav>
</aside>
<!-- /#left-panel -->
@else
<aside id="left-panel" class="left-panel">
    <nav class="navbar navbar-expand-sm navbar-default">
        <div id="main-menu" class="main-menu collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li class="active">
                    <a href="dashboard"><img src="{{ asset('images/dashboard-icon.png') }}" alt="" />Dashboard </a>
                </li>
                <!--<li class="menu-title">UI elements</li>-->
                <!-- /.menu-title -->
                <li class="menu-item-has-children dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false"> <img src="{{ asset('images/leave-app.png') }}" alt="" /> Employee
                        Access-Value</a>
                    <ul class="sub-menu children dropdown-menu">

                        <li><a href="{{ url('leave/leave-application') }}"><img
                                    src="{{ asset('images/leave-app.png') }}" alt="" /> Leave Application</a></li>
                        <!--<li><i class="fa fa-bars"></i><a href="view-leave-status.php">View Leave Status</a></li>-->
                        <!-- <li><a href="{{ url('leave/tour-application') }}"><img src="{{ asset('images/daily-att.png') }}"
                                    alt="" /> Tour Application</a></li> -->
                        <!-- <li><a href="{{ url('leave/view-loan') }}"><img src="{{ asset('images/daily-att.png') }}"
                                    alt="" /> Loan Apply</a></li>
                        <li><a href="{{ url('leave/vw-loan-sanction') }}"><img src="{{ asset('images/leave-app.png') }}"
                                    alt="" /> Loan Sanction</a></li> -->
                        <li><a href="{{ url('leave/salary-advance') }}"><img src="{{ asset('images/daily-att.png') }}"
                                    alt="" /> Salary Advance</a></li>
                        <li><a target="_blank" href="{{ url('/') }}/HumanResourcesPolicy-QD.pdf"><img src="{{ asset('images/hand.png') }}" alt="" /> HR Policy</a></li>
                        <li><a href="{{ url('leave/vw-login-logout-status') }}"><img
                                    src="{{ asset('images/login-logout.png') }}" alt="" /> Login Logout Status</a></li>
                    </ul>
                </li>
                <!--<li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <img src="{{ asset('images/daily-att.png') }}" alt="" /> Report Module</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><a href="employee-pay-slip.php"><img src="{{ asset('images/payroll.png') }}" alt="" /> Employee Pay Slip</a></li>

                        </ul>
                    </li>-->


            </ul>
        </div><!-- /.navbar-collapse -->
    </nav>
</aside>

@endif