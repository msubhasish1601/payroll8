<!-- Left Panel -->
<aside id="left-panel" class="left-panel">
    <nav class="navbar navbar-expand-sm navbar-default">
        <div id="main-menu" class="main-menu collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li class="active">
                    <a href="{{ url('role/dashboard') }}"><img src="{{ asset('images/dashboard-icon.png') }}" alt="" />Dashboard </a>
                </li>
                <!--<li class="menu-title">UI elements</li>-->
                <!-- /.menu-title -->
                <li class="menu-item-has-children dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <img src="{{ asset('images/module.png') }}" alt="" /> Time Shift Management</a>
                    <ul class="sub-menu children dropdown-menu">
                        <li><a href="{{ url('rota/shift-management') }}"><img src="{{ asset('images/hand.png') }}" alt="" /> Shift Management</a></li>
                        <li><a href="{{ url('rota/late-policy') }}"><img src="{{ asset('images/hand.png') }}" alt="" /> Late Policy</a></li>
                        <li><a href="{{ url('rota/offday') }}"><img src="{{ asset('images/hand.png') }}" alt="" /> Day Off</a></li>
                        <li><a href="{{ url('rota/grace-period') }}"><img src="{{ asset('images/hand.png') }}" alt="" /> Grace Period</a></li>
                        <li><a href="{{ url('rota/duty-roster') }}"><img src="{{ asset('images/hand.png') }}" alt="" /> Duty Roster</a></li>
                    </ul>
                </li>



            </ul>
        </div><!-- /.navbar-collapse -->
    </nav>
</aside>
<!-- /#left-panel -->