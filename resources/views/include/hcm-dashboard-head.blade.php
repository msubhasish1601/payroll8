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
    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta name="description" content="Ela Admin - HTML5 Admin Template">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset('img/logo-small.png') }}" type="image/x-icon" />
    <!--<link rel="apple-touch-icon" href="https://i.imgur.com/QRAUqs9.png">
    <link rel="shortcut icon" href="https://i.imgur.com/QRAUqs9.png">-->

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/normalize.css@8.0.0/normalize.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lykmapipo/themify-icons@0.1.2/css/themify-icons.css">
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/pixeden-stroke-7-icon@1.2.3/pe-icon-7-stroke/dist/pe-icon-7-stroke.min.css">
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
        padding: 2% 11px;
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

    footer {
        background: #225c8e;
        color: #fff;
        text-align: center;
        padding: 5px;
        position: fixed;
        bottom: 0;
        width: 100%;
    }

    footer p {
        color: #fff;
        margin-bottom: 0;
    }

    .rice-logo {
        margin-top: 75px;
    }

    .hcm-head h1 span {
        font-size: 38px;
        font-weight: 600;
        color: #0e3d69;
    }

    .hcm-head h1 {
        font-size: 21px;
        color: #0e3d69;
    }

    .rice-logo img {
        max-width: 240px;
        -ms-transform: rotate(20deg);
        -webkit-transform: rotate(20deg);
        transform: rotate(-90deg);
    }

    .pay-icon {
        background: #CE4C58;
        padding: 24px 0;
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

    .header {
        /* background: #f4f4f4; */
        background: #fff;
        /* padding: 10px; */
        box-shadow: 2px -1px 5px 2px #999;
    }

    .pay-icon.blue.lv-ap {
        background: #0a98da;
        padding: 21px 0;
    }

    .pay-icon.pink {
        background: #b928a6;
        padding: 21px 0;
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
        padding: 20.5px 0;
    }

    .user-name {
        text-align: right;
        margin-top: 30px;
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

    .pay-cont.blue a {
        background: #0a98da;
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

    .inner-dashboard {
        background: #fff;
    }

    .hcm-head h1 {
        font-size: 21px;
        color: #0e3d69;
        padding: 15px 25px;
    }

    .inner-dashboard {
        border-radius: 7px;
    }

    .hcm-head {
        border-bottom: 1px solid #ddd;
    }

    /* .hcm-inner {
    padding: 15px 25px;
}	 */

    .hcm-icon {
        background: #f1b732;
        padding: 26px 3px;
        text-align: center;
        height: 129px;
        ;
    }

    .hcm-icon.green {
        background: #27a527;
    }

    .hcm-icon.vio {
        background: #b928a7;
    }

    .hcm-icon.sky {
        background: #0a98da;
    }

    .hcm-icon.red {
        background: #ce4c58;
    }

    .hcm-name {
        background: #d3d3d3;
        text-align: center;
        height: 129px;
        padding: 37px 19px;
    }

    .hcm-name.green a img {
        background: #27a527;
    }

    .hcm-name.vio a img {
        background: #b928a7;
    }

    .hcm-name.sky a img {
        background: #0a98da;
    }

    .hcm-name.red a img {
        background: #ce4c58;
    }

    .hcm-name p {
        color: #000;
        margin-bottom: 0;
        font-size: 18px;
    }

    .hcm-icon img {
        max-width: 70px;

    }

    .hcm-name a img {
        background: #f1b732;
        width: 30px;
        height: 30px;
        /* width: 20px; */
        border-radius: 50%;
        margin-top: 9px;
        padding: 4px;
    }

    .pl0 {
        padding-left: 0;
    }

    .pr0 {
        padding-right: 0;
    }

    .hcm {
        margin-bottom: 30px;
        width: 410px;
        margin: 40px 30px;
    }

    .payroll-main {
        padding: 15px 25px 1px;
        margin-bottom: 0;
    }
    </style>

</head>
