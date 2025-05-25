@include('layouts.default-login')


<body>
    <div class="page-wrapper">

        <header>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-6 col-6">
                        <img src="{{ asset('theme/images/payroll-logo.png') }}" width="83px">
                    </div>

                    <div class="col-lg-8 col-md-8 col-sm-6 col-6">
                        <ul class="head-right">
                            @if (!empty(Session::get('admin')))
                            <li>
                                <div class="element">

                                    <div class="inner-icon">
                                        <a data-toggle="tooltip" data-placement="bottom" title="Logout"
                                            href="{{url('logout')}}" style="color:#fff;"><img
                                                src="{{URL::to('')}}/theme/main/logout.png" style="width:30px;"></a>
                                    </div>


                                </div>
                            </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>

        </header>

        <div class="main-dash">
            <div class="wrapper">
                <div class="row">
                    <?php
$rolemenu = '';
$hcm = '';
$config = '';
?>

                    @if (!empty(Session::get('admin')))
                    <?php $admin = Session::get('admin');?>
                    @if($admin->user_type=='user')
                    @foreach($Roledata as $roles)
                    @if( Session::get('adminusernmae')==$roles->member_id)

                    @php
                    if ($roles->module_name == 'Role Management') {
                        $rolemenu = 'Role_Management';
                    }
                    if ($roles->module_name == 'Human Capital') {
                        $hcm = 'Human_Capital';
                    }
                    if ($roles->module_name == 'Configuration') {
                        $config = 'Configuration';
                    }

                    if ($roles->module_name == 'DAK Management') {
                        $dakm = 'DAK Management';
                    }

                    @endphp


                    @endif
                    @endforeach



                    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                        @if($rolemenu=='Role_Management')


                        <a href="{{ url('role/dashboard') }}">

                            @else
                            <a href="#">
                                @endif

                                <div class="box">
                                    <div class="dash-icon">
                                        <img src="{{ asset('theme/main/settings.png') }}" alt="">
                                    </div>
                                    <div class="dash-name">
                                        <h3>Role</h3>
                                    </div>
                                </div>
                            </a>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6 col-12">


                        <a href="{{ url('finance-dashboard') }}">



                            <div class="box sky">
                                <div class="dash-icon">
                                    <img src="{{ asset('theme/main/finance.png') }}" alt="">
                                </div>
                                <div class="dash-name">
                                    <h3>Finance & Accounts</h3>
                                </div>
                            </div>
                        </a>
                    </div>


                    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                        @if($hcm=='Human_Capital')
                        <a href="{{ url('hcm-dashboard') }}">
                            @else
                            <a href="#">
                                @endif
                                <div class="box dc">
                                    <div class="dash-icon">
                                        <img src="{{ asset('theme/main/hcm.png') }}" alt="">
                                    </div>
                                    <div class="dash-name">
                                        <h3>Human Capital</h3>
                                    </div>
                                </div>
                            </a>
                    </div>


                    <!-- <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                        <a href="{{ url('rota-dashboard') }}">
                            <div class="box green">
                                <div class="dash-icon">
                                    <img src="{{ asset('theme/main/refresh.png') }}" alt="">
                                </div>
                                <div class="dash-name">
                                    <h3>WFM</h3>
                                </div>
                            </div>
                        </a>
                    </div> -->


                    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                        @if($hcm=='Human_Capital')
                        <a href="#">
                            @else

                            <a href="#">
                                @endif
                                <div class="box blue">
                                    <div class="dash-icon">
                                        <img src="{{ asset('theme/main/settings-new.png') }}" alt="">
                                    </div>
                                    <div class="dash-name">
                                        <h3>Settings</h3>
                                    </div>
                                </div>
                            </a>
                    </div>

                    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                        <a href="{{ url('timesheets/dashboard') }}">
                            <div class="box blue">
                                <div class="dash-icon">
                                    <img src="{{ asset('theme/main/finance.png') }}" alt="">
                                </div>
                                <div class="dash-name">
                                    <h3>Projects</h3>
                                </div>
                            </div>
                        </a>
                    </div>
                    <!-- <a href="{{ url('projects/dashboard') }}"> -->

                    @elseif($admin->user_type=='admin')

                    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                        <a href="{{ url('role/dashboard') }}">
                            <div class="box">
                                <div class="dash-icon">
                                    <img src="{{ asset('theme/main/settings.png') }}" alt="">
                                </div>
                                <div class="dash-name">
                                    <h3>Role</h3>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                        <a href="{{ url('finance-dashboard') }}">
                            <div class="box sky">
                                <div class="dash-icon">
                                    <img src="{{ asset('theme/main/finance.png') }}" alt="">
                                </div>
                                <div class="dash-name">
                                    <h3>Finance & Accounts</h3>
                                </div>
                            </div>
                        </a>
                    </div>


                    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                        <a href="{{ url('hcm-dashboard') }}">
                            <div class="box dc">
                                <div class="dash-icon">
                                    <img src="{{ asset('theme/main/hcm.png') }}" alt="">
                                </div>
                                <div class="dash-name">
                                    <h3>Human Capital</h3>
                                </div>
                            </div>
                        </a>
                    </div>


                    <!-- <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                        <a href="{{ url('rota-dashboard') }}">
                            <div class="box green">
                                <div class="dash-icon">
                                    <img src="{{ asset('theme/main/refresh.png') }}" alt="">
                                </div>
                                <div class="dash-name">
                                    <h3>WFM</h3>
                                </div>
                            </div>
                        </a>
                    </div> -->


                    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                        <a href="{{ url('masters/dashboard') }}">
                            <div class="box blue">
                                <div class="dash-icon">
                                    <img src="{{ asset('theme/main/settings-new.png') }}" alt="">
                                </div>
                                <div class="dash-name">
                                    <h3>Settings</h3>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                        <a href="{{ url('projects/dashboard') }}">
                            <div class="box blue">
                                <div class="dash-icon">
                                    <img src="{{ asset('theme/main/settings-new.png') }}" alt="">
                                </div>
                                <div class="dash-name">
                                    <h3>Projects</h3>
                                </div>
                            </div>
                        </a>
                    </div>

                    @endif
                    @endif



                </div>
            </div>
        </div>

        <footer>
            <p>&copy; Copyright {{date('Y')}} {{ config('app.name', 'Laravel') }} | All Right Reserved</p>
        </footer>
        <!-- circle-progress/circle-progress.min.js -->

        <!-- Jquery JS-->
        <script src="{{ asset('vendor-main-dash/jquery-3.2.1.min.js')}}"></script>
        <!-- Bootstrap JS-->
        <script src="{{ asset('vendor-main-dash/bootstrap-4.1/popper.min.js')}}"></script>
        <script src="{{ asset('vendor-main-dash/bootstrap-4.1/bootstrap.min.js')}}"></script>
        <!-- Vendor JS       -->
        <script src="{{ asset('vendor-main-dash/slick/slick.min.js')}}">
        </script>
        <script src="{{ asset('vendor-main-dash/wow/wow.min.js')}}"></script>
        <script src="{{ asset('vendor-main-dash/animsition/animsition.min.js')}}"></script>
        <script src="{{ asset('vendor-main-dash/bootstrap-progressbar/bootstrap-progressbar.min.js')}}">
        </script>
        <script src="{{ asset('vendor-main-dash/counter-up/jquery.waypoints.min.js')}}"></script>
        <script src="{{ asset('vendor-main-dash/counter-up/jquery.counterup.min.js')}}">
        </script>
        <script src="{{ asset('vendor-main-dash/circle-progress/circle-progress.min.js')}}"></script>
        <script src="{{ asset('vendor-main-dash/perfect-scrollbar/perfect-scrollbar.js')}}"></script>
        <script src="{{ asset('vendor-main-dash/chartjs/Chart.bundle.min.js')}}"></script>
        <script src="{{ asset('vendor-main-dash/select2/select2.min.js')}}">
        </script>

        <!-- Main JS-->
        <script src="{{ asset('js-main-dash/main.js')}}"></script>
        <script>
        // function currentTime() {
        //     var date = new Date(); /* creating object of Date class */
        //     var hour = date.getHours();
        //     var min = date.getMinutes();
        //     var sec = date.getSeconds();
        //     hour = updateTime(hour);
        //     min = updateTime(min);
        //     sec = updateTime(sec);
        //     document.getElementById("clock").innerText = hour + " : " + min + " : " + sec; /* adding time to the div */
        //     var t = setTimeout(function() {
        //         currentTime()
        //     }, 1000); /* setting timer */
        // }

        // function updateTime(k) {
        //     if (k < 10) {
        //         return "0" + k;
        //     } else {
        //         return k;
        //     }
        // }

        // currentTime(); /* calling currentTime() function to initiate the process */
        </script>

        <script>
        // var dt = new Date();
        // document.getElementById("datetime").innerHTML = dt.toLocaleDateString();
        </script>

        </script>

        <!--
<script>
window.onscroll = function() {myFunction()};

var header = document.getElementById("myHeader");
var sticky = header.offsetTop;

function myFunction() {
  if (window.pageYOffset > sticky) {
    header.classList.add("sticky");
  } else {
    header.classList.remove("sticky");
  }
}
</script> -->


</body>




<!--------------------------- old html start here -------------------------------------------->

<!--
<body>
	<nav class="navbar">
		<ul>
			<li></li>
			<li>
				<a href="#">

					<img src="{{ asset('theme/images/bellevue-logo.jpeg') }}" alt="Logo"></a>
			</li>


			<li>
				<p id="time"></p>
			</li>
			@if (!empty(Session::get('admin')))
			<li>
				<div class="element">
					<big><a href="{{url('logout')}}" style="color:#fff;">Logout</a></big>
					<div class="inner-icon">
						<img src="{{URL::to('')}}/theme/main/logout.png">
					</div>
				</div>
			</li>
			@endif
		</ul>
	</nav>
	<?php
$rolemenu = '';
$hcm = '';
$config = '';
?>
	@if (!empty(Session::get('admin')))
	<?php $admin = Session::get('admin');?>
	@if($admin->user_type=='user')
	@foreach($Roledata as $roles)
	@if( Session::get('adminusernmae')==$roles->member_id)

	<?php
if ($roles->module_name == 'Role Management') {
    $rolemenu = 'Role_Management';
}
if ($roles->module_name == 'Human Capital') {
    $hcm = 'Human_Capital';
}
if ($roles->module_name == 'Configuration') {
    $config = 'Configuration';
}

if ($roles->module_name == 'DAK Management') {
    $dakm = 'DAK Management';
}

?>


	@endif
	@endforeach


	<section class="main">

		<div class="holder">

			<div class="each-section">
				<div class="ele">
					<div class="element" <?php if ($rolemenu != 'Role_Management') {
    echo 'style="background: linear-gradient(88deg, #7CC2CC 1%,#d9d9d9 53%);"';
} else {
    echo '';
}?>>
						@if($rolemenu=='Role_Management')
						<big><a href="{{ url('role/dashboard') }}">Rolet</a></big>
						@else
						<big><a href="javascript:void(0);">Role</a></big>
						@endif
						<div class="inner-icon">
							<img src="{{URL::to('')}}/theme/main/icon1.png">
						</div>
					</div>
				</div>
				<div class="ele"></div>
				<div class="ele">
					<div class="element">
						<big><a href="{{ url('finance-dashboard') }}">Finance & Accounts</a></big>
						<div class="inner-icon">
							<img src="{{URL::to('')}}/theme/main/icon2.png">
						</div>
					</div>
				</div>
			</div>



			<div class="each-section">
				<div class="ele">
					<div class="element">
						@if($hcm=='Human_Capital')
						<big><a href="{{ url('hcm-dashboard') }}">Human Capital</a></big>
						@else
						<big><a href="javascript:void(0);">Human Capital</a></big>
						@endif
						<div class="inner-icon">
							<img src="{{URL::to('')}}/theme/main/icon3.png">
						</div>
					</div>
				</div>
				<div class="ele">
					<div class="roll-over">
						<div class="logo"></div>
					</div>
				</div>
				<div class="ele">
					<div class="element">
						<big><a href="{{ url('rota-dashboard') }}">WFM</a></big>
						<div class="inner-icon">
							<img src="{{URL::to('')}}/theme/main/icon4.png">
						</div>
					</div>
				</div>
			</div>



			<div class="each-section">
				<div class="ele">
					<div class="element">
						@if($config=='Configuration')
						<big><a href="{{ url('masters/dashboard') }}">Settings</a></big>
						@else
						<big><a href="javascript:void(0);">Settings</a></big>
						@endif
						<div class="inner-icon">
							<img src="{{URL::to('')}}/theme/main/icon7.png">
						</div>
					</div>
				</div>
			</div>

		</div>
		<div style="width: 100%">

			<footer>
				<p>CopyRight © {{ config('app.name', 'Laravel') }} All Rights Reserved</p>
			</footer>

		</div>

	</section>
	@elseif($admin->user_type=='admin')
	<section class="main">

		<div class="holder">

			<div class="each-section">
				<div class="ele">
					<div class="element">
						<big><a href="{{ url('role/dashboard') }}">Role</a></big>
						<div class="inner-icon">
							<img src="{{URL::to('')}}/theme/main/icon1.png">
						</div>
					</div>
				</div>
				<div class="ele"></div>
				<div class="ele">
					<div class="element">
						<big><a href="{{ url('finance-dashboard') }}">Finance & Accounts</a></big>
						<div class="inner-icon">
							<img src="{{URL::to('')}}/theme/main/icon2.png">
						</div>
					</div>
				</div>
			</div>



			<div class="each-section">
				<div class="ele">
					<div class="element">
						<big><a href="{{ url('hcm-dashboard') }}">Human Capital</a></big>
						<div class="inner-icon">
							<img src="{{URL::to('')}}/theme/main/icon3.png">
						</div>
					</div>
				</div>
				<div class="ele">
					<div class="roll-over">
						<div class="logo"></div>
					</div>
				</div>
				<div class="ele">
					<div class="element">
						<big><a href="{{ url('rota-dashboard') }}">WFM</a></big>
						<div class="inner-icon">
							<img src="{{URL::to('')}}/theme/main/icon4.png">
						</div>
					</div>
				</div>
			</div>



			<div class="each-section">
				<div class="ele">
					<div class="element">

						<big><a style="padding-left: 54%;" href="{{ url('masters/dashboard') }}">Settings</a></big>

						<div class="inner-icon">
							<img src="{{URL::to('')}}/theme/main/icon7.png">
						</div>
					</div>
				</div>
			</div>

		</div>
		<div style="width: 100%">

			<footer>
				<p>CopyRight © <?php date('Y');?> {{ config('app.name', 'Laravel') }} All Rights Reserved</p>
			</footer>

		</div>

	</section>
	@endif
	@endif
	<script type="text/javascript">
		function getDateTime() {
			var now = new Date();
			var year = now.getFullYear();
			var month = now.getMonth() + 1;
			var day = now.getDate();
			var hour = now.getHours();
			var minute = now.getMinutes();
			var second = now.getSeconds();
			if (month.toString().length == 1) {
				month = '0' + month;
			}
			if (day.toString().length == 1) {
				day = '0' + day;
			}
			if (hour.toString().length == 1) {
				hour = '0' + hour;
			}
			if (minute.toString().length == 1) {
				minute = '0' + minute;
			}
			if (second.toString().length == 1) {
				second = '0' + second;
			}
			var dateTime = "<b>Date:     " + day + '/' + month + '/' + year + "      Time:      " + hour + ':' + minute + ':' + second + "</b>";
			return dateTime;
		}

		// example usage: realtime clock
		setInterval(function() {
			currentTime = getDateTime();
			document.getElementById("time").innerHTML = currentTime;
		}, 1000);
	</script>
</body>  -->




</html>