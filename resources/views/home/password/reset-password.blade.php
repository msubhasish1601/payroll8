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
                            <h1>Reset Password</h1>
                        </div>
                    </div>

                    @include('include.messages')
                    {{ Form::open(array('route' => array('admin_password_update',$token),'name' => 'resetForm','id' => 'resetForm')) }}
                        @csrf
                        <div class="row form-group">
                            <div class="col-md-12">

                                <input name="email" required type="email" class="form-control" value="{{$email}}"
                                    placeholder="Your registered email" readonly=true>
                                <div class="icon"> <img src="{{ asset('images/user1.png') }}"></div>

                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-12">

                                <input name="password" required type="password" class="form-control" value=""
                                    placeholder="New password">
                                <div class="icon"> <img src="{{ asset('images/key.png') }}"></div>

                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-12">

                                <input name="confirm_password" required type="password" class="form-control" value=""
                                    placeholder="Confirm new password">
                                <div class="icon"> <img src="{{ asset('images/key.png') }}"></div>

                            </div>
                        </div>



                        <button type="submit" class="btn btn-default"> Set Password</button>


                        {{ Form::close() }}
                </div>
            </div>
        </div>

</body>

</html>
