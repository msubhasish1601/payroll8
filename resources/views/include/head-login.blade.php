<head>
    <link rel="icon" href="{{ asset('favicon/favicon.ico') }}" type="image/x-icon" />
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Lato:wght@300&display=swap');

    * {
        margin: 0;
        padding: 0;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
    }

    body {
        background-image: linear-gradient(rgba(63, 15, 89, 0.7), rgba(63, 15, 89, 0.7)), url('Belle_Vue_Clinic.jpg');
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-size: cover;
        font-family: 'Lato', sans-serif;

    }

    .user {
        width: 15px;
        position: absolute;
        bottom: 178px;
        right: 30px;

    }

    .password {
        width: 20px;
        height: 25px;
        position: absolute;
        bottom: 120px;
        right: 30px;
    }

    #user-icon {
        font-size: 20px;
        /* top: 100px; */
        position: absolute;
        bottom: 178px;
        right: 30px;
    }

    #pws-icon {
        position: absolute;
        bottom: 125px;
        right: 30px;
    }

    header {
        /* background: #f4f4f4; */
        background: #fff;
        box-shadow: 2px 2px 6px 2px #ccc;
        /* padding: 10px; */
    }

    ul.head-right {
        margin-bottom: 0;
        margin-top: 24px;
    }

    li {
        list-style-type: none;
    }

    .section {
        width: 100vw;
        height: 100vh;
        position: relative;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .head-right {
        float: right;
    }

    #bg-white {
        background-color: #fff;
        /* padding: 100px; */
        max-width: 600px;
        padding: 35px 20px 0px 15px;
        border-radius: 10px;
        width: 100%;
        position: absolute;
        left: 0;
        right: 0;
        margin: 215px 0 0 470px;
        opacity: 0.878;
    }

    #exampleInputEmail1 {
        width: 150%;
        border-radius: 50px;
        border-color: #999999;
    }

    #button {
        width: 372px;
        border-radius: 50px;
        background: darkblue;
        margin-bottom: 20px;
    }

    .login {
        width: 60vw;
        height: 60vh;

    }

    #forgot {
        text-align: right;
        margin-right: 3px;
        color: #0e3d69;
        font-weight: 600;
    }

    .logo {
        margin-top: 50px;
        height: 260px;
    }

    .logo h1 {
        margin-top: 24px;
        font-size: 31px;
        position: absolute;
        left: 20px;
        font-weight: 600;
    }

    #green {
        color: #3d9839;
    }

    #blue {
        color: #0e3d69;
    }

    .form h1 {
        margin-bottom: 33px;
        font-size: 30px;
        font-weight: 600;
    }

    .form h1::before {
        content: '';
        position: absolute;
        background-color: #0e3d69;
        width: 12%;
        height: 4.5px;
        top: -10px;
        left: 16px;
    }

    .logo::after {
        content: '';
        position: absolute;
        background-color: #e0e0e0;
        width: 2px;
        height: 100%;
        bottom: 28px;
        left: 275px;
    }

    .login .form-control {
        height: 37px;
        font-size: 13px;
        border-radius: 28px;
        border: 2px solid #727272;
    }

    .icon {
        padding: 11px;
        /* background: #257be3; */
        color: #3b88e5;
        /* min-width: 50px; */
        /* text-align: center; */
        /* border-top-left-radius: 5px; */
        /* border-bottom-left-radius: 5px; */
        height: 38px;
        border-bottom: none !important;
        width: 38px;
        position: absolute;
        right: 16px;
        top: -7px;
    }

    .login p {
        text-align: right;
    }

    .login .btn.btn-default {
        width: 100%;
        border-radius: 28px;
        background: #225c8d;
        color: #fff;
    }

    .login p a {
        text-align: right;
        font-size: 14px;
        color: #13548d;
        font-weight: 600;
    }

    .login-bg {
        background: url("{{ asset('images/login-bg.jpg') }}") no-repeat center center;
        background-size: 100%;
        height: 100vh;
    }

    .wrapper {
        padding: 0 108px;
    }

    .main-dash {
        margin: 80px 0 30px;
    }

    .dash-name h3 {
        font-size: 23px;
        font-weight: 600;
    }

    .dash-name {
        float: left;
        margin-top: 103px;
        text-align: center;
        width: 100%;
        color: #fff;
        font-size: -5px;
    }

    .box.sky {
        background: #0c75d1;
    }

    .box.green {
        background: #3a9c37;
    }

    .box.blue {
        background: #225c8e;
    }

    .box.dc {
        background: #008f5c;
    }

    .box.sky .dash-icon {
        background: #0c75d1;
    }

    .box.dc .dash-icon {
        background: #008f5c;
    }

    .box.green .dash-icon {
        background: #3a9c37;
    }

    .box.blue .dash-icon {
        background: #225c8e
    }

    .dash-icon {
        position: absolute;
        /* display: block; */
        /* width: 100%; */
        width: 90px;
        height: 90px;
        background: #0e3d69;
        left: 0;
        right: 0;
        margin: auto;
        padding: 14px;
        border-radius: 50%;
        border: 4px solid #e4e5e6;
        top: -42px;
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

    .box {
        background: #0e3d69;
        border-radius: 11px;
        text-align: center;
        position: relative;
        min-height: 200px;
        margin-bottom: 54px;
        max-width: 389px;
        width: 100%;
    }
    }

    @media (max-width: 575.98px) {
        .wrapper {
            padding: 0 15x;
        }
    }
    </style>


    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ config('app.name', 'Laravel') }} - LOGIN</title>
    <meta name="description" content="Ela Admin - HTML5 Admin Template">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-------------favicon--------------->
    <!--<link rel="apple-touch-icon" href="https://i.imgur.com/QRAUqs9.png">
    <link rel="shortcut icon" href="https://i.imgur.com/QRAUqs9.png">-->
    <!-------------------------->

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/normalize.css@8.0.0/normalize.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lykmapipo/themify-icons@0.1.2/css/themify-icons.css">
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/pixeden-stroke-7-icon@1.2.3/pe-icon-7-stroke/dist/pe-icon-7-stroke.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.2.0/css/flag-icon.min.css">
    <link rel="stylesheet" href="{{ asset('css/cs-skin-elastic.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>

    <!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/html5shiv/3.7.3/html5shiv.min.js"></script> -->

</head>
