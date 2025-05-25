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
@else
<aside id="left-panel" class="left-panel">
    <nav class="navbar navbar-expand-sm navbar-default">
        <div id="main-menu" class="main-menu collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li class="active">
                    <a href="{{ url('masters/dashboard') }}"><img src="{{ asset('images/dashboard-icon.png') }}"
                            alt="" />Dashboard </a>
                </li>

                <!--   <li class="menu-item-has-children dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <img src="{{ asset('images/module.png') }}" alt="" />Acoount Master </a>

                    <ul class="{{ request()->is('masters/vw-sub-cast') ? 'sub-menu children dropdown-menu show' : 'sub-menu children dropdown-menu' }}">
                        <li><a href="{{ url('masters/opening-bal-generation') }}">
                                <img src="{{ asset('images/lv-rule.png') }}" alt="" style="margin-top:10px;"> Account Opening Balance</a></li>

                        <li><a href="{{ url('masters/coas') }}"><img src="{{ asset('images/lv-rule.png') }}" alt="" />Chart Of Account</a></li>
                        <li><a href="{{ url('masters/accountmasters') }}"><img src="{{ asset('images/lv-rule.png') }}" alt="" /> Master Of Account</a></li>
                        <li><a href="{{ url('masters/tdslisting') }}"><img src="{{ asset('images/lv-rule.png') }}" alt="" />TDS Master</a></li>

                    </ul>
                </li>-->
                <li><a href="{{ url('masters/vw-company') }}"><img src="{{ asset('images/company.png') }}" alt="" />
                        Company</a></li>
                <li><a href="{{ url('change-password') }}"><img src="{{ asset('images/security.png') }}" alt="" />
                        Change Password</a></li>
                <li class="menu-item-has-children dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false"> <img src="{{ asset('images/module.png') }}" alt="" />Bank Master </a>

                    <ul
                        class="{{ request()->is('masters/vw-sub-cast') ? 'sub-menu children dropdown-menu show' : 'sub-menu children dropdown-menu' }}">
                        <li><a href="{{ url('masters/company_banklisting') }}"><img
                                    src="{{ asset('images/lv-rule.png') }}" alt="" />Company Bank</a></li>
                        <li><a href="{{ url('masters/vw-bank') }}"><img src="{{ asset('images/bank.png') }}" alt=""
                                    style="margin-top:7px"> Employee Bank</a></li>

                        <!-- <li><a href="{{ url('masters/gpf_banklisting') }}"><img src="{{ asset('images/lv-rule.png') }}" alt="" />GPF Bank</a></li>
                          <li><a href="{{ url('masters/vw-stipend-bank') }}"><img src="{{ asset('images/bank.png') }}" alt="" style="margin-top:7px">Stipend Bank</a></li>
                        -->
                    </ul>
                </li>

                <!--
                <li>
                    <a href="{{ url('depreciation/rate') }}"><img src="{{ asset('images/module.png') }}" alt="" />Depreciation Rate</a>
                </li>-->
                <li class="menu-item-has-children dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false"> <img src="{{ asset('images/module.png') }}" alt="" />HCM Master </a>

                    <ul
                        class="{{ request()->is('masters/vw-sub-cast') ? 'sub-menu children dropdown-menu show' : 'sub-menu children dropdown-menu' }}">
                        <li><a href="{{ url('masters/vw-cast') }}"><img src="{{ asset('images/lv-rule.png') }}" alt=""
                                    style="margin-top:10px;"> Caste</a></li>
                        <li><a href="{{ url('masters/vw-department') }}"><img src="{{ asset('images/lv-rule.png') }}"
                                    alt="" style="margin-top:10px;"> Department</a></li>
                        <li><a href="{{ url('masters/vw-designation') }}"><img src="{{ asset('images/lv-rule.png') }}"
                                    alt="" style="margin-top:10px;"> Designation</a></li>
                        <li><a href="{{ url('masters/vw-employee-type') }}"><img src="{{ asset('images/lv-rule.png') }}"
                                    alt="" /> Employee Type</a></li>
                        <!-- <li><a href="{{ url('masters/vw-grade') }}"><img src="{{ asset('images/grade.png') }}" alt="" /> Pay Level</a></li> -->
                        <li><a href="{{ url('masters/vw-religion') }}"><img src="{{ asset('images/lv-rule.png') }}"
                                    alt="" style="margin-top:10px;"> Religion</a></li>
                        <li><a href="{{ url('masters/vw-sub-cast') }}"><img src="{{ asset('images/lv-rule.png') }}"
                                    alt="" style="margin-top:10px;"> Sub Caste</a></li>
                        <!-- <li>
                            <a href="{{ url('masters/cooperative-master') }}"><img src="{{ asset('images/lv-rule.png') }}" alt="" />Co-Operative Master</a>
                        </li>
                        <li>
                            <a href="{{ url('masters/hra-master') }}"><img src="{{ asset('images/module.png') }}" alt="" />HRA Master</a>
                        </li> -->
                        <li>
                            <a href="{{ url('masters/education') }}"><img src="{{ asset('images/module.png') }}"
                                    alt="" />Education Master</a>

                        </li>
                        <!-- <li>
                            <a href="{{ url('masters/group-name') }}"><img src="{{ asset('images/module.png') }}"
                                    alt="" />Class Master</a>
                        </li> -->
                    </ul>
                </li>
                <li class="menu-item-has-children dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false"> <img src="{{ asset('images/module.png') }}" alt="" />Payroll Master </a>

                    <ul
                        class="{{ request()->is('masters/vw-sub-cast') ? 'sub-menu children dropdown-menu show' : 'sub-menu children dropdown-menu' }}">
                        <!-- <li><a href="{{ url('masters/gpf-rate-listing') }}"><img src="{{ asset('images/lv-rule.png') }}" alt="" /> GPF Interest Rate</a></li> -->
                        <li><a href="{{ url('masters/pfinterest') }}"><img src="{{ asset('images/lv-rule.png') }}"
                                    alt="" /> PF Loan Interest Rate</a></li>
                        <li><a href="{{ url('masters/bonus-rate') }}"><img src="{{ asset('images/lv-rule.png') }}"
                                    alt="" /> Bonus Rate</a></li>
                        <li><a href="{{ url('masters/itax-rate') }}"><img src="{{ asset('images/lv-rule.png') }}"
                                    alt="" /> Itax Rate</a></li>
                        <li>
                            <a href="{{ url('masters/rate-master') }}"><img src="{{ asset('images/lv-rule.png') }}"
                                    alt="" /> Rate Master</a>
                        </li>
                        <li><a href="{{ url('masters/ratelist') }}"><img src="{{ asset('images/lv-rule.png') }}"
                                    alt="" /> Rate Details</a></li>

                        <!-- <li>
                            <a href="{{ url('masters/emp-pay-head') }}"><img src="{{ asset('images/lv-rule.png') }}" alt="" />Employee Pay Head Master</a>
                        </li><li>
                            <a href="{{ url('masters/emp-type-da') }}"><img src="{{ asset('images/lv-rule.png') }}" alt="" />Employee Type DA</a>
                        </li>
                        <li>
                            <a href="{{ url('masters/tax-slab') }}"><img src="{{ asset('images/lv-rule.png') }}" alt="" />PTax Slab</a>
                        </li>
                        <li>
                            <a href="{{ url('masters/emp-pay-head-link') }}"><img src="{{ asset('images/lv-rule.png') }}" alt="" />Employee Pay Head Link Master</a>
                        </li>
                        <li>
                            <a href="{{ url('masters/hr-pay-parameter') }}"><img src="{{ asset('images/lv-rule.png') }}" alt="" />HR Pay Parameter</a>
                        </li>
                        <li>
                            <a href="{{ url('masters/income-tax-type') }}"><img src="{{ asset('images/lv-rule.png') }}" alt="" />Income Tax Type Master</a>
                        </li>
                        <li>
                            <a href="{{ url('masters/saving-type') }}"><img src="{{ asset('images/lv-rule.png') }}" alt="" />Types Of Savings Master</a>
                        </li>
                        <li>
                            <a href="{{ url('masters/itax-rate-slab') }}"><img src="{{ asset('images/lv-rule.png') }}" alt="" />Income Tax Rate Slab Master</a>
                        </li>
                        <li>
                            <a href="{{ url('masters/itax-max-saving') }}"><img src="{{ asset('images/lv-rule.png') }}" alt="" />Income Tax Max Saving Master</a>
                        </li>
                        <li>
                            <a href="{{ url('masters/itax-extra-deduction') }}"><img src="{{ asset('images/lv-rule.png') }}" alt="" />Income Tax Extra Deduction</a>
                        </li>-->
                    </ul>
                </li>
                <!--
                <li class="menu-item-has-children dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <img src="{{ asset('images/module.png') }}" alt="" />Procurement Master </a>

                    <ul class="{{ request()->is('masters/vw-sub-cast') ? 'sub-menu children dropdown-menu show' : 'sub-menu children dropdown-menu' }}">

                        <li><a href="{{ url('masters/vw-category') }}"><img src="{{ asset('images/lv-rule.png') }}" alt="" style="margin-top:7px"> Category</a></li>


                        <li><a href="{{ url('masters/vw-item') }}"><img src="{{ asset('images/lv-rule.png') }}" alt="" style="margin-top:7px"> Item</a></li>
                        <li><a href="{{ url('masters/vw-sub-category') }}"><img src="{{ asset('images/lv-rule.png') }}" alt="" style="margin-top:7px"> Sub Category</a></li>
                    </ul>
                </li>
                <li class="menu-item-has-children dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <img src="{{ asset('images/module.png') }}" alt="" />Loan Master </a>

                    <ul class="{{ request()->is('masters/vw-sub-cast') ? 'sub-menu children dropdown-menu show' : 'sub-menu children dropdown-menu' }}">

                        <li><a href="{{ url('masters/loanlisting') }}"><img src="{{ asset('images/lv-rule.png') }}" alt="" />Loan Master</a></li>
                        <li><a href="{{ url('masters/vw-loan-conf') }}"><img src="{{ asset('images/bank.png') }}" alt="" style="margin-top:7px"> Loan Configuration</a></li>


                    </ul>
                </li>-->

                <!--  <li class="menu-item-has-children dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <img src="{{ asset('images/module.png') }}" alt="" />VDA Details </a>

                    <ul class="{{ request()->is('masters/vw-sub-cast') ? 'sub-menu children dropdown-menu show' : 'sub-menu children dropdown-menu' }}">

                        <li><a href="{{ url('masters/vda-details') }}"><img src="{{ asset('images/lv-rule.png') }}" alt="" style="margin-top:7px">Add VDA Details</a></li>
                        <li><a href="{{ url('masters/search-vda-details') }}"><img src="{{ asset('images/lv-rule.png') }}" alt="" style="margin-top:7px">Search VDA Details</a></li>

                    </ul>
                </li>-->


                <!-- <li>
                    <a href="{{ url('masters/vw-designation') }}"><img src="{{ asset('images/module.png') }}" alt="" />Designation</a>
                </li>
                <li>
                    <a href="{{ url('masters/vw-department') }}"><img src="{{ asset('images/module.png') }}" alt="" />Department</a>
                </li>
                <li>
                    <a href="{{ url('masters/vw-employee-type') }}"><img src="{{ asset('images/module.png') }}" alt="" />Employee Type</a>
                </li>
                <li>
                    <a href="{{ url('masters/emp-pay-head') }}"><img src="{{ asset('images/module.png') }}" alt="" />Employee Pay Head Master</a>
                </li>
                <li>
                    <a href="{{ url('masters/emp-type-da') }}"><img src="{{ asset('images/module.png') }}" alt="" />Employee Type DA</a>
                </li>
                <li>
                    <a href="{{ url('masters/tax-slab') }}"><img src="{{ asset('images/module.png') }}" alt="" />PTax Slab</a>
                </li>
                <li>
                    <a href="{{ url('masters/cooperative-master') }}"><img src="{{ asset('images/module.png') }}" alt="" />Co-Operative Master</a>
                </li>
                <li>
                    <a href="{{ url('masters/hra-master') }}"><img src="{{ asset('images/module.png') }}" alt="" />HRA Master</a>
                </li>
                <li>
                    <a href="{{ url('masters/loanlisting') }}"><img src="{{ asset('images/module.png') }}" alt="" />Loan Type Master</a>
                </li>
                <li>
                    <a href="{{ url('masters/emp-pay-head-link') }}"><img src="{{ asset('images/module.png') }}" alt="" />Employee Pay Head Link Master</a>
                </li>
                <li>
                    <a href="{{ url('masters/company_banklisting') }}"><img src="{{ asset('images/module.png') }}" alt="" />Bank Master</a>
                </li>
                <li>
                    <a href="{{ url('masters/hr-pay-parameter') }}"><img src="{{ asset('images/module.png') }}" alt="" />HR Pay Parameter</a>
                </li>
                <li>
                    <a href="{{ url('masters/education') }}"><img src="{{ asset('images/module.png') }}" alt="" />Education Master</a>
                </li> -->




                <!-- <li class="menu-item-has-children dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <img src="{{ asset('images/module.png') }}" alt="" />Acoount Master </a>

                    <ul class="{{ request()->is('masters/vw-sub-cast') ? 'sub-menu children dropdown-menu show' : 'sub-menu children dropdown-menu' }}">
                        <li><a href="{{ url('masters/opening-bal-generation') }}">
                                <img src="{{ asset('images/lv-rule.png') }}" alt="" style="margin-top:10px;"> Account Opening Balance</a></li>

                        <li><a href="{{ url('masters/coas') }}"><img src="{{ asset('images/lv-rule.png') }}" alt="" />Chart Of Account</a></li>
                        <li><a href="{{ url('masters/accountmasters') }}"><img src="{{ asset('images/lv-rule.png') }}" alt="" /> Master Of Account</a></li>
                        <li><a href="{{ url('masters/tdslisting') }}"><img src="{{ asset('images/lv-rule.png') }}" alt="" />TDS Master</a></li>

                    </ul>
                </li>

                <li class="menu-item-has-children dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <img src="{{ asset('images/module.png') }}" alt="" />Bank Master </a>

                    <ul class="{{ request()->is('masters/vw-sub-cast') ? 'sub-menu children dropdown-menu show' : 'sub-menu children dropdown-menu' }}">
                        <li><a href="{{ url('masters/company_banklisting') }}"><img src="{{ asset('images/lv-rule.png') }}" alt="" />Company Bank</a></li>
                        <li><a href="{{ url('masters/vw-bank') }}"><img src="{{ asset('images/bank.png') }}" alt="" style="margin-top:7px"> Employee Bank</a></li>

                        <li><a href="{{ url('masters/gpf_banklisting') }}"><img src="{{ asset('images/lv-rule.png') }}" alt="" />GPF Bank</a></li>
                        <li><a href="{{ url('masters/vw-stipend-bank') }}"><img src="{{ asset('images/bank.png') }}" alt="" style="margin-top:7px">Stipend Bank</a></li>

                    </ul>
                </li>
                <li><a href="{{ url('masters/vw-company') }}"><img src="{{ asset('images/company.png') }}" alt="" /> Company</a></li>
                <li>
                    <a href="{{ url('depreciation/rate') }}"><img src="{{ asset('images/module.png') }}" alt="" />Depreciation Rate</a>
                </li>
                <li class="menu-item-has-children dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <img src="{{ asset('images/module.png') }}" alt="" />HCM Master </a>

                    <ul class="{{ request()->is('masters/vw-sub-cast') ? 'sub-menu children dropdown-menu show' : 'sub-menu children dropdown-menu' }}">
                        <li><a href="{{ url('masters/vw-cast') }}"><img src="{{ asset('images/lv-rule.png') }}" alt="" style="margin-top:10px;"> Caste</a></li>
                        <li><a href="{{ url('masters/vw-department') }}"><img src="{{ asset('images/lv-rule.png') }}" alt="" style="margin-top:10px;"> Department</a></li>
                        <li><a href="{{ url('masters/vw-designation') }}"><img src="{{ asset('images/lv-rule.png') }}" alt="" style="margin-top:10px;"> Designation</a></li>



                        <li><a href="{{ url('masters/vw-employee-type') }}"><img src="{{ asset('images/lv-rule.png') }}" alt="" /> Employee Type</a></li>



                        <li><a href="{{ url('masters/vw-grade') }}"><img src="{{ asset('images/grade.png') }}" alt="" /> Pay Level</a></li>
                        <li><a href="{{ url('masters/vw-religion') }}"><img src="{{ asset('images/lv-rule.png') }}" alt="" style="margin-top:10px;"> Religion</a></li>
                        <li><a href="{{ url('masters/vw-sub-cast') }}"><img src="{{ asset('images/lv-rule.png') }}" alt="" style="margin-top:10px;"> Sub Caste</a></li>


                    </ul>
                </li>
                <li class="menu-item-has-children dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <img src="{{ asset('images/module.png') }}" alt="" />Payroll Master </a>

                    <ul class="{{ request()->is('masters/vw-sub-cast') ? 'sub-menu children dropdown-menu show' : 'sub-menu children dropdown-menu' }}">
                        <li><a href="{{ url('masters/gpf-rate-listing') }}"><img src="{{ asset('images/lv-rule.png') }}" alt="" /> GPF Interest Rate</a></li>
                        <li><a href="{{ url('masters/ratelist') }}"><img src="{{ asset('images/lv-rule.png') }}" alt="" /> Rate Details</a></li>


                    </ul>
                </li>

                <li class="menu-item-has-children dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <img src="{{ asset('images/module.png') }}" alt="" />Procurement Master </a>

                    <ul class="{{ request()->is('masters/vw-sub-cast') ? 'sub-menu children dropdown-menu show' : 'sub-menu children dropdown-menu' }}">

                        <li><a href="{{ url('masters/vw-category') }}"><img src="{{ asset('images/lv-rule.png') }}" alt="" style="margin-top:7px"> Category</a></li>


                        <li><a href="{{ url('masters/vw-item') }}"><img src="{{ asset('images/lv-rule.png') }}" alt="" style="margin-top:7px"> Item</a></li>
                        <li><a href="{{ url('masters/vw-sub-category') }}"><img src="{{ asset('images/lv-rule.png') }}" alt="" style="margin-top:7px"> Sub Category</a></li>
                        <li><a href="{{ url('masters/vw-supplier') }}"><img src="{{ asset('images/lv-rule.png') }}" alt="" style="margin-top:7px"> Supplier</a></li>
                    </ul>
                </li>
                <li class="menu-item-has-children dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <img src="{{ asset('images/module.png') }}" alt="" />Loan Master </a>

                    <ul class="{{ request()->is('masters/vw-sub-cast') ? 'sub-menu children dropdown-menu show' : 'sub-menu children dropdown-menu' }}">






                        <li><a href="{{ url('masters/loanlisting') }}"><img src="{{ asset('images/lv-rule.png') }}" alt="" />Loan Master</a></li>
                        <li><a href="{{ url('masters/vw-loan-conf') }}"><img src="{{ asset('images/bank.png') }}" alt="" style="margin-top:7px"> Loan Configuration</a></li>


                    </ul>
                </li> -->
                <!--<li class="menu-title">UI elements</li>-->
                <!-- /.menu-title -->



                <!--
					<li><a href="{{ url('masters/institute-wise-config') }}" aria-haspopup="true" aria-expanded="false"> <img src="{{ asset('images/company.png') }}" alt="" />
					 Course Configuration</a></li>
				    <li><a href="{{ url('masters/subject-configuration') }}" aria-haspopup="true" aria-expanded="false"> <img src="{{ asset('images/designation.png') }}" alt="" /> Subject Configuration</a></li>
					-->

            </ul>
        </div><!-- /.navbar-collapse -->
    </nav>
</aside>
@endif
<!-- /#left-panel -->