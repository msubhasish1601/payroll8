
 
 <!-- Left Panel -->
    <aside id="left-panel" class="left-panel">
        <nav class="navbar navbar-expand-sm navbar-default">
            <div id="main-menu" class="main-menu collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li class="active">
                        <a href="{{ url('procurement/indent/dashboard') }}"><img src="{{ asset('images/dashboard-icon.png') }}" alt="" />Dashboard </a>
                    </li>
                    <!--<li class="menu-title">UI elements</li>--><!-- /.menu-title -->
					
					<!-- <li class="menu-item-has-children dropdown"><a href="{{ url('procurement/indent/indent-item') }}" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <img src="{{ asset('images/branch.png') }}" alt="" />Indent</a> -->
						<li><a href="{{ url('procurement/indent/indent-item') }}"><img src="{{ asset('images/branch.png') }}" alt="" /> Raise and View Indent</a></li>
					    
					    <li><a href="{{ url('procurement/indent/approve-indent-item') }}"><img src="{{ asset('images/branch.png') }}" alt="" /> Approve Indent</a></li>

					    <!-- <li><a href="{{ url('procurement/indent/view-indent-item-report') }}"><img src="{{ asset('images/branch.png') }}" alt="" /> Indent Item Report</a></li> -->
			<!-- <ul class="sub-menu children dropdown-menu">
            <li><a href="{{ url('procurement/indent/indent-component') }}"><img src="{{ asset('images/branch.png') }}" alt="" /> Indenting for Component</a></li>
			<li><a href="{{ url('procurement/indent/indent-item') }}"><img src="{{ asset('images/branch.png') }}" alt="" /> Indenting for Item</a></li>
          </ul> -->
					<!-- </li> -->
					
					
				<!-- <li class="menu-item-has-children dropdown"><a href="room-config.php" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <img src="{{ asset('images/daily-att.png') }}" alt="" />Purchase Request</a> -->
					<li><a href="{{ url('procurement/indent/requisition-item') }}"><img src="{{ asset('images/daily-att.png') }}" alt="" /> Purchase Request</a></li>
					

			<!--  <ul class="sub-menu children dropdown-menu">
            <li><a href="{{ url('procurement/indent/requisition-component') }}"><img src="{{ asset('images/daily-att.png') }}" alt="" /> For Component</a></li>
			<li><a href="{{ url('procurement/indent/requisition-item') }}"><img src="{{ asset('images/daily-att.png') }}" alt="" /> For Item</a></li>
			<!-<li><a href="#"><img src="{{ asset('images/daily-att.png') }}" alt="" /> For Item</a></li>
          </ul> --> 
					<!-- </li>	 -->
					
                </ul>
            </div><!-- /.navbar-collapse -->
        </nav>
    </aside>
    <!-- /#left-panel -->
	
	