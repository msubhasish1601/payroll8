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
                    <a href="{{ url('payroll/dashboard') }}"><img src="{{ asset('images/dashboard-icon.png') }}"
                            alt="" />Dashboard </a>
                </li>

                <?php $menus = array();
foreach ($Roledata as $roleaccess) {
    $menus[] = $roleaccess->menu;
}
$menuslist = array_unique($menus);?>

                <li class="menu-item-has-children dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false"><img src="{{ asset('images/attendence.png') }}" alt="" /> Payroll
                        Master</a>
                    <ul class="sub-menu children dropdown-menu">

                        <?php if (in_array("12", $menuslist)) {?>
                        <!-- <li><a href="{{ url('payroll/vw-montly-coop') }}"><img src="{{ asset('images/lv-rule.png') }}"
                                    alt="" /> Generate Monthly Co.Op</a></li> -->
                        <?php }?>
                        <?php if (in_array("12", $menuslist)) {?>
                        <!-- <li><a href="{{ url('payroll/vw-montly-itax') }}"><img src="{{ asset('images/lv-rule.png') }}"
                                    alt="" /> Generate Monthly Income Tax</a></li> -->
                        <?php }?>
                        <?php if (in_array("12", $menuslist)) {?>
                        <!-- <li><a href="{{ url('payroll/vw-montly-allowances') }}"><img
                                    src="{{ asset('images/lv-rule.png') }}" alt="" /> Generate Monthly Allowances</a>
                        </li> -->
                        <?php }?>
                        <?php if (in_array("12", $menuslist)) {?>
                        <!-- <li><a href="{{ url('payroll/vw-montly-overtime') }}"><img
                                    src="{{ asset('images/lv-rule.png') }}" alt="" /> Generate Monthly Overtimes</a>
                        </li> -->
                        <?php }?>
                        <?php if (in_array("12", $menuslist)) {?>
                        <li><a href="{{ url('payroll/vw-payroll-generation') }}"><img
                                    src="{{ asset('images/lv-rule.png') }}" alt="" /> Payroll Generation</a></li>
                        <?php }?>
                        <?php if (in_array("13", $menuslist)) {?>
                        <li><a href="{{ url('payroll/vw-payroll-generation-all-employee') }}"><img
                                    src="{{ asset('images/lv-rule.png') }}" alt="" /> Generate All Employee Payroll</a>
                        </li>
                        <?php }?>
                        <?php if (in_array("22", $menuslist)) {?>
                        <li><a href="{{ url('payroll/vw-process-payroll') }}"><img
                                    src="{{ asset('images/lv-rule.png') }}" alt="" /> Process Employee Payroll</a></li>

                        <?php }?>
                        <!--
                            <?php if (in_array("23", $menuslist)) {?>
                            <li><a href="{{ url('payroll/arear-dashboard') }}"><img src="{{ asset('images/lv-rule.png') }}" alt="" /> Arrear Bill</a></li>
                            <?php }?>
                            <?php if (in_array("24", $menuslist)) {?>
                            <li><a href="{{ url('payroll/arear-calculation-dashboard') }}"><img src="{{ asset('images/lv-rule.png') }}" alt="" /> Arrear Calculation</a></li>
                            <?php }?>
							-->
                    </ul>
                </li>



                <li class="menu-item-has-children dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false"> <img src="{{ asset('images/reports.png') }}" alt="" /> Report Module</a>
                    <ul class="sub-menu children dropdown-menu">
                        <?php if (in_array("14", $menuslist)) {?>
                        <li><a href="{{ url('payroll/vw-employeewise-view-payslip') }}"><img
                                    src="{{ asset('images/payroll.png') }}" alt="" /> Employee wise Pay Slip</a></li>
                        <?php }?>
                        <?php if (in_array("14", $menuslist)) {?>
                        <li><a href="{{ url('payroll/vw-all-payslips') }}"><img src="{{ asset('images/payroll.png') }}"
                                    alt="" /> All Employee Pay Slips</a></li>
                        <?php }?>
                        <?php if (in_array("15", $menuslist)) {?>
                        <li><a href="{{ url('payroll/vw-salary-register') }}"><img
                                    src="{{ asset('images/salary.png') }}" alt="" /> Monthly Salary Register</a></li>
                        <?php }?>
                        <?php if (in_array("25", $menuslist)) {?>
                        <li><a href="{{ url('payroll/vw-bank-statement') }}"><img src="{{ asset('images/salary.png') }}"
                                    alt="" /> Bank Statement</a></li>
                        <?php }?>
                        <?php if (in_array("16", $menuslist)) {?>
                        <li><a href="{{ url('payroll/salary-statement') }}"><img src="{{ asset('images/salary.png') }}"
                                    alt="" /> Salary Statement</a></li>
                        <?php }?>
                        <?php if (in_array("17", $menuslist)) {?>
                        <li><a href="{{ url('payroll/vw-p-tax-department-wise') }}"><img
                                    src="{{ asset('images/salary.png') }}" alt="" /> Professional Tax</a></li>
                        <?php }?>
                        <?php if (in_array("18", $menuslist)) {?>
                        <!-- <li><a href="{{ url('payroll/vw-gpf-wise') }}"><img src="{{ asset('images/salary.png') }}"
                                    alt="" /> GPF Statement</a></li> -->
                        <?php }?>
                        <?php if (in_array("27", $menuslist)) {?>
                        <!-- <li><a href="{{ url('payroll/vw-gpf-emplyeewise') }}"><img
                                    src="{{ asset('images/salary.png') }}" alt="" /> GPF Statement[Employee Wise]</a>
                        </li> -->
                        <?php }?>
                        <!--
                        <?php if (in_array("28", $menuslist)) {?>
                            <li><a href="{{ url('payroll/vw-nps-all') }}"><img src="{{ asset('images/salary.png') }}" alt="" /> NPS Statement</a></li>
                        <?php }?>
                        <?php if (in_array("29", $menuslist)) {?>
                            <li><a href="{{ url('payroll/vw-nps-emplyeewise') }}"><img src="{{ asset('images/salary.png') }}" alt="" /> NPS Statement[Employee Wise]</a></li>
                        <?php }?> -->
                        <?php if (in_array("30", $menuslist)) {?>
                        <li><a href="{{ url('payroll/vw-incomtax-all') }}"><img src="{{ asset('images/salary.png') }}"
                                    alt="" /> Income Tax</a></li>
                        <?php }?>
                        <?php if (in_array("31", $menuslist)) {?>
                        <li><a href="{{ url('payroll/vw-incometax-emplyeewise') }}"><img
                                    src="{{ asset('images/salary.png') }}" alt="" /> Income Tax[Employee Wise]</a></li>
                        <?php }?>
                        <!--
                        <?php if (in_array("32", $menuslist)) {?>
                            <li><a href="{{ url('payroll/vw-glsi-all') }}"><img src="{{ asset('images/salary.png') }}" alt="" /> GSLI </a></li>
                        <?php }?>
                        <?php if (in_array("33", $menuslist)) {?>
                            <li><a href="{{ url('payroll/vw-glsi-emplyeewise') }}"><img src="{{ asset('images/salary.png') }}" alt="" /> GSLI[Employee Wise]</a></li>
                        <?php }?>
                        <?php if (in_array("34", $menuslist)) {?>
                            <li><a href="{{ url('payroll/view-arrear-details') }}" target="_blank"><img src="{{ asset('images/salary.png') }}" alt="" /> Arrear</a></li>
                        <?php }?> -->


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
                    <a href="{{ url('payroll/dashboard') }}"><img src="{{ asset('images/dashboard-icon.png') }}"
                            alt="" />Dashboard </a>
                </li>

                <li class="menu-item-has-children dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false"><img src="{{ asset('images/attendence.png') }}" alt="" /> Payroll
                        Master</a>
                    <ul class="sub-menu children dropdown-menu">

                        <!-- <li><a href="{{ url('payroll/vw-montly-coop') }}"><img src="{{ asset('images/lv-rule.png') }}"
                                    alt="" /> Generate Monthly Co.Op</a></li> -->
                        <!-- <li><a href="{{ url('payroll/vw-montly-itax') }}"><img src="{{ asset('images/lv-rule.png') }}"
                                    alt="" /> Generate Monthly Income Tax</a></li> -->
                        <!-- <li><a href="{{ url('payroll/vw-montly-allowances') }}"><img
                                    src="{{ asset('images/lv-rule.png') }}" alt="" /> Generate Monthly Allowances</a>
                        </li> -->
                        <!-- <li><a href="{{ url('payroll/vw-montly-overtime') }}"><img
                                    src="{{ asset('images/lv-rule.png') }}" alt="" /> Generate Monthly Overtimes</a>
                        </li> -->
                        <li><a href="{{ url('payroll/vw-payroll-generation') }}"><img
                                    src="{{ asset('images/lv-rule.png') }}" alt="" /> Payroll Generation</a></li>
                        <li><a href="{{ url('payroll/vw-payroll-generation-all-employee') }}"><img
                                    src="{{ asset('images/lv-rule.png') }}" alt="" /> Generate All Employee Payroll</a>
                        </li>
                        <li><a href="{{ url('payroll/vw-process-payroll') }}"><img
                                    src="{{ asset('images/lv-rule.png') }}" alt="" /> Process Employee Payroll</a></li>
                        <!-- <li><a href="{{ url('payroll/pf-opening-balance') }}"><img
                                    src="{{ asset('images/lv-rule.png') }}" alt="" />Opening Balance For PF</a></li> -->
                        <!-- <li><a href="{{ url('payroll/vw-payroll-generation') }}"><img src="{{ asset('images/lv-rule.png') }}" alt="" /> Payroll Generation</a></li> -->
                        <!-- <li><a href="{{ url('payroll/opening-bal-generation') }}"><img src="{{ asset('images/lv-rule.png') }}" alt="" />Opening Balance For PF</a></li> -->

                        <!--<li><a href="{{ url('payroll/arear-dashboard') }}"><img src="{{ asset('images/lv-rule.png') }}" alt="" /> Arrear Bill</a></li>
                            <li><a href="{{ url('payroll/vw-payroll-generation-for-arrear') }}"><img src="{{ asset('images/lv-rule.png') }}" alt="" /> Arrear Payroll Single</a></li>
                            <li><a href="{{ url('payroll/vw-payroll-generation-all-employee-for-arrear') }}"><img src="{{ asset('images/lv-rule.png') }}" alt="" /> Arrear Payroll All</a></li>

                            <li><a href="{{ url('payroll/arear-calculation-dashboard') }}"><img src="{{ asset('images/lv-rule.png') }}" alt="" /> Arrear Calculation</a></li>-->
                        <!-- <li><a href="{{ url('payroll/vw-adjustment-payroll-generation') }}"><img
                                    src="{{ asset('images/lv-rule.png') }}" alt="" /> Adjustment Payroll Generation</a>
                        </li> -->
                        <!-- <li><a href="{{ url('payroll/vw-voucher-payroll-generation') }}"><img
                                    src="{{ asset('images/lv-rule.png') }}" alt="" /> Voucher Payroll Generation</a>
                        </li> -->
                        <!-- <li><a href="{{ url('payroll/vw-yearly-bonus') }}"><img src="{{ asset('images/lv-rule.png') }}"
                                    alt="" /> Bonus Generation</a></li> -->
                        <!-- <li><a href="{{ url('payroll/vw-yearly-encashment') }}"><img
                                    src="{{ asset('images/lv-rule.png') }}" alt="" /> Yearly Encashments</a></li> -->
                    </ul>
                </li>

                <li class="menu-item-has-children dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false"> <img src="{{ asset('images/reports.png') }}" alt="" /> Report Module</a>
                    <ul class="sub-menu children dropdown-menu">
                        <li><a href="{{ url('payroll/paycard') }}"><img src="{{ asset('images/payroll.png') }}"
                                    alt="" /> Employee Pay Card</a></li>
                        <li><a href="{{ url('payroll/vw-employeewise-view-payslip') }}"><img
                                    src="{{ asset('images/payroll.png') }}" alt="" /> Employeewise Pay Slip</a></li>
                        <li><a href="{{ url('payroll/vw-all-payslips') }}"><img src="{{ asset('images/payroll.png') }}"
                                    alt="" /> All Employee Pay Slips</a></li>
                        <li><a href="{{ url('payroll/vw-salary-register') }}"><img
                                    src="{{ asset('images/salary.png') }}" alt="" /> Monthly Salary Register</a></li>
                        <li><a href="{{ url('payroll/vw-bank-statement') }}"><img src="{{ asset('images/salary.png') }}"
                                    alt="" /> Bank Statement</a></li>
                        <li><a href="{{ url('payroll/salary-statement') }}"><img src="{{ asset('images/salary.png') }}"
                                    alt="" /> Salary Statement</a></li>
                        <li><a href="{{ url('payroll/vw-p-tax-department-wise') }}"><img
                                    src="{{ asset('images/salary.png') }}" alt="" /> Professional Tax</a></li>

                        <!-- <li><a href="{{ url('payroll/vw-gpf-wise') }}"><img src="{{ asset('images/salary.png') }}"
                                    alt="" /> PF Statement</a></li> -->

                        <!-- <li><a href="{{ url('payroll/vw-gpf-emplyeewise') }}"><img
                                    src="{{ asset('images/salary.png') }}" alt="" /> PF Statement [Employee Wise]</a>
                        </li> -->

                        <!--  <li><a href="{{ url('payroll/vw-nps-all') }}"><img src="{{ asset('images/salary.png') }}" alt="" /> NPS Statement</a></li>

                            <li><a href="{{ url('payroll/vw-nps-emplyeewise') }}"><img src="{{ asset('images/salary.png') }}" alt="" /> NPS Statement[Employee Wise]</a></li>-->
                        <li><a href="{{ url('payroll/vw-incomtax-all') }}"><img src="{{ asset('images/salary.png') }}"
                                    alt="" /> Income Tax</a></li>

                        <li><a href="{{ url('payroll/vw-incometax-emplyeewise') }}"><img
                                    src="{{ asset('images/salary.png') }}" alt="" /> Income Tax [Employee Wise]</a></li>

                        <li><a href="{{ url('payroll/vw-department-summary') }}"><img
                                    src="{{ asset('images/salary.png') }}" alt="" /> Department Summary</a></li>
                        <!-- <li><a href="{{ url('payroll/vw-deducted-coop-report') }}"><img
                                    src="{{ asset('images/salary.png') }}" alt="" /> Deducted Cooperative</a></li> -->
                        <!-- <li><a href="{{ url('payroll/vw-non-deducted-coop-report') }}"><img
                                    src="{{ asset('images/salary.png') }}" alt="" /> Non Deducted Cooperative</a></li> -->
                        <!-- <li><a href="{{ url('payroll/vw-misc-recovery-report') }}"><img
                                    src="{{ asset('images/salary.png') }}" alt="" /> Miscellaneous Recovery</a></li> -->
                        <!-- <li><a href="{{ url('payroll/monthly-coop-entry-report') }}"><img
                                    src="{{ asset('images/salary.png') }}" alt="" /> Monthly Co.Op. Ded. Entry</a></li> -->
                        <!-- <li><a href="{{ url('payroll/monthly-incometax-entry-report') }}"><img
                                    src="{{ asset('images/salary.png') }}" alt="" /> Monthly Income Tax Ded. Entry</a>
                        </li> -->
                        <!-- <li><a href="{{ url('payroll/monthly-allowance-entry-report') }}"><img
                                    src="{{ asset('images/salary.png') }}" alt="" /> Monthly Allowance Ded. Entry</a>
                        </li> -->
                        <!-- <li><a href="{{ url('payroll/monthly-overtime-entry-report') }}"><img
                                    src="{{ asset('images/salary.png') }}" alt="" /> Monthly Overtime Ded. Entry</a>
                        </li> -->

                        <!-- <li><a href="{{ url('payroll/yearly-bonus-entry-report') }}"><img
                                    src="{{ asset('images/salary.png') }}" alt="" /> Yearly Bonus Entry</a></li> -->
                        <!-- <li><a href="{{ url('payroll/yearly-encashment-entry-report') }}"><img
                                    src="{{ asset('images/salary.png') }}" alt="" /> Yearly Encashment Entry</a></li> -->

                        <!-- <li><a href="{{ url('payroll/yearly-bonus-report') }}"><img
                                    src="{{ asset('images/salary.png') }}" alt="" /> Yearly Bonus Report</a></li> -->
                        <!-- <li><a href="{{ url('payroll/yearly-bonus-only-report') }}"><img
                                    src="{{ asset('images/salary.png') }}" alt="" /> Yearly Bonus Only Report</a></li> -->
                        <!-- <li><a href="{{ url('payroll/yearly-exgratia-report') }}"><img
                                    src="{{ asset('images/salary.png') }}" alt="" /> Yearly Exgratia Report</a></li> -->

                        <!--  <li><a href="{{ url('payroll/vw-glsi-all') }}"><img src="{{ asset('images/salary.png') }}" alt="" /> GSLI </a></li>

                             <li><a href="{{ url('payroll/vw-glsi-emplyeewise') }}"><img src="{{ asset('images/salary.png') }}" alt="" /> GSLI[Employee Wise]</a></li>

                             <li><a href="{{ url('payroll/view-arrear-details') }}" target="_blank"><img src="{{ asset('images/salary.png') }}" alt="" /> Arrear </a></li>

							 <li><a href="{{ url('payroll/view-arrear-statement') }}" target="_blank"><img src="{{ asset('images/salary.png') }}" alt="" /> Arrear Statement </a></li>

                            <li><a href="{{ url('payroll/vw-p-tax-employee-wise') }}"><img src="{{ asset('images/salary.png') }}" alt="" /> P-TAX Employee Wise</a></li>-->


                    </ul>
                </li>
                <li></li>
            </ul>
        </div>
    </nav>
</aside>
@endif