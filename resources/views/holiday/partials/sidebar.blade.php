<?php	
$master_module='';
$payroll_menu='';
$employee='';
$report='';
//dd($Roledata);
// dd($Roledata);
foreach($Roledata as $roles) 
{
  if(Session::get('adminusernmae')==$roles->member_id)
   {
        if($roles->menu=='Master Module')
        {
             $master_module='master_module';
        }
         if($roles->menu=='payroll head')
        {
             $payroll_menu='payroll_menu';
        }
        if($roles->menu=='employee')
        {
            $employee='employee_menu';
        }
        if($roles->menu=='report')
        {
            $report='report_menu';
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
                    <a href="#"><img src="{{ asset('images/dashboard-icon.png') }}" alt="" />Dashboard </a>
                </li>
                <?php $menus = array();
                        foreach($Roledata as $roleaccess){
                            $menus[]= $roleaccess->menu; 
                                    
                            }  
                        $menuslist= array_unique($menus); ?>

                <?php if(in_array("10", $menuslist)) {?>
                <li class="menu-item-has-children dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false"><img src="{{ asset('images/attendence.png') }}" alt="" /> Holiday
                        Management</a>
                    <ul class="sub-menu children dropdown-menu">
                        <li><a href="{{ url('holiday-type') }}"> <img src="{{ asset('images/holi-list.png') }}"
                                    alt="" />Holiday Type List</a></li>
                        <li><a href="{{ url('holidays') }}"> <img src="{{ asset('images/holi-list.png') }}"
                                    alt="" />Holiday List</a></li>
                    </ul>
                </li>
                <?php } ?>
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
                    <a href="#"><img src="{{ asset('images/dashboard-icon.png') }}" alt="" />Dashboard </a>
                </li>

                <li class="menu-item-has-children dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false"><img src="{{ asset('images/attendence.png') }}" alt="" /> Holiday
                        Management</a>
                    <ul class="sub-menu children dropdown-menu">
                        <li><a href="{{ url('holiday-type') }}"> <img src="{{ asset('images/holi-list.png') }}"
                                    alt="" />Holiday Type List</a></li>
                        <li><a href="{{ url('holidays') }}"> <img src="{{ asset('images/holi-list.png') }}"
                                    alt="" />Holiday List</a></li>

                    </ul>
                </li>

            </ul>
        </div>
    </nav>
</aside>


@endif