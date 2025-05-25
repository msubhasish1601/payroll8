<?php
$master_module='';
$payroll_menu='';
$employee='';
$report='';
//dd($Roledata);
// dd($Roledata);
?>
<style>
.navbar .navbar-nav li.menu-item-has-children .sub-menu{padding-left:0;}
.navbar .navbar-nav li > a{padding:4px 0;}
.navbar .navbar-nav li.menu-item-has-children a:before{top:16px;}
.navbar .navbar-nav li.menu-item-has-children a{}
</style>



 <aside id="left-panel" class="left-panel">
        <nav class="navbar navbar-expand-sm navbar-default">
            <div id="main-menu" class="main-menu collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li class="active">
                        <a href="{{ url('mis/dashboard') }}"><img src="{{ asset('images/dashboard-icon.png') }}" alt="" />Dashboard </a>
                    </li>

					 <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="{{ asset('images/attendence.png') }}" alt="" /> Consolidated</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li>
								<a href="{{ url('consoliated-balancesheet') }}"><img src="{{ asset('images/branch.png') }}" alt="" />Balance Sheet </a>
							</li>
							<li><a href="{{ url('receipt-payment-report') }}"><img src="{{ asset('images/lv-rule.png') }}" alt="" />Receipt Payment</a></li>
							<li>

                             <li>
								<a href="{{ url('sumary-report-income') }}"><img src="{{ asset('images/daily-att.png') }}" alt="" />Income & Expenditure Account </a>
							</li>
                        </ul>
                    </li>

					 <li>
                        <a href="{{ url('balance-sheet-report') }}"><img src="{{ asset('images/branch.png') }}" alt="" />Balance Sheet </a>
                    </li>



					 <li>
                        <a href="{{ url('income-expenditure-report') }}"><img src="{{ asset('images/income-exp.png') }}" alt="" />Income & Expenditure </a>
                    </li>

					<li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="{{ asset('images/attendence.png') }}" alt="" /> Schedules</a>
                        <ul class="sub-menu children dropdown-menu">

                           <li><a href="{{ url('income-schedules') }}"><img src="{{ asset('images/lv-rule.png') }}" alt="" />Income & Expenditure</a></li>

                           <li><a href="{{ url('bs-schedules') }}"><img src="{{ asset('images/lv-rule.png') }}" alt="" />Balance Sheet</a></li>

                        </ul>
                    </li>

					<li>
                        <a href="{{ url('establishment-receipt-payment') }}"><img src="{{ asset('images/branch.png') }}" alt="" />Receipt Payment </a>
                    </li>

					<li>
                         <a href="{{ url('cash-book-report') }}"><img src="{{ asset('images/cash-book.png') }}" alt="" />Cash Book </a>
                    </li>

					<li>
                         <a href="{{ url('petty-book-report') }}"><img src="{{ asset('images/cash-book.png') }}" alt="" />Petty Cash Book </a>
                    </li>

					<li>
                        <a href="{{ url('bankbook/report') }}"><img src="{{ asset('images/bank-book.png') }}" alt="" />Bank Book </a>
					</li>


					 <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="{{ asset('images/attendence.png') }}" alt="" /> Voucher Reoprts</a>
                        <ul class="sub-menu children dropdown-menu">

                           <li><a href="{{ url('#') }}"><img src="{{ asset('images/lv-rule.png') }}" alt="" />Journal</a></li>

                           <li><a href="{{ url('contra-voucher-report') }}"><img src="{{ asset('images/lv-rule.png') }}" alt="" />Contra</a></li>

                           <li><a href="{{ url('receipt-voucher-report') }}"><img src="{{ asset('images/lv-rule.png') }}" alt="" />Receipt</a></li>

                           <li><a href="{{ url('payment-voucher-report') }}"><img src="{{ asset('images/lv-rule.png') }}" alt="" />Payment</a></li>

                           <li><a href="{{ url('#') }}"><img src="{{ asset('images/lv-rule.png') }}" alt="" />Book Adjustment Journal</a></li>

                        </ul>
                    </li>


					<li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="{{ asset('images/attendence.png') }}" alt="" /> Ledger Report</a>
                        <ul class="sub-menu children dropdown-menu">

                           <li><a href="{{ url('party-ledger-report') }}"><img src="{{ asset('images/lv-rule.png') }}" alt="" />Party Ledger</a></li>

                           <li><a href="{{ url('glhead/report') }}"><img src="{{ asset('images/lv-rule.png') }}" alt="" />General Ledger</a></li>

                        </ul>
                    </li>


					<li>
                        <a href="{{ url('#') }}"><img src="{{ asset('images/budget.png') }}" alt="" />Budget Amount Status </a>
                    </li>



                    <li>
                        <a href="{{ url('trial-balance-report') }}"><img src="{{ asset('images/trial-balance.png') }}" alt="" />Trial Balance Report </a>
                    </li>

                    <li>
						<a href="{{ url('#') }}"><img src="{{ asset('images/branch.png') }}" alt="" />Cash Flow </a>
                    </li>


					 <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="{{ asset('images/attendence.png') }}" alt="" /> Fixed Asset Reoprts</a>
                        <ul class="sub-menu children dropdown-menu">

                           <li><a href="{{ url('#') }}"><img src="{{ asset('images/lv-rule.png') }}" alt="" />Fixed Asset Reoprts</a></li>

                           <li><a href="{{ url('#') }}"><img src="{{ asset('images/lv-rule.png') }}" alt="" />Additional Fixed Assets during the year</a></li>

                           <li><a href="{{ url('#') }}"><img src="{{ asset('images/lv-rule.png') }}" alt="" />Written Off Fixed Assets during the year</a></li>

                           <li><a href="{{ url('#') }}"><img src="{{ asset('images/lv-rule.png') }}" alt="" />Fixed Asset written down value</a></li>

                        </ul>
                    </li>

                    <li>
                        <a href="{{ url('#') }}"><img src="{{ asset('images/trial-balance.png') }}" alt="" />Fund wise Trial Balance </a>
                    </li>

                    <li>
                        <a href="{{ url('#') }}"><img src="{{ asset('images/daily-att.png') }}" alt="" />Fund Payment and Receipt </a>
                    </li>

                </ul>
            </div>
        </nav>
</aside>

