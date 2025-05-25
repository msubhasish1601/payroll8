  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
     
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
    

      <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown">
        <a data-toggle="tooltip" data-placement="bottom" title="My Profile" class="nav-link" href="#">
          <img src="{{ asset('img/profile.png')}}" alt="" width="29">
        </a>
       
      </li>
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-placement="bottom" title="Change Password" href="{{url('change-password')}}">
         <img src="{{ asset('img/key.png')}}" alt="" width="29">
         
        </a>
      
      </li>
      
      <li class="nav-item">
        <a class="nav-link" data-toggle="tooltip" data-placement="bottom" title="Logout" href="{{url('logout')}}">
          <img src="{{ asset('img/switch.png')}}" alt="" width="25">
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->