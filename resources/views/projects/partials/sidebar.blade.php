<?php
$master_module = '';
$payroll_menu = '';
$employee = '';
$report = '';
//dd($Roledata);
// dd($Roledata);
foreach ($Roledata as $roles) {
    if (Session::get('adminusernmae') == $roles->member_id) {
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
<!-- Left Panel -->
@if(Session('admin')->user_type=='user')
<aside id="left-panel" class="left-panel">
    <nav class="navbar navbar-expand-sm navbar-default">
        <div id="main-menu" class="main-menu collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li class="active">
                    <a href="{{ url('projects/dashboard') }}"><img src="{{ asset('images/dashboard-icon.png') }}"
                            alt="" />Dashboard </a>
                </li>

                <li><a href="{{ url('timesheets/view-sheets') }}"><img src="{{ asset('images/module.png') }}" alt="" />
                        TimeSheet</a></li>

            </ul>
        </div><!-- /.navbar-collapse -->
    </nav>
</aside>
@else
<aside id="left-panel" class="left-panel">
    <nav class="navbar navbar-expand-sm navbar-default">
        <div id="main-menu" class="main-menu collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li class="active">
                    <a href="{{ url('projects/dashboard') }}"><img src="{{ asset('images/dashboard-icon.png') }}"
                            alt="" />Dashboard </a>
                </li>
                <li><a href="{{ url('projects/clients') }}"><img src="{{ asset('images/company.png') }}" alt="" />
                        Clients</a></li>
                <li><a href="{{ url('projects/vw-project') }}"><img src="{{ asset('images/lv-rule.png') }}" alt="" />
                        Projects</a></li>
                <li><a href="{{ url('timesheets/') }}"><img src="{{ asset('images/module.png') }}" alt="" />
                        TimeSheet</a></li>
                <!-- <li><a href="{{ url('#') }}"><img src="{{ asset('images/company.png') }}" alt="" />
                        Health</a></li> -->
            </ul>
        </div><!-- /.navbar-collapse -->
    </nav>
</aside>
@endif
<!-- /#left-panel -->
