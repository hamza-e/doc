<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=Edge">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Admin Doc') }}</title>
        <link rel="icon" href="favicon.ico" type="image/x-icon">

        @include('layouts/inc/stylesheets')
        @yield('styles')
        @yield('head')
    </head>

    <body class="theme-cyan">
        <!-- Page Loader -->
        <div class="page-loader-wrapper">
            <div class="loader">
                <div class="preloader">
                    <div class="spinner-layer pl-cyan">
                        <div class="circle-clipper left">
                            <div class="circle"></div>
                        </div>
                        <div class="circle-clipper right">
                            <div class="circle"></div>
                        </div>
                    </div>
                </div>
                <p>Please wait...</p>
            </div>
        </div>
        <!-- #END# Page Loader --> 
        <!-- Overlay For Sidebars -->
        <div class="overlay"></div>
        <!-- #END# Overlay For Sidebars -->
        <!-- #Float icon -->
        <ul id="f-menu" class="mfb-component--br mfb-zoomin" data-mfb-toggle="hover">
          <li class="mfb-component__wrap">
            <a href="#" class="mfb-component__button--main g-bg-cyan">
              <i class="mfb-component__main-icon--resting zmdi zmdi-plus"></i>
              <i class="mfb-component__main-icon--active zmdi zmdi-close"></i>
            </a>
            <ul class="mfb-component__list">
              <li>
                <a href="{{route('calendrier')}}" data-mfb-label="Doctor Schedule" class="mfb-component__button--child bg-blue">
                  <i class="zmdi zmdi-calendar mfb-component__child-icon"></i>
                </a>
              </li>
              <li>
                <a href="{{route('patients.index')}}" data-mfb-label="Patients List" class="mfb-component__button--child bg-orange">
                  <i class="zmdi zmdi-account-o mfb-component__child-icon"></i>
                </a>
              </li>

              <li>
                <a href="payments.html" data-mfb-label="Payments" class="mfb-component__button--child bg-purple">
                  <i class="zmdi zmdi-balance-wallet mfb-component__child-icon"></i>
                </a>
              </li>
            </ul>
          </li>
        </ul>
        <!-- #Float icon -->
        
        @include('layouts/inc/top-bar')
        @include('layouts/inc/side-bar')

        @yield('content')

        <div class="color-bg"></div>
        
        @include('layouts/inc/scripts')
        @yield('footer')
        @yield('scripts')
    </body>
</html>