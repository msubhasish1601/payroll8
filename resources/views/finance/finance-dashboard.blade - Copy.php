<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="">
<!--<![endif]-->

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Bellevue</title>
    <meta name="description" content="Ela Admin - HTML5 Admin Template">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!--<link rel="apple-touch-icon" href="https://i.imgur.com/QRAUqs9.png">
    <link rel="shortcut icon" href="https://i.imgur.com/QRAUqs9.png">-->

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/normalize.css@8.0.0/normalize.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lykmapipo/themify-icons@0.1.2/css/themify-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pixeden-stroke-7-icon@1.2.3/pe-icon-7-stroke/dist/pe-icon-7-stroke.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.2.0/css/flag-icon.min.css">
    <link rel="stylesheet" href="{{ asset('theme/assets/css/cs-skin-elastic.css') }}">
    <link rel="stylesheet" href="{{ asset('theme/assets/css/style.css') }}">
    <!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/html5shiv/3.7.3/html5shiv.min.js"></script> -->
    <link href="https://cdn.jsdelivr.net/npm/chartist@0.11.0/dist/chartist.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/jqvmap@1.5.1/dist/jqvmap.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/weathericons@2.1.0/css/weather-icons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@3.9.0/dist/fullcalendar.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
    <link href="{{ asset('theme/assets/css/ars_coolection.css') }}" rel="stylesheet" type="text/css" media="screen">
    <script src="{{ asset('theme/assets/js/jquery.gridly.js') }}" type='text/javascript'></script>
    <script src="{{ asset('theme/assets/js/sample.js') }}" type='text/javascript'></script>
    <script src="{{ asset('theme/assets/js/rainbow.js') }}" type='text/javascript'></script>
    <style>
        body {
            background: #e0e0e0;
            font-family: 'Lato', sans-serif;
        }

        p {
            font-family: 'Lato', sans-serif;
        }

        .main-body {
            padding: 8% 0;
        }

        .pis-hd h2 span {
            font-size: 12px;
        }

        .pis-hd {
            background: #034f88;
            width: 268px;
            padding: 15px 12px;
            color: #fff;
            border: 2px solid #fff;
            margin-right: 1px;
        }

        .rice-logo {
            margin-top: 75px;
        }

        .rice-logo img {
            max-width: 240px;
            -ms-transform: rotate(20deg);
            -webkit-transform: rotate(20deg);
            transform: rotate(-90deg);
        }

        .pay-icon {
            background: #CE4C58;
            padding: 14.4% 0;
            border: 2px solid #fff;
        }

        .pay-icon img {
            width: 75px;
            height: auto;
        }

        .pay-cont.green a {
            background: #27a527;
            /* color: #999; */
        }

        .pay-cont {
            background: #fff;
            padding: 16.2px 10px;
            ;
        }

        .pay-cont h3 {
            font-size: 19px;
            font-weight: 600;
            margin-bottom: 10%;
        }

        .pay-cont a {
            background: #ce4c58;
            color: #fff;
            padding: 9px 36px;
            border-radius: 50px;
        }

        .pay-icon.red {
            padding: 21px 0;
        }

        .pay-icon.pink {
            background: #b928a6;
            padding: 24px 0;
        }

        .boxOuter {
            float: left !important;
            margin: 0px 2px 0 0;
            padding: 0px;
            width: 30% !important;
            margin-bottom: 3px;
        }

        .boxOuter .col-lg-3 {
            width: 100%;
            max-width: 100%;
            padding: 0px;
            margin: 0px;
        }

        .pay-cont.yellow a {
            background: #f1b632;
        }

        .boxOuter2 {
            float: left !important;
            margin: 0px 2px 0px 0px;
            padding: 0px;
            width: 44% !important;
        }

        .boxOuter2 .col-lg-6 {
            width: 100%;
            max-width: 100%;
            padding: 0px;
            margin: 0px;
        }

        .boxOuter2 .pay-icon {
            width: 50%;
            float: left;
            background: #7E3C94;
            text-align: center;
            min-height: 217px;
        }

        .boxOuter2 .pay-icon img {
            width: 75px;
            height: auto;
            text-align: center;
            display: block;
            margin: 0px auto;
        }

        .boxOuter2 .pay-cont {
            width: 50%;
            float: left;
            background: #ffffff;
            text-align: center;
            min-height: 217px;
        }

        .boxOuter2 .pay-cont h3 {
            font-size: 19px;
            font-weight: 600;
            margin-bottom: 20%;
            padding: 40px 10px 0px;
        }

        .boxOuter2 .pay-cont a {
            background: #7e3c94;
            color: #fff;
            padding: 9px 36px;
            border-radius: 50px;
        }

        .boxOuter2 .pay-cont.green a {
            background: #648304;
        }


        .boxOuter3 {
            float: left !important;
            margin: 0px 0px 0px 0px;
            padding: 0px;
            width: 24% !important;
        }

        .boxOuter3 .col-lg-3 {
            width: 100%;
            max-width: 100%;
            padding: 0px;
            margin: 0px;
        }

        .boxOuter2 .pay-icon.green {
            background: #648304;
            min-height: 216px;
        }

        .boxOuter3 .pay-icon {
            width: 100%;
            float: left;
            background: #0FA5C8;
            text-align: center;
            min-height: 100px;
        }

        .boxOuter3 .pay-icon img {
            width: auto;
            height: 50px;
            text-align: center;
            display: block;
            margin: 0px auto;
        }

        .boxOuter3 .pay-cont {
            width: 100%;
            float: left;
            background: #ffffff;
            text-align: center;
            min-height: 103px;
            padding: 0px;
            margin: 0px;
        }

        .boxOuter3 .pay-cont h3 {
            font-size: 19px;
            font-weight: 600;
            margin-bottom: 10%;
            padding: 15px 10px 0px;
        }

        .boxOuter3 .pay-cont a {
            background: #0FA5C8;
            color: #fff;
            padding: 9px 36px;
            border-radius: 50px;
        }

        .pay-cont.pink a {
            background: #b928a6;
        }

        .pay-icon.green {
            background: #27a527;
            padding: 24.5px 0;
        }

        .user-name {
            text-align: right;
        }

        .user-name h4 {
            color: #7e3c94;
            FONT-SIZE: 18px;
            margin-top: 15px;
        }

        .user-name h4 span i {
            color: #7e3c94;
        }

        .pay-icon.yellow {
            background: #f1b632;
            padding: 24px 0;
        }

        .pay-icon.yellow.lv-ap img {
            width: 60px;
        }

        .pay-cont.ylw a {
            background: #f1b632;
        }

        .pay-icon.pink.pnk-holi img {
            width: 73px;
        }
    </style>

</head>

<body>
    @if(Session::get('admin'))
    <div class="header">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="user-name">
                        <h4><i class="ti-user"></i> Welcome {{Session::get('admin')->name}} <span><a href="{{url('logout')}}" title="logout"><i class="ti-power-off"></i></a></span></h4>

                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    <div class="main-body">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="pis-hd">
                        <h2>FM<span>Finance Management</span></h2>
                    </div>

                    <div class="rice-logo" style="margin-top: 0px !important;">
                        <!-- <a href="{{ url('hcm-dashboard') }}"><img src="{{ asset('theme/images/bopt-logo.png')}}" alt="logo" style="max-width: 123px !important;margin-left:66px;transform: rotate(0deg)!important;"></a> -->
                    </div>
                </div>
                <?php
                $payroll = '';
                $attendance = '';
                $leave_application = '';
                ?>
                @if(Session::get('admin'))
                @foreach($Roledata as $roles)
                @if(Session::get('admin')->email==$roles->member_id)
                @if($roles->sub_module_name=='payroll')
                <?php $payroll = 'payroll'; ?>

                @endif
                @if($roles->sub_module_name=='Leave application')
                <?php $leave_application = 'Leave_application'; ?>

                @endif
                @if($roles->sub_module_name=='attendance')
                <?php $attendance = 'attendance'; ?>

                @endif

                <?php $module_name = $roles->sub_module_name; ?>
                @endif
                @endforeach
                @endif
                <div class="text-center col-lg-9" style="padding:0;">
                    <div class="payroll-main">

                        @if(Session::get('admin')->user_type=='user')
                        <?php $submenus = array();
                        foreach ($Roledata as $roleaccess) {
                            $submenus[] = $roleaccess->sub_module_name;
                        }
                        $submenuslist = array_unique($submenus); ?>
                        <?php if (in_array("Payroll", $submenuslist)) { ?>
                            <div class="boxOuter">
                                <div class="col-lg-3">
                                    <div class="pay-icon">
                                        <img src="{{ asset('theme/images/payroll.png') }}" alt="payroll">
                                    </div>
                                    <div class="pay-cont">
                                        <h3>Payroll</h3>
                                        <div class="clearfix"></div>
                                        <a href="{{ url('pis/dashboard') }}">Start</a>
                                    </div>
                                </div>
                            </div>





                        <?php } ?>

                        @else
                        <div class="boxOuter">
                            <div class="col-lg-3">
                                <div class="pay-icon">
                                    <img src="{{ asset('theme/images/leave-application-icon.png') }}" alt="payroll">
                                </div>
                                <div class="pay-cont">
                                    <h3>Payroll</h3>
                                    <div class="clearfix"></div>
                                    <a href="{{ url('pis/dashboard') }}">Start</a>
                                </div>
                            </div>
                        </div>

                        <!-- <div class="boxOuter">
                    <div class="col-lg-3">
                        <div class="pay-icon pink">
                            <img src="{{ asset('theme/images/hr.png') }}" alt="payroll accounting">
                        </div>
                        <div class="pay-cont pink">
                            <h3>Payroll Accounting</h3>
                            <div class="clearfix"></div>
                            <a href="{{ url('payrollaccounting/dashboard') }}">Start</a>
                        </div>
                    </div>
                </div>

                <div class="boxOuter">
                    <div class="col-lg-3">
                        <div class="pay-icon green" style="background:#0a9ad2;">
                            <img src="{{ asset('images/account-receivable.png') }}" alt="stipend">
                        </div>
                        <div class="pay-cont green">
                            <h3>Account Receivable</h3>
                            <div class="clearfix"></div>
                            <a style="background: #0a9ad2;" href="{{ url('accountreceivable/dashboard') }}">Start</a>
                        </div>
                    </div>
                </div>

            <div class="boxOuter">
                <div class="col-lg-3">
                    <div class="pay-icon yellow">
                    <img src="{{ asset('theme/images/hr.png') }}" alt="account payable">
                    </div>
                    <div class="pay-cont yellow">
                        <h3>Account Payable</h3>
                        <div class="clearfix"></div>
                        <a href="{{ url('accountpayable/dashboard') }}">Start</a>
                    </div>
                </div>
            </div>





            <div class="boxOuter">
                <div class="col-lg-3">
                    <div class="pay-icon green">
                        <img src="{{ asset('theme/images/hr.png') }}" alt="stipend">
                    </div>
                    <div class="pay-cont green">
                        <h3>Stipend</h3>
                        <div class="clearfix"></div>
                        <a href="{{ url('stipend/dashboard') }}">Start</a>
                    </div>
                </div>
            </div>

			<div class="boxOuter">
                <div class="col-lg-3">
                    <div class="pay-icon green">
                        <img src="{{ asset('theme/images/hr.png') }}" alt="stipend">
                    </div>
                    <div class="pay-cont green">
                        <h3>GPF</h3>
                        <div class="clearfix"></div>
                        <a href="{{ url('gpf/dashboard') }}">Start</a>
                    </div>
                </div>
            </div>
			<div class="boxOuter">
                    <div class="col-lg-3">
                        <div class="pay-icon green">
                            <img src="{{ asset('theme/images/hr.png') }}" alt="stipend">
                        </div>
                        <div class="pay-cont green">
                            <h3>Depreciation</h3>
                            <div class="clearfix"></div>
                            <a href="{{ url('depreciation/dashboard') }}">Start</a>
                        </div>
                    </div>
                </div> -->


                        <!-- <div class="boxOuter">
                            <div class="col-lg-3">
                                <div class="pay-icon green">
                                    <img src="{{ asset('theme/images/hr.png') }}" alt="stipend">
                                </div>
                                <div class="pay-cont green">
                                    <h3>Pension</h3>
                                    <div class="clearfix"></div>
                                    <a href="{{ url('pension/dashboard') }}">Start</a>
                                </div>
                            </div>
                        </div>


                        <div class="boxOuter">
                            <div class="col-lg-3">
                                <div class="pay-icon green">
                                    <img src="{{ asset('theme/images/hr.png') }}" alt="stipend">
                                </div>
                                <div class="pay-cont green">
                                    <h3>Advance/Loan</h3>
                                    <div class="clearfix"></div>
                                    <a href="{{ url('loan/dashboard') }}">Start</a>
                                </div>
                            </div>
                        </div> -->



                        @endif
                        <div class="clearfix"></div>

                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@2.2.4/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.4/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-match-height@0.7.2/dist/jquery.matchHeight.min.js"></script>
    <script src="{{ asset('theme/assets/js/main.js') }}"></script>

    <!--<script src="dragonfly.js"></script>-->
    <script src="{{ asset('theme/assets/js/jquery.js') }}" type='text/javascript'></script>
    <script src="{{ asset('theme/assets/js/jquery.gridly.js') }}" type='text/javascript'></script>
    <script src="{{ asset('theme/assets/js/sample.js') }}" type='text/javascript'></script>
    <script src="{{ asset('theme/assets/js/rainbow.js') }}" type='text/javascript'></script>
</body>

</html>