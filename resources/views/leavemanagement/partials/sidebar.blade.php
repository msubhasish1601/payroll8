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
                    <a href="{{ url('leavemanagement/dashboard') }}"><img src="{{ asset('images/dashboard-icon.png') }}"
                            alt="" />Dashboard </a>
                </li>

                <?php $menus = array();
foreach ($Roledata as $roleaccess) {
    $menus[] = $roleaccess->menu;

}
$menuslist = array_unique($menus);?>

                <li class="menu-item-has-children dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false"><img src="{{ asset('images/attendence.png') }}" alt="" /> Leave
                        Management</a>

                    <ul class="sub-menu children dropdown-menu">
                        <?php if (in_array("7", $menuslist)) {?>
                        <li> <a href="{{ url('leave-management/leave-type-listing') }}"><img
                                    src="{{ asset('images/mng-leave.png') }}" alt="" /> Manage Leave Type</a></li>
                        <?php }?>
                        <?php if (in_array("4", $menuslist)) {?>
                        <li><a href="{{ url('leave-management/leave-rule-listing') }}"><img
                                    src="{{ asset('images/lv-rule.png') }}" alt="" /> Leave Rule</a></li>
                        <?php }?>
                        <?php if (in_array("5", $menuslist)) {?>
                        <li> <a href="{{ url('leave-management/leave-allocation-listing') }}"><img
                                    src="{{ asset('images/lv-allo.png') }}" alt="" />Leave Allocation</a></li>
                        <?php }?>
                        <?php if (in_array("6", $menuslist)) {?>
                        <li><a href="{{ url('leave-management/leave-balance') }}"> <img
                                    src="{{ asset('images/lv-blnc.png') }}" alt="" />Leave Balance</a></li>
                        <?php }?>
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
                    <a href="{{ url('leavemanagement/dashboard') }}"><img src="{{ asset('images/dashboard-icon.png') }}"
                            alt="" />Dashboard </a>
                </li>


                <li class="menu-item-has-children dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false"><img src="{{ asset('images/attendence.png') }}" alt="" /> Leave
                        Management</a>

                    <ul class="sub-menu children dropdown-menu">

                        <li> <a href="{{ url('leave-management/leave-type-listing') }}"><img
                                    src="{{ asset('images/mng-leave.png') }}" alt="" /> Manage Leave Type</a></li>


                        <li><a href="{{ url('leave-management/leave-rule-listing') }}"><img
                                    src="{{ asset('images/lv-rule.png') }}" alt="" /> Leave Rule</a></li>


                        <li> <a href="{{ url('leave-management/leave-allocation-listing') }}"><img
                                    src="{{ asset('images/lv-allo.png') }}" alt="" />Leave Allocation</a></li>


                        <li><a href="{{ url('leave-management/leave-balance') }}"> <img
                                    src="{{ asset('images/lv-blnc.png') }}" alt="" />Leave Balance</a></li>

                        <li><a href="{{ url('leave-management/leave-balance-view') }}"> <img
                                    src="{{ asset('images/lv-blnc.png') }}" alt="" />Leave Report</a></li>

                    </ul>


                </li>




            </ul>
        </div>
    </nav>
</aside>
@endif