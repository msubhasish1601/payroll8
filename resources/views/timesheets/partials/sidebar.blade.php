<?php
$master_module = '';
$payroll_menu = '';
$employee = '';
$report = '';
$emp_access_val = '';

foreach ($Roledata as $roles) {
    if (Session('admin')->email == $roles->member_id) {
        if ($roles->menu == 'Master Module') {
            $master_module = 'master_module';
        }
        if ($roles->menu == 'payroll head') {
            $payroll_menu = 'payroll_menu';
        }
        if ($roles->menu == 'employee') {
            $employee = 'employee_menu';
        }
        if ($roles->menu == 'report') {
            $report = 'report_menu';
        }
    }
}

?>
<style>
    .navbar .navbar-nav li.menu-item-has-children .sub-menu {
        padding-left: 0;
    }
</style>

@if(Session('admin')->user_type=='user')
<aside id="left-panel" class="left-panel">
    <nav class="navbar navbar-expand-sm navbar-default">
        <div id="main-menu" class="main-menu collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li class="active">
                    <a href="{{ url('timesheets/dashboard') }}"><img src="{{ asset('images/dashboard-icon.png') }}"
                            alt="" />Dashboard </a>
                </li>


                <li><a href="{{ url('timesheets/view-sheets') }}"><img src="{{ asset('images/module.png') }}" alt="" />
                        TimeSheet</a></li>


            </ul>
        </div><!-- /.navbar-collapse -->
    </nav>
</aside>

@endif
