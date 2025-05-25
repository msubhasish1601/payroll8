
 
 <!-- Left Panel -->
    <aside id="left-panel" class="left-panel">
        <nav class="navbar navbar-expand-sm navbar-default">
            <div id="main-menu" class="main-menu collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li class="active">
                        <a href="{{ url('role/dashboard') }}"><img src="{{ asset('images/dashboard-icon.png') }}" alt="" />Dashboard</a>
                    </li>
                    <!--<li class="menu-title">UI elements</li>--><!-- /.menu-title -->
                   <li class="menu-item-has-children dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <img src="{{ asset('images/module.png') }}" alt="" /> Role</a>
                        <ul class="sub-menu children dropdown-menu"> 
                        <!--<li><a href="{{ url('role/vw-module') }}"><img src="{{ asset('images/hand.png') }}" alt="" /> Module</a></li>
							<li><a href="{{ url('role/vw-sub-module') }}"><img src="{{ asset('images/hand.png') }}" alt="" /> Sub Module</a></li>                          
							<li><a href="{{ url('role/vw-module-config') }}"><img src="{{ asset('images/hand.png') }}" alt="" /> Configuration Module</a></li> -->                         
                            <li><a href="{{ url('role/vw-users') }}"><img src="{{ asset('images/hand.png') }}" alt="" /> User Configuration</a></li>                        
                            <li><a href="{{ url('role/view-users-role') }}"><img src="{{ asset('images/hand.png') }}" alt="" /> Role Management</a></li>

                        </ul>
                    </li>
					
					
					
                </ul>
            </div><!-- /.navbar-collapse -->
        </nav>
    </aside>
    <!-- /#left-panel -->
	
	