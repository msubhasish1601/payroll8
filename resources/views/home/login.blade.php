<!doctype html>
<html>
@include('layouts.default-login')

<head>
    <title>Payroll - Admin Login</title>
    <!-- <link rel="stylesheet" type="text/css" href="css/style.css"> -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a81368914c.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset('favicon/favicon.ico') }}" type="image/x-icon"/>
</head>

<body style="background-color:white;">
    <!-----------------new-login-------------------- -->
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
                            <h1>Login</h1>
                        </div>
                    </div>
                    @include('include.messages')
                    <form action="{{url('login')}}" method="post">
                        {{csrf_field()}}


                        <div class="row form-group">
                            <div class="col-md-12">
                                <input type="email" class="form-control" placeholder="Username" name="email">
                                <div class="icon"> <img src="{{ asset('images/user1.png') }}"></div>
                                @if ($errors->has('email'))
                                <div class="error" style="color:red;">{{ $errors->first('email') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-12">
                                <input type="password" class="form-control" placeholder="Password" name="psw">
                                <div class="icon"> <img src="{{ asset('images/key.png') }}"></div>
                                @if ($errors->has('psw'))
                                <div class="error" style="color:red;">{{ $errors->first('psw') }}</div>


                                @endif


                                <p  class="pull-right"><a href="{{ url('password/email') }}">Forgot Password?</a></p>



                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-12">
                                <button class="btn btn-default" type="submit">LOGIN </button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <!------------------------------------------------>



    @include('include.script')

    <script>
    const inputs = document.querySelectorAll(".input");


    function addcl() {
        let parent = this.parentNode.parentNode;
        parent.classList.add("focus");
    }

    function remcl() {
        let parent = this.parentNode.parentNode;
        if (this.value == "") {
            parent.classList.remove("focus");
        }
    }


    inputs.forEach(input => {
        input.addEventListener("focus", addcl);
        input.addEventListener("blur", remcl);
    });




    $(".toggle-password").click(function() {

        $(this).toggleClass("fa-eye fa-eye-slash");
        var input = $($(this).attr("toggle"));
        if (input.attr("type") == "password") {
            input.attr("type", "text");
        } else {
            input.attr("type", "password");
        }
    });
    </script>

</body>





<!-- <body>
   <section class="Form my-4 mx-5">
       <div class="container">
           <div class="row no-gutters">
               <div class="col-lg-5">
                   <img src="{{ asset('theme/images/logo1.jpg') }}" class="img-fluid" alt="">
               </div>
               <div class="col-lg-7 text-center px-5 pt-5">
                   <h1 class="font-weight-bold py-3">Login</h1>
                   <h4>Sign into your account</h4>
                   <form action="{{url('loginbmrc')}}" method="post">
                   {{csrf_field()}}
                       <div class="form-row">
                           <div class="col-lg-7 ">
                               <input type="email" placeholder="Email" name="email" class="form-control my-3">
                               @if ($errors->has('email'))
        <div class="error" style="color:red;">{{ $errors->first('email') }}</div>
@endif
                           </div>

                       </div>
                       <div class="form-row">
                        <div class="col-lg-7 ">
                            <input  id="password-field" type="password" placeholder="Password" name="psw" class="form-control my-3">
                            <a href="javascript:void(0);"><span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span></a>
    @if ($errors->has('psw'))
        <div class="error" style="color:red;">{{ $errors->first('psw') }}</div>
@endif
                        </div>

                    </div>
                    @include('include.messages')

                        <div class="form-row">
                            <div class="col-lg-7">
                                <button type="submit"  class="btn1">Login</button>

                            </div>

                        </div>


                    </div>
                   </form>
               </div>
           </div>
       </div>
   </section>
 -->
<!-- @include('include.script')

<script>
$(".toggle-password").click(function() {

  $(this).toggleClass("fa-eye fa-eye-slash");
  var input = $($(this).attr("toggle"));
  if (input.attr("type") == "password") {
    input.attr("type", "text");
  } else {
    input.attr("type", "password");
  }
});




</script> -->
<!-- </body> -->











<!-- <div class="login-body">
<div class="text-center new-crd-hd">
		<img src="{{ asset('theme/images/bellevue-logo.jpeg') }}" alt="logo">
	</div>
	<div class="container col-md-8 login-container">

            <div class="row">

                <div class="col-md-12 login-form-1">
                    <h3>Login</h3>
					<p>Sign In to your account</p>
                    <form action="{{url('loginbmrc')}}" method="post">
                        {{csrf_field()}}
      <div class="input-container">
    <i class="fa fa-user icon"></i>
    <input class="input-field" type="email" placeholder="Email" name="email"> -->
<!-- @if ($errors->has('email'))
        <div class="error" style="color:red;">{{ $errors->first('email') }}</div>
@endif -->
<!-- @if ($errors->has('email'))
        <div class="error" style="color:red;">{{ $errors->first('email') }}</div>
@endif
  </div>
  <div class="input-container">
    <i class="fa fa-key icon"></i>
    <input class="input-field" id="password-field" type="password" placeholder="Password" name="psw"> -->
<!--    <a href="javascript:void(0);"><i class="fa fa-eye" ></i></a>-->
<!-- <a href="javascript:void(0);"><span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span></a> -->
<!-- @if ($errors->has('psw'))
        <div class="error" style="color:red;">{{ $errors->first('psw') }}</div>
@endif -->
<!-- @if ($errors->has('psw'))
        <div class="error" style="color:red;">{{ $errors->first('psw') }}</div>
@endif
  </div>

@if(Session::has('error'))
<div class="alert alert-danger" style="text-align:center;color: #ff0000;"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i><em > {{ Session::get('login_error') }}</em></div>
@endif
@if(Session::has('message'))
<div class="alert alert-success" style="text-align:center;"><i class="fa fa-key"></i><em> {{ Session::get('message') }}</em></div>
	@endif
   <div class="input-container">
   <button class="btn btn-default" type="submit" style="width:100%;">Login</button> -->
<!--<div class="col-md-8 frgt" style="float:right;"><a href="#"> Forgot Password?</a></div>-->

<!-- </div>
                    </form>
                </div>

            </div>
        </div>
</div>
  @include('include.script')

  <script>
$(".toggle-password").click(function() {

  $(this).toggleClass("fa-eye fa-eye-slash");
  var input = $($(this).attr("toggle"));
  if (input.attr("type") == "password") {
    input.attr("type", "text");
  } else {
    input.attr("type", "password");
  }
});




</script>
</body>
</html> -->
