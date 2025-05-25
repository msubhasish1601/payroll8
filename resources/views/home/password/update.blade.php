<!doctype html>
<html>
@include('layouts.default-login')

<head>
    <title>Payroll - Admin Login</title>
    <!-- <link rel="stylesheet" type="text/css" href="css/style.css"> -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a81368914c.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset('img/logo-small.png') }}" type="image/x-icon"/>
</head>


<body style="background-color:white;">
    <div class="login-bg">
        <div class="container login">
            <div class="row main" id="bg-white" style="">
                <div class="col-lg-6 logo">

                    <div class="row">
                        <h1 style="padding:25px 0 0 0"> <span id="green">Qolaris </span> <span id="blue">Payroll</span></h1>
                    </div>
                </div>
                <div class="col-lg-6 form">
                    <div class="row">
                        <div class="col-md-12">
                            <h1>OTP Verification</h1>
                        </div>
                    </div>

          <form class="login-form" method="POST" action="{{ url('password/update') }}">
                    @csrf
                    <div class="text-center mb-3">
                        <span class="d-block text-muted">Enter the OTP sent to your email</span>
                    </div>

                    <div class="form-group">
                        <input type="text" name="otp" class="form-control" placeholder="Enter OTP" required>
                        @if ($errors->has('otp'))
                        <div class="error" style="color:red;">{{ $errors->first('otp') }}</div>


                        @endif

                    </div>

                    <input type="hidden" name="email" value="{{ request()->get('email') }}">

                    <button type="submit" class="btn btn-primary btn-block">
                        Verify OTP
                    </button>

                    @if (session('error'))

                    <div class="alert alert-danger mt-3">{{ session('error') }}</div>

                    @endif
                </form>
            </div>
        </div>
    </div>
</body>
</html>
