<?php
$master_module = '';
$payroll_menu = '';
$employee = '';
$report = '';
//dd($Roledata);
// dd($Roledata);
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
.navbar .navbar-nav li.menu-item-has-children .sub-menu{padding-left:0;}
</style>

@if(Session('admin')->user_type=='user')
<aside id="left-panel" class="left-panel">
        <nav class="navbar navbar-expand-sm navbar-default">
            <div id="main-menu" class="main-menu collapse navbar-collapse">

                <?php $menus = array();
foreach ($Roledata as $roleaccess) {
    $menus[] = $roleaccess->menu;

}
$menuslist = array_unique($menus);?>
                <ul class="nav navbar-nav">
                    <li class="active">
                        <a href="{{ url('employee/dashboard') }}"><img src="{{ asset('images/dashboard-icon.png') }}" alt="" />Dashboard </a>
                    </li>

					<li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="{{ asset('images/attendence.png') }}" alt="" /> Employee</a>
                        <ul class="sub-menu children dropdown-menu">
                            <?php if (in_array("1", $menuslist)) {?>
                            <li><a href="{{ url('employees') }}"><img src="{{ asset('images/lv-rule.png') }}" alt="" /> Employee Master</a></li>
                            <?php }?>
							<!--<li><a href="{{ url('pis/vw-payroll-generation') }}"><img src="{{ asset('images/lv-rule.png') }}" alt="" /> Payroll Generation</a></li>
                            <li><a href="{{ url('pis/vw-payroll-generation-all-employee') }}"><img src="{{ asset('images/lv-rule.png') }}" alt="" /> Generate All Employee Payroll</a></li>-->
			            </ul>
					</li>

                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="{{ asset('images/attendence.png') }}" alt="" /> Employee Report Generate</a>
                        <ul class="sub-menu children dropdown-menu">

                            <li><a href="{{ url('employees') }}"><img src="{{ asset('images/lv-rule.png') }}" alt="" /> Employee List Class Wise</a></li>
                            <li><a href="{{ url('employees') }}"><img src="{{ asset('images/lv-rule.png') }}" alt="" /> Employee List Department Wise</a></li>
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
                        <a href="{{ url('employee/dashboard') }}"><img src="{{ asset('images/dashboard-icon.png') }}" alt="" />Dashboard </a>
                    </li>



                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="{{ asset('images/attendence.png') }}" alt="" /> Employee</a>
                        <ul class="sub-menu children dropdown-menu">

                            <li><a href="{{ url('employees') }}"><img src="{{ asset('images/lv-rule.png') }}" alt="" /> Employee Master</a></li>

                             <!-- <li><a href="{{ url('paystructure-dashboard') }}"><img src="{{ asset('images/lv-rule.png') }}" alt="" />Pay Structure</a></li>

                             <li><a href="{{ url('promotion') }}"><img src="{{ asset('images/lv-rule.png') }}" alt="" />Promotion</a></li>

                             <li><a href="{{ url('promotionreport') }}"><img src="{{ asset('images/lv-rule.png') }}" alt="" />Promotion Report</a></li>

                             <li><a href="{{ url('macp') }}"><img src="{{ asset('images/lv-rule.png') }}" alt="" />MACP</a></li>

                            <li><a href="{{ url('macpreport') }}"><img src="{{ asset('images/lv-rule.png') }}" alt="" />MACP Report</a></li>

                             <li><a href="{{ url('increment-report') }}"><img src="{{ asset('images/lv-rule.png') }}" alt="" />Increment Report</a></li>

                             <li><a href="{{ url('servicebook') }}"><img src="{{ asset('images/lv-rule.png') }}" alt="" />Service Book</a></li> -->
                        </ul>
                    </li>

                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="{{ asset('images/attendence.png') }}" alt="" /> Employee Reports</a>
                        <ul class="sub-menu children dropdown-menu">

                            <!-- <li><a href="{{ url('employees/class') }}"><img src="{{ asset('images/lv-rule.png') }}" alt="" /> Employee List Class Wise</a></li> -->
                            <li><a href="{{ url('employees/department') }}"><img src="{{ asset('images/lv-rule.png') }}" alt="" /> Employee List Department Wise</a></li>
                            <li><a href="{{ url('employees/ex-report') }}"><img src="{{ asset('images/lv-rule.png') }}" alt="" /> Ex Employee </a></li>
			            </ul>
					</li>

            <!-- <li><a href="{{ url('employee-corner/vw-classwise-employee') }}"><img src="{{ asset('images/lv-rule.png') }}" alt="" />Employee[Class Wise]</a></li> -->


                </ul>
            </div>
        </nav>
</aside>

@endif
