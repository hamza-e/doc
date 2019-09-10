<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=Edge">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <title>Admin Doc</title>
        <link href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
        <link rel="icon" href="favicon.ico" type="image/x-icon">
        <!-- Custom Css -->
        <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/css/login.css') }}" rel="stylesheet">

        <!-- Swift Themes. You can choose a theme from css/themes instead of get all themes -->
        <link href="{{ asset('assets/css/themes/all-themes.css') }}" rel="stylesheet" />
    </head>
    <body class="theme-cyan login-page authentication">
        <div class="container">
            <div class="card-top"></div>
            <div class="card">
                <h1 class="title"><span>Swift Hospital</span>Register <span class="msg">Register a new membership</span></h1>
                <div class="col-md-12">
                    <form id="sign_up" class="col-xs-12" method="POST" action="{{ route('register') }}">   
                        @csrf         
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="zmdi zmdi-account"></i>
                            </span>
                            <div class="form-line">
                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ old('name') }}" name="name" placeholder="Name Surname" required="" autofocus>
                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="zmdi zmdi-email"></i>
                            </span>
                            <div class="form-line">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="Email Address" name="email" value="{{ old('email') }}" required="">
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="zmdi zmdi-lock"></i>
                            </span>
                            <div class="form-line">
                                <input type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" id="password" name="password" minlength="6" placeholder="Password" required="">
                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="zmdi zmdi-lock"></i>
                            </span>
                            <div class="form-line">
                                <input type="password" class="form-control" name="password_confirmation" id="password-confirm" minlength="6" placeholder="Confirm Password" required="">
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-raised g-bg-cyan waves-effect">SIGN UP</button>
                        </div>
                        <div class="m-t-10 m-b--5 align-center">
                            <a href="{{ route('login') }}">You already have a membership?</a>
                        </div>
                    </form>
                </div>
            </div>  
        </div>
        <div class="theme-bg"></div>
        <!-- Jquery Core Js --> 
        <script src="{{ asset('assets/bundles/libscripts.bundle.js') }}"></script> <!-- Lib Scripts Plugin Js -->
        <script src="{{ asset('assets/bundles/vendorscripts.bundle.js') }}"></script> <!-- Lib Scripts Plugin Js --> 

        <script src="{{ asset('assets/bundles/mainscripts.bundle.js') }}"></script><!-- Custom Js -->
    </body>
</html>