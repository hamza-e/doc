<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Find easily a doctor and book online an appointment">
	<title>MEDOC - Find easily a doctor and book online an appointment</title>

	<!-- Favicons-->
	<link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
	<link rel="apple-touch-icon" type="image/x-icon" href="img/apple-touch-icon-57x57-precomposed.png">
	<link rel="apple-touch-icon" type="image/x-icon" sizes="72x72" href="img/apple-touch-icon-72x72-precomposed.png">
	<link rel="apple-touch-icon" type="image/x-icon" sizes="114x114" href="img/apple-touch-icon-114x114-precomposed.png">
	<link rel="apple-touch-icon" type="image/x-icon" sizes="144x144" href="img/apple-touch-icon-144x144-precomposed.png">

	<!-- BASE CSS -->
	<link href="{{asset('assets/frontassets/css/bootstrap.min.css')}}" rel="stylesheet">
	<link href="{{asset('assets/frontassets/css/style.css')}}" rel="stylesheet">
	<link href="{{asset('assets/frontassets/css/menu.css')}}" rel="stylesheet">
	<link href="{{asset('assets/frontassets/css/vendors.css')}}" rel="stylesheet">
	<link href="{{asset('assets/frontassets/css/icon_fonts/css/all_icons_min.css')}}" rel="stylesheet">
    
	<!-- YOUR CUSTOM CSS -->
	<link href="{{asset('assets/frontassets/css/custom.css')}}" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>

	@yield('head')

</head>
<header class="header_sticky">
	<div class="container">
		<div class="row">
			<div class="col-lg-3 col-6">
				<div id="logo_home">
					<h1><a href="{{route('search')}}" title="MEDOC">MEDOC</a></h1>
				</div>
			</div>
			<nav class="col-lg-9 col-6">
				<a class="cmn-toggle-switch cmn-toggle-switch__htx open_close" href="#0"><span>Menu mobile</span></a>
				<ul id="top_access">
					<li><a href="{{route('login')}}"><i class="pe-7s-user"></i></a></li>
					<li><a href="register-doctor.html"><i class="pe-7s-add-user"></i></a></li>
				</ul>
				<div class="main-menu">
					<ul>
						<li class="submenu">
							<a href="#0" class="show-submenu">Home<i class="icon-down-open-mini"></i></a>
							<ul>
								<li><a href="index.html">Home Default</a></li>
								<li><a href="index-2.html">Home Version 2</a></li>
								<li><a href="index-3.html">Home Version 3</a></li>
								<li><a href="index-4.html">Home Version 4</a></li>
                                <li><a href="index-6.html">Revolution Slider</a></li>
								<li><a href="index-5.html">With Cookie Bar (EU law)</a></li>
							</ul>
						</li>
						<li class="submenu">
							<a href="#0" class="show-submenu">Pages<i class="icon-down-open-mini"></i></a>
							<ul>
								<li><a href="list.html">List page</a></li>
								<li><a href="grid-list.html">List grid page</a></li>
								<li><a href="list-map.html">List map page</a></li>
								<li><a href="detail-page.html">Detail page</a></li>
								<li><a href="detail-page-2.html">Detail page 2</a></li>
                                <li><a href="detail-page-3.html">Detail page 3</a></li>
								<li><a href="blog-1.html">Blog</a></li>
								<li><a href="badges.html">Badges</a></li>
								<li><a href="login.html">Login</a></li>
								<li><a href="login-2.html">Login 2</a></li>
								<li><a href="register-doctor.html">Register Doctor</a></li>
								<li><a href="register.html">Register</a></li>
								<li><a href="contacts.html">Contacts</a></li>
							</ul>
						</li>
						<li class="submenu">
							<a href="#0" class="show-submenu">Extra Elements<i class="icon-down-open-mini"></i></a>
							<ul>
                            	<li><a href="detail-page-working-booking.html">Detail working booking</a></li>
                                <li><a href="booking-page.html">Booking page</a></li>
                                <li><a href="confirm.html">Confirm page</a></li>
                            	<li><a href="faq.html">Faq page</a></li>
                                <li><a href="coming_soon/index.html">Coming soon</a></li>
                                 <li><a href="pricing-tables.html">Responsive pricing tables</a></li>
                                 <li><a href="pricing-tables-2.html">Responsive pricing tables 2</a></li>
                                 <li><a href="register-doctor-working.html">Working doctor register</a></li>
								<li><a href="icon-pack-1.html">Icon pack 1</a></li>
								<li><a href="icon-pack-2.html">Icon pack 2</a></li>
								<li><a href="icon-pack-3.html">Icon pack 3</a></li>
								<li><a href="404.html">404 page</a></li>
							</ul>
						</li>
						<li><a href="#0">Buy this template</a></li>
					</ul>
				</div>
				<!-- /main-menu -->
			</nav>
		</div>
	</div>
	<!-- /container -->
</header>
<!-- /header -->

<body ng-app="myApp">

	<div class="layer"></div>
	<!-- Mobile menu overlay mask -->

	<div id="preloader">
		<div data-loader="circle-side"></div>
	</div>
	<!-- End Preload -->


	@yield('content')


<footer>
	<div class="container margin_60_35">
		<div class="row">
			<div class="col-lg-3 col-md-12">
				<p>
					<a href="index.html" title="Findoctor">
						<img src="{{asset('assets/frontassets/img/logo.png')}}" data-retina="true" alt="" width="163" height="36" class="img-fluid">
					</a>
				</p>
			</div>
			<div class="col-lg-3 col-md-4">
				<h5>About</h5>
				<ul class="links">
					<li><a href="#0">About us</a></li>
					<li><a href="blog.html">Blog</a></li>
					<li><a href="#0">FAQ</a></li>
					<li><a href="login.html">Login</a></li>
					<li><a href="register.html">Register</a></li>
				</ul>
			</div>
			<div class="col-lg-3 col-md-4">
				<h5>Useful links</h5>
				<ul class="links">
					<li><a href="#0">Doctors</a></li>
					<li><a href="#0">Clinics</a></li>
					<li><a href="#0">Specialization</a></li>
					<li><a href="#0">Join as a Doctor</a></li>
					<li><a href="#0">Download App</a></li>
				</ul>
			</div>
			<div class="col-lg-3 col-md-4">
				<h5>Contact with Us</h5>
				<ul class="contacts">
					<li><a href="tel://61280932400"><i class="icon_mobile"></i> + 61 23 8093 3400</a></li>
					<li><a href="mailto:info@findoctor.com"><i class="icon_mail_alt"></i> help@findoctor.com</a></li>
				</ul>
				<div class="follow_us">
					<h5>Follow us</h5>
					<ul>
						<li><a href="#0"><i class="social_facebook"></i></a></li>
						<li><a href="#0"><i class="social_twitter"></i></a></li>
						<li><a href="#0"><i class="social_linkedin"></i></a></li>
						<li><a href="#0"><i class="social_instagram"></i></a></li>
					</ul>
				</div>
			</div>
		</div>
		<!--/row-->
		<hr>
		<div class="row">
			<div class="col-md-8">
				<ul id="additional_links">
					<li><a href="#0">Terms and conditions</a></li>
					<li><a href="#0">Privacy</a></li>
				</ul>
			</div>
			<div class="col-md-4">
				<div id="copy">© 2017 Findoctor</div>
			</div>
		</div>
	</div>
</footer>
<!--/footer-->

<div id="toTop"></div>
<!-- Back to top button -->

<!-- COMMON SCRIPTS -->
<script src="{{asset('assets/frontassets/js/jquery-2.2.4.min.js')}}"></script>
<script src="{{asset('assets/frontassets/js/common_scripts.min.js')}}"></script>
<script src="{{asset('assets/frontassets/js/functions.js')}}"></script>
<script src="{{asset('assets/plugins/momentjs/moment.js')}}"></script>

<script type="text/javascript">
	var search_url = "{{route('searchDoc')}}";
	var disponibilite_medecin = "{{route('disponibiliteMedecin')}}";
	var session_rdv = "{{route('session_rendervous')}}";
	var complete_doc = "{{route('complete.doc')}}";
		
	var today = moment().format("YYYY-MM-DD");

	console.log(moment().format('dddd'));

	var app = angular.module('myApp', []);

	@if(Session::has('medecin') && Session::has('date') && Auth::user()->role == 'patient')
		$('#modalLoggedPatient').modal();
	@endif

	@if(Session::has('status'))
		alert("Rendez-vous Pris !!");
	@endif

	app.factory('DisponibiliteFact',['$http','$q',function ($http,$q) {
		var factory = {
			getDisp : function(id,date) {
				var req = {
					method : 'GET',
					async : true,
					url : disponibilite_medecin,
					headers : {'Content-Type' : 'application/json'},
					params : {id:id,date:date}
				};
				var df = $q.defer();

				$http(req).then(function successCallback(data) {
						df.resolve(data)
					},
					function errorCallback(data) {
						// body...
					}
				);
				return df.promise;
			}
		};
		return factory;
	}]);

	app.config(function($interpolateProvider) {
		$interpolateProvider.startSymbol('[[');
		$interpolateProvider.endSymbol(']]');
	});
</script>

@yield('scripts')

</body>

</html>