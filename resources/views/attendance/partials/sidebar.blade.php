<!-- Left Panel -->
@if(Session('admin')->user_type=='user')
<aside id="left-panel" class="left-panel">
    <nav class="navbar navbar-expand-sm navbar-default">
        <div id="main-menu" class="main-menu collapse navbar-collapse">

            <?php $menus = array();
foreach ($Roledata as $roleaccess) {
    $menus[] = $roleaccess->menu;

}
$menuslist = array_unique($menus);
//dd($menuslist);
?>



            <ul class="nav navbar-nav">
                <li class="active"> <a href="{{ url('attendance/dashboard') }}"><img
                            src="{{ asset('images/dashboard-icon.png') }}" alt="" />Dashboard </a> </li>

                            <?php if (in_array("2", $menuslist) || in_array("8", $menuslist) || in_array("9", $menuslist)) {?>
                <li class="menu-item-has-children dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false"> <img src="{{ asset('images/attendence.png') }}"
                            alt="" /> Attendance Management</a>
                    <ul class="sub-menu children dropdown-menu">
                        <?php if (in_array("2", $menuslist)) {?>
                        <!-- <li><a href="{{ url('attendance/upload-data') }}"><img src="{{ asset('images/upload.png') }}" alt="" />Upload</a></li> -->
                        <li><a href="{{ url('attendance/add-montly-attendance-data-all') }}"><img
                                    src="{{ asset('images/daily-att.png') }}" alt="" />Generate Attendance</a></li>
                        <?php }?>
                        <?php if (in_array("8", $menuslist)) {?>
                        <!-- <li><a href="{{ url('attendance/daily-attendance') }}"><img src="{{ asset('images/daily-att.png') }}" alt="" />Daily Attendance Sheet</a></li> -->
                        <?php }?>
                        <?php if (in_array("9", $menuslist)) {?>
                        <!-- <li><a href="{{ url('attendance/process-attendance') }}"><img src="{{ asset('images/daily-att.png') }}" alt="" />Process Attendance</a></li> -->
                        <li><a href="{{ url('attendance/view-montly-attendance-data-all') }}"><img
                                    src="{{ asset('images/daily-att.png') }}" alt="" />Process Attendance</a></li>
                        <?php }?>
                    </ul>
                </li>
                <?php }?>
                <?php if (in_array("35", $menuslist)) {?>
                <li class="menu-item-has-children dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false"> <img src="{{ asset('images/reports.png') }}" alt="" /> Report Module</a>
                    <ul class="sub-menu children dropdown-menu">
                    <?php if (in_array("35", $menuslist)) {?>
                        <li><a href="{{ url('attendance/daily-attendance-report') }}"><img
                                    src="{{ asset('images/payroll.png') }}" alt="" /> Daily Attandance</a></li>
                                    <?php }?>
                    </ul>
                </li>
                <?php }?>

            </ul>
        </div>

    </nav>
</aside>
@else
<!-- /#left-panel -->


<aside id="left-panel" class="left-panel">
    <nav class="navbar navbar-expand-sm navbar-default">
        <div id="main-menu" class="main-menu collapse navbar-collapse">



            <ul class="nav navbar-nav">
                <li class="active"> <a href="{{ url('attendance/dashboard') }}"><img
                            src="{{ asset('images/dashboard-icon.png') }}" alt="" />Dashboard </a> </li>
                <!-- <li class="menu-item-has-children dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">  <img src="{{ asset('images/attendence.png') }}" alt="" /> Attendance Management</a>
          <ul class="sub-menu children dropdown-menu"> -->
                <!-- <li><a href="{{ url('attendance/upload-data') }}"><img src="{{ asset('images/upload.png') }}" alt="" />Upload</a></li> -->
                <!-- <li><a href="{{ url('attendance/daily-attendance') }}"><img src="{{ asset('images/daily-att.png') }}" alt="" />Daily Attendance Sheet</a></li> -->
                <!--<li><a href="{{ url('attendance/monthly-attendance') }}"><img src="{{ asset('images/daily-att.png') }}" alt="" />Monthy Attendance</a></li> -->
                <!-- <li><a href="{{ url('attendance/add-montly-attendance-data-all') }}"><img src="{{ asset('images/daily-att.png') }}" alt="" />Generate Attendance</a></li> -->
                <!-- <li><a href="{{ url('attendance/process-attendance') }}"><img src="{{ asset('images/daily-att.png') }}" alt="" />Process Attendance</a></li> -->
                <!-- <li><a href="{{ url('attendance/view-montly-attendance-data-all') }}"><img src="{{ asset('images/daily-att.png') }}" alt="" />Process Attendance</a></li> -->
                <!-- </ul>
        </li> -->
                <li class="menu-item-has-children dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false"> <img src="{{ asset('images/reports.png') }}" alt="" /> Report Module</a>
                    <ul class="sub-menu children dropdown-menu">
                        <!-- <li><a href="{{ url('attendance/report-monthly-attendance') }}"><img src="{{ asset('images/payroll.png') }}" alt="" /> View Attandance</a></li> -->
                        <li><a href="{{ url('attendance/daily-attendance-report') }}"><img
                                    src="{{ asset('images/payroll.png') }}" alt="" /> Daily Attandance</a></li>
                    </ul>
                </li>

            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </nav>
</aside>
@endif