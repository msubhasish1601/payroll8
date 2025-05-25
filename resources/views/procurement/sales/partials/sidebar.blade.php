
 
 <!-- Left Panel -->
    <aside id="left-panel" class="left-panel">
        <nav class="navbar navbar-expand-sm navbar-default">
            <div id="main-menu" class="main-menu collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li class="active">
                        <a href="{{ url('procurement/sales/dashboard') }}"><img src="{{ asset('images/dashboard-icon.png') }}" alt="" />Dashboard </a>
                    </li>
                    <!--<li class="menu-title">UI elements</li>--><!-- /.menu-title -->
					
					<li><a href="{{ url('procurement/sales/billing') }}" aria-haspopup="true" aria-expanded="false"> <img src="{{ asset('images/daily-att.png') }}" alt="" />Billing</a></li>
					
					
				<li><a href="{{ url('procurement/sales/payment-recieved') }}" aria-haspopup="true" aria-expanded="false"> <img src="{{ asset('images/daily-att.png') }}" alt="" />Payment Recieved</a></li>	
					
                </ul>
            </div><!-- /.navbar-collapse -->
        </nav>
    </aside>
    <!-- /#left-panel -->
	
	