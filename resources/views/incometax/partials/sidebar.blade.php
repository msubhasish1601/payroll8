<?php
$master_module = '';
$payroll_menu = '';
$employee = '';
$report = '';
//dd($Roledata);
// dd($Roledata);
foreach ($Roledata as $roles) {
    if (Session::get('admin')->email == $roles->member_id) {
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
@if(Session::get('admin')->user_type=='user')

<aside id="left-panel" class="left-panel">
    <nav class="navbar navbar-expand-sm navbar-default">
        <div id="main-menu" class="main-menu collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li class="active">
                    <a href="{{ url('finance-dashboard') }}"><img src="{{ asset('images/dashboard-icon.png') }}" alt="" />Dashboard </a>
                </li>

                @php $menus = array();
                    foreach ($Roledata as $roleaccess) {
                        $menus[] = $roleaccess->menu;
                    }
                    $menuslist = array_unique($menus);
                @endphp



                <li class="menu-item-has-children dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="{{ asset('images/attendence.png') }}" alt="" /> I Tax</a>
                    <ul class="sub-menu children dropdown-menu">

                        <li><a href="{{ url('itax/itax-rate-slab') }}"><img src="{{ asset('images/lv-rule.png') }}" alt="" /> I Tax Rate Slab Master</a></li>
                        <li><a href="{{ url('itax/income-tax-type') }}"><img src="{{ asset('images/lv-rule.png') }}" alt="" /> I Tax Type</a></li>
                        <li><a href="{{ url('itax/saving-type') }}"><img src="{{ asset('images/lv-rule.png') }}" alt="" /> I Tax Savings Type</a></li>
                        <li><a href="{{ url('itax/deposit') }}"><img src="{{ asset('images/lv-rule.png') }}" alt="" /> I Tax Deposits</a></li>
                        <li><a href="{{ url('itax/employee-savings') }}"><img src="{{ asset('images/lv-rule.png') }}" alt="" /> I Tax Savings</a></li>

                    </ul>
                </li>
                <li class="menu-item-has-children dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <img src="{{ asset('images/reports.png') }}" alt="" /> Reports</a>
                    <ul class="sub-menu children dropdown-menu">
                        <li><a href="{{ url('itax/employee-savings-report') }}"><img src="{{ asset('images/lv-rule.png') }}" alt="" />ITax Report</a></li>
                        <li><a href="{{ url('itax/form-sixteen') }}"><img src="{{ asset('images/lv-rule.png') }}" alt="" />Form 16</a></li>

                    </ul>
                </li>


            </ul>
        </div>
    </nav>
</aside>
@else


<aside id="left-panel" class="left-panel">

    <nav class="navbar navbar-expand-sm navbar-default">
        <div id="main-menu" class="main-menu collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li class="active">
                    <a href="{{ url('finance-dashboard') }}"><img src="{{ asset('images/dashboard-icon.png') }}" alt="" />Dashboard </a>
                </li>

                <li class="menu-item-has-children dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="{{ asset('images/attendence.png') }}" alt="" /> I Tax</a>
                    <ul class="sub-menu children dropdown-menu">

                        <li><a href="{{ url('itax/itax-rate-slab') }}"><img src="{{ asset('images/lv-rule.png') }}" alt="" /> I Tax Rate Slab Master</a></li>
                        <li><a href="{{ url('itax/income-tax-type') }}"><img src="{{ asset('images/lv-rule.png') }}" alt="" /> I Tax Type</a></li>
                        <li><a href="{{ url('itax/saving-type') }}"><img src="{{ asset('images/lv-rule.png') }}" alt="" /> I Tax Savings Type</a></li>
                        <li><a href="{{ url('itax/deposit') }}"><img src="{{ asset('images/lv-rule.png') }}" alt="" /> I Tax Deposits</a></li>
                        <li><a href="{{ url('itax/employee-savings') }}"><img src="{{ asset('images/lv-rule.png') }}" alt="" /> I Tax Savings</a></li>

                    </ul>
                </li>
                <li class="menu-item-has-children dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <img src="{{ asset('images/reports.png') }}" alt="" /> Reports</a>
                    <ul class="sub-menu children dropdown-menu">
                        <li><a href="{{ url('itax/employee-savings-report') }}"><img src="{{ asset('images/lv-rule.png') }}" alt="" />ITax Report</a></li>
                        <li><a href="{{ url('itax/form-sixteen') }}"><img src="{{ asset('images/lv-rule.png') }}" alt="" />Form 16</a></li>

                    </ul>
                </li>



            </ul>
        </div>
    </nav>
</aside>
@endif
