@if(Session('admin')->user_type=='user')
      <aside id="left-panel" class="left-panel">
        <nav class="navbar navbar-expand-sm navbar-default">
            <div id="main-menu" class="main-menu collapse navbar-collapse">

                 <?php $menus = array();
                        foreach($Roledata as $roleaccess){
                            $menus[]= $roleaccess->menu; 
                                    
                            }  
                        $menuslist= array_unique($menus); ?>
                <?php if(in_array("11", $menuslist)) {?>   
                <ul class="nav navbar-nav">
                    <li class="active">
                        <a href="dashboard"><img src="{{ asset('images/dashboard-icon.png') }}" alt="" />Dashboard </a>
                    </li>
                     <li class="">
                        <a href="{{url('leave-approver/leave-approved')}}"><img src="{{ asset('images/dashboard-icon.png') }}" alt="" />Approver Corner</a>
                    </li>
                 
                </ul>
                <?php } ?>  
            </div><!-- /.navbar-collapse -->
        </nav>
    </aside>
  @else 


<aside id="left-panel" class="left-panel">
        <nav class="navbar navbar-expand-sm navbar-default">
            <div id="main-menu" class="main-menu collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li class="active">
                        <a href="dashboard"><img src="{{ asset('images/dashboard-icon.png') }}" alt="" />Dashboard </a>
                    </li>
                     <li class="">
                        <a href="{{url('leave-approver/leave-approved')}}"><img src="{{ asset('images/dashboard-icon.png') }}" alt="" />Leave & Tour Approver </a>
                    </li>
                    <!--<li class="menu-title">UI elements</li>--><!-- /.menu-title -->
                
                    
                    
                </ul>
            </div><!-- /.navbar-collapse -->
        </nav>
    </aside>

@endif 

	