<!doctype html>
<html lang="en">
<head>
    <title>Verify Your Email Address</title>
    @include('layouts.default-login')
</head>
<body>
    <div class="container">
        <h1>Verify Your Email Address</h1>
        @if (session('resent'))
            <div>
                {{ __('A fresh verification link has been sent to your email address.') }}
            </div>
        @endif

        {{ __('Before proceeding, please check your email for a verification link.') }}
        {{ __('If you did not receive the email') }}, 
        <form method="POST" action="{{ route('home.verify') }}">
            @csrf
            <button type="submit">Resend Verification Email</button>


            <div>
                <label for="otp">Enter OTP:</label>
                <input type="text" name="otp" required>
            </div>
        
            <button type="submit">Verify OTP</button>
        
        </form>
    </div>
</body>
</html>
