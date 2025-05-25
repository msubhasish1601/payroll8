<!doctype html>
<html>
@include('layouts.default-login')

<head>
    <title>Payroll - Admin Login</title>
    <!-- <link rel="stylesheet" type="text/css" href="css/style.css"> -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a81368914c.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset('favicon/favicon.ico') }}" type="image/x-icon" />
</head>


<body style="background-color:white;">
    <div class="login-bg">
        <div class="container login">
            <div class="row main" id="bg-white" style="">
                <div class="col-lg-6 logo">

                    <div class="row">
                        <div class="col-md-12">
                        <img src="{{ asset('theme/images/payroll-logo.png') }}"></div>
                    </div>
                </div>

                <div class="col-lg-6 form">
                    <div class="row">
                        <div class="col-md-12">
                            <h1>Forgot password</h1>
                        </div>
                    </div>
                    <!-- Password recovery form -->
                    @include('include.messages')
                    <form action="{{ url('password/email') }}" method="POST">
                        @csrf
                        <div class="row form-group">
                            <div class="col-md-12">
                                <input name="email" required type="email" class="form-control"
                                    value="{{ old('email') }}" placeholder="Your registered email">
                                <div class="icon"> <img src="{{ asset('images/user1.png') }}"></div>
                                <p  class="pull-right"><a href="{{ url('/') }}">Login?</a></p>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-default">
                            <i class="icon-spinner11 mr-2"></i> Reset password
                        </button>

                    </form>
                    <!-- /password recovery form -->
                </div>
            </div>
        </div>
</body>

</html>
