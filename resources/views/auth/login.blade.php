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
                <h1 class="title"><span>Swift Hospital</span>Login <span class="msg">Sign in to start your session</span></h1>
                <div class="col-md-12">
                    <form id="sign_in" method="POST" action="{{ route('login') }}">
                        @csrf
                        
                        <div class="input-group"> <span class="input-group-addon"> <i class="zmdi zmdi-account"></i> </span>
                            <div class="form-line">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" placeholder="Username" value="{{ old('email') }}" required autofocus>
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="input-group"> <span class="input-group-addon"> <i class="zmdi zmdi-lock"></i> </span>
                            <div class="form-line">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Password" required>
                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div>
                            <div class="">
                                <input type="checkbox" name="remember" id="remember" class=" filled-in chk-col-pink" {{ old('remember') ? 'checked' : '' }}>
                                <label for="remember">Remember Me</label>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-raised waves-effect g-bg-cyan">SIGN IN</button>
                                <a href="{{ route('register') }}" class="btn btn-raised waves-effect">SIGN UP</a>
                            </div>
                            <div class="text-center"> <a href="{{ route('password.request') }}">Forgot Password?</a></div>
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