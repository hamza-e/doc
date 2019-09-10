@extends('front.frontapp')

@section('head')
	<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyA5iaeY9U7Ff1Yberkg15ztGOq7wDD7zu4&libraries=places"></script>
	<style type="text/css">
		.table thead th {
			border-bottom: 0px;
		}
		.table td, .table th {
			border-top: 1px;
			padding: 0;
		}
		.table td .btn_hours{
			width: 98%;
			display: block;
		}
		.nom-jour {
			text-align: center;
		}
		.date-jour {
			font-size: 11px;
			text-align: center;
		}
		.btn_hours, .btn_show_more{
			margin-top: 4px;
			margin-left: 1px;
		}
		.btn_show_more{width: 99%}

		.proch-rv-dispo{
			background-color: #3f40791c;
			padding-top: 30px;
			padding-bottom: 20px;
			border-radius: 10px;
		}
		.not-active-doc{
			background-color: #3f40791c;
			border-radius: 10px;
			padding-top: 6px;
			padding-bottom: 5px;
		}
	</style>
@endsection

@section('content')    

<div ng-controller="myCtrl">
<!-- Start Main Home  -->
	<main ng-show="to_hide_div">
		<div class="hero_home version_1">
			<div class="content">
				<h3>Find a Doctor!</h3>
				<p>
					Ridiculus sociosqu cursus neque cursus curae ante scelerisque vehicula.
				</p>
				<div id="custom-search-input">
					<div class="input-group">
						<input type="text" ng-model="q" class="search-query" name="q" placeholder="Ex. Nom, Specialité ...." list="specialiteList" ng-keyup="autoCompleteDoc()">
						<input id="searchTextField" ng-model="location" type="text" name="location" name="ville" class="search-query">
						<input id="seachbutton" type="submit" class="btn_search" value="Search" ng-click="search()">
						<button ng-click="getLocation()">my location</button>
					</div>
				</div>
			</div>
		</div>


		<!-- Start Search area -->

		<!-- /Hero -->
		<div class="container margin_120_95">
			<div class="main_title">
				<h2>Discover the <strong>online</strong> appointment!</h2>
				<p>Usu habeo equidem sanctus no. Suas summo id sed, erat erant oporteat cu pri. In eum omnes molestie. Sed ad debet scaevola, ne mel.</p>
			</div>
			<div class="row add_bottom_30">
				<div class="col-lg-4">
					<div class="box_feat" id="icon_1">
						<span></span>
						<h3>Find a Doctor</h3>
						<p>Usu habeo equidem sanctus no. Suas summo id sed, erat erant oporteat cu pri. In eum omnes molestie.</p>
					</div>
				</div>
				<div class="col-lg-4">
					<div class="box_feat" id="icon_2">
						<span></span>
						<h3>View profile</h3>
						<p>Usu habeo equidem sanctus no. Suas summo id sed, erat erant oporteat cu pri. In eum omnes molestie.</p>
					</div>
				</div>
				<div class="col-lg-4">
					<div class="box_feat" id="icon_3">
						<h3>Book a visit</h3>
						<p>Usu habeo equidem sanctus no. Suas summo id sed, erat erant oporteat cu pri. In eum omnes molestie.</p>
					</div>
				</div>
			</div>
			<!-- /row -->
			<p class="text-center"><a href="list.html" class="btn_1 medium">Find Doctor</a></p>

		</div>
		<!-- /container -->
	</main>
	<!-- /main content -->

	<!-- End Main Home  -->


	<!-- Start Main Search  -->

	<main ng-show="searchArea">
		<div id="results">
			<div class="container">
				<div class="row">
					<div class="col-md-6">
						<h4></h4>
					</div>
					<div class="col-md-6">
						<div id="#custom-search-input" class="search_bar_list">
							<input ng-model="q" type="text" class="search-query col-md-6" placeholder="Ex. Specialist, Name, Doctor..." list="specialiteList" ng-keyup="autoCompleteDoc()">
							<input id="searchTextField2" ng-model="location" type="text" name="location" name="ville" class="search-query col-md-5" >
							<input id="seachbutton" type="submit" class="btn_search" value="Search" ng-click="search()">
						</div>
					</div>
				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
		<!-- /results -->

		<div class="filters_listing">
			<div class="container">
				<ul class="clearfix">
					<li>
						<h6>Filtres:</h6>
						<select name="orderby" class="form-control" ng-model="docSort" ng-change="filterDocs()">
							<option value="0">Tous</option>
							<option value="1">Distance</option>
							<!-- <option value="2">Best rated</option> -->
							<option value="3">Homme</option>
							<option value="4">Femme</option>
						</select>
					</li>
				</ul>
			</div>
			<!-- /container -->
		</div>
		<!-- /filters -->
		
		<div class="container margin_60_35">
			<div class="row">
				<div class="col-lg-7">

					<div class="strip_list wow fadeIn" ng-repeat="m in medecins" ng-init="indexofloop = $index">
						<figure>
							<a ng-click="showProfil([[$index]])" href="{{url('')}}/medecin/[[m.medecin.id+'/'+m.specialite+'/'+m.medecin.city+'/'+m.medecin.nom+'-'+m.medecin.prenom]]">
							<img ng-src="{{asset('/assets/images')}}[['/'+m.medecin.image]]" alt="">
							</a>
						</figure>
						<div class="col-md-12">
							<div class="row clearfix">
								<div class="col-lg-5">
									<small>[[m.specialite]]</small>
									<a href="{{url('')}}/medecin/[[m.medecin.id+'/'+m.specialite+'/'+m.medecin.city+'/'+m.medecin.nom+'-'+m.medecin.prenom]]">
										<h3>Dr.  [[m.medecin.nom ]]  [[m.medecin.prenom]] </h3>
									</a>
									<p>[[m.medecin.adresse]]</p>
									<span class="rating"><i class="icon_star voted"></i><i class="icon_star voted"></i><i class="icon_star voted"></i><i class="icon_star"></i><i class="icon_star"></i> <small>(145)</small></span>
									<!-- <a href="badges.html" data-toggle="tooltip" data-placement="top" data-original-title="Badge Level" class="badge_list_1"><img src="img/badges/badge_1.svg" width="15" height="15" alt=""></a> -->
								</div>
								<div class="col-lg-7">
									<table class="table">
										<thead>
											<tr>
												<th>
												<p>
												<a href="#/" ng-click="prev_dates($index)"><i class="icon-left-open"></i></a>
												<span class="nom-jour">[[m.jours.jour1.jour]]</span>
												</p>
												<p class="date-jour">[[m.jours.jour1.mois]]</p>
												</th>
												<th>
												<p class="nom-jour">[[m.jours.jour2.jour]]</p>
												<p class="date-jour">[[m.jours.jour2.mois]]</p>
												</th>
												<th>
												<p>
												<span class="nom-jour">[[m.jours.jour3.jour]]</span>
												<a href="#/" ng-click="next_dates($index)"><i class="icon-right-open"></i></a>
												</p>
												<p class="date-jour">[[m.jours.jour3.mois]]</p>
												</th>
											</tr>
										</thead>
										<tbody>
											<tr ng-repeat="x in m.disponibilite" ng-show="$index < 4 || m.display_more_dispo" ng-if="m.active == '1'">
												<td>
													<button ng-click="modalBook(m.medecin.id,x.jour1,indexofloop)" data-toggle="modal" data-target="#myModal" class="btn btn_hours form-control" ng-if="x.jour1 != null && (now|date:'yyyy-MM-dd HH:mm') < (x.jour1|date:'yyyy-MM-dd HH:mm')" value="[[x.jour1]]">[[x.jour1|date:'HH:mm']]</button>
												</td>
												<td>
													<button ng-click="modalBook(m.medecin.id,x.jour2,indexofloop)" data-toggle="modal" data-target="#myModal" class="btn btn_hours form-control" ng-if="x.jour2 != null" value="[[x.jour2]]">[[x.jour2|date:'HH:mm']]</button>
												</td>
												<td>
													<button ng-click="modalBook(m.medecin.id,x.jour3,indexofloop)" data-toggle="modal" data-target="#myModal" class="btn btn_hours form-control" ng-if="x.jour3 != null" value="[[x.jour3]]">[[x.jour3|date:'HH:mm']]</button>
												</td>
											</tr>
											<tr ng-if="m.dispoAtThis != ''">
												<td colspan="3">
													<center class="proch-rv-dispo">
													<p>Prochain Rendez-vous :
														<a href="#0" ng-click="goToThisDate($index)">
															<i class="icon-right-open-big"></i>
														</a>
													</p>
													</center>
												</td>
											</tr>
											<tr style="margin-top: 5" ng-if="m.active == '1'">
												<td colspan="3">
													<button class="btn center-block btn_show_more form-control" ng-click="show_more($index);hideme=true" ng-hide="hideme" ng-if="m.disponibilite.length > 0">Afficher la suite</button>
												</td>
											</tr>
											<tr ng-if="m.active != '1'">
												<td colspan="3">
													<div>
														<center class="not-active-doc">
														<p>Pas de rendez-vous disponible en ligne.</p>
														<p>Contacter le medecin :</p>
														<a href="tel://[[m.medecin.telephone]]">
															[[m.medecin.telephone]]
														</a>
														</center>
													</div>
												</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
						<ul>
							<li><a href="#0" ng-click="onHtmlClick('Doctors', $index)" class="btn_listing">View on Map</a></li>
							<li><a href="https://www.google.com/maps/search/?api=1&query=[[m.medecin.latitude]],[[m.medecin.longitude]]" target="_blank">[[m.distance | number:0]] m</a></li>
							<li><a href="{{url('')}}/medecin/[[m.medecin.id+'/'+m.specialite+'/'+m.medecin.city+'/'+m.medecin.nom+'-'+m.medecin.prenom]]">Prendre un rendez-vous</a></li>
						</ul>
					</div>
					<!-- /strip_list -->

					
					<nav aria-label="" class="add_top_20">
						<ul class="pagination pagination-sm">
							<li class="page-item disabled">
								<a class="page-link" href="#" tabindex="-1">Previous</a>
							</li>
							<li class="page-item active"><a class="page-link" href="#">1</a></li>
							<li class="page-item"><a class="page-link" href="#">2</a></li>
							<li class="page-item"><a class="page-link" href="#">3</a></li>
							<li class="page-item">
								<a class="page-link" href="#">Next</a>
							</li>
						</ul>
					</nav>
					<!-- /pagination -->
				</div>
				<!-- /col -->
				
				<aside class="col-lg-5" id="sidebar">
					<div id="map_listing" class="normal_list">
					</div>
				</aside>
				<!-- /aside -->
				
			</div>
			<!-- /row -->
		</div>
		<!-- /container -->
	</main>
	<!-- /main -->
<!-- End Main Search  -->


<datalist id="specialiteList">
	@foreach($specialite as $sp)
		<option value="{{$sp->libelle}}"></option>
	@endforeach
	<hr>
	<option ng-repeat="x in completeDocs" value="[[x.nom+' '+x.prenom]]"></option>
</datalist>

@if(Auth::check() && Auth::user()->role == 'patient')

<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<form method="POST" action="{{route('store.patient.front')}}">
				<div class="modal-header">
					<h4 class="modal-title">Prendre Un rendez-vous</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					@csrf
					<input type="hidden" name="medecin" value="[[id_medecin]]">
					<input type="hidden" name="date" value="[[daterendezvous]]">
					<input type="hidden" name="patient" value="{{Auth::user()->patients[0]->id}}">
					<div class="row">
						<div class="col-md-6 ">
							<div class="form-group">
								<label class="label-control">Rendez-vous avec Dr. [[nom_du_medecin]]</label>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label class="label-control">[[date_du_rendezvous]]</label>
							</div>
						</div>
					</div>					
					<hr>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<select class="form-control" name="motif" required>
									<option value="">--Motif--</option>
									<option ng-repeat="x in experties" value="[[x.libelle]]">[[x.libelle]]</option>
									<option value="Consultation">Consultation</option>
								</select>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn_1">Prendre</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</form>
		</div>
	</div>
</div>

@else
<!--  -->

<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<form method="POST" action="{{route('prendre_rendez_vous')}}">
				<div class="modal-header">
					<h4 class="modal-title">Prendre Un rendez-vous</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					@csrf
					<input type="hidden" name="medecin" value="[[id_medecin]]">
					<input type="hidden" name="date" value="[[daterendezvous]]">
					<div class="row">
						<div class="col-md-12">
							<a href="{{route('login')}}" class="btn_1" style="width: 100%" ng-click="preLog()"><center>J'ai déja un compte</center></a>
						</div>
					</div>
					<hr>
					<div class="row">
						<div class="col-md-6 ">
							<div class="form-group">
								<label class="label-control">Rendez-vous avec Dr. [[nom_du_medecin]]</label>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label class="label-control">[[date_du_rendezvous]]</label>
							</div>
						</div>
					</div>
					<hr>
					<div class="row">
						<div class="col-md-6 ">
							<div class="form-group">
								<input type="text" class="form-control" placeholder="Nom ..." name="nom" required>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<input type="text" class="form-control" placeholder="Prenom ..." name="prenom" required>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6 ">
							<div class="form-group">
								<input type="email" class="form-control" placeholder="Email ..." name="email" required>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<input type="password" class="form-control" placeholder="Mot de Passe ..." name="password" required>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<input type="text" class="form-control" placeholder="Telephone ..." name="telephone" required>
							</div>
						</div>
						<div class="col-md-6 ">
							<div class="form-group">
								<input type="number" class="form-control" placeholder="Age ..." name="age" required>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<select name="sexe" class="form-control" required>
									<option value="">--Sexe--</option>
									<option value="Homme">Homme</option>
									<option value="Femme">Femme</option>
								</select>
							</div>
						</div>
					</div>
					<hr>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<select class="form-control" name="motif" required>
									<option value="">--Motif--</option>
									<option ng-repeat="x in experties" value="[[x.libelle]]">[[x.libelle]]</option>
									<option value="Consultation">Consultation</option>
								</select>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn_1">Prendre</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</form>
		</div>
	</div>
</div>
@endif
<!--  -->



@if(Session::has('medecin') && Session::has('date') && Auth::user()->role == 'patient')
<!-- Modal -->
<div class="modal fade" id="modalLoggedPatient" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<form method="POST" action="{{route('store.patient.front')}}">
				<div class="modal-header">
					<h4 class="modal-title">Prendre Un rendez-vous</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					@csrf
					<input type="hidden" name="medecin" value="{{Session::get('medecin')}}">
					<input type="hidden" name="date" value="{{Session::get('date')}}">
					<input type="hidden" name="patient" value="{{Auth::user()->patients[0]->id}}">
					<div class="row">
						<div class="col-md-6 ">
							<div class="form-group">
								<label class="label-control">Rendez-vous avec Dr. {{Session::get('medecin_nom')}}</label>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label class="label-control">{{date('\L\e d-m-Y \à H:s',strtotime(Session::get('date')))}}</label>
							</div>
						</div>
					</div>
					<hr>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<select class="form-control" name="motif" required>
									<option value="">--Motif--</option>
									@foreach(Session::get('experties') as $expertie)
									<option value="{{$expertie->libelle}}">{{$expertie->libelle}}</option>
									@endforeach
									<option value="Consultation">Consultation</option>
								</select>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn_1">Prendre</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</form>
		</div>
	</div>
</div>
@endif
<!-- End Main Profil -->
</div>



@endsection

@section('scripts')

<script type="text/javascript">
	var geocoder =  new google.maps.Geocoder();
	// $('#seachbutton').click(function () {
	// 	console.log($('#searchTextField').val());
	// 	geocoder.geocode({ 'address': "marrakech"}, function(results, status) {
	// 		if (status == google.maps.GeocoderStatus.OK) {
 //            console.log("location : " + results[0].geometry.location.lat() + " " +results[0].geometry.location.lng());

	// 			console.log(results[0].address_components[0].long_name);
	// 			// console.log(getDistance(31.633186, -8.009026, 31.634288, -8.011129));
	// 		} else {
	// 			console.log("Something got wrong " + status);
	// 		}
 //        });
	// });

	var rad = function(x) {
		return x * Math.PI / 180;
	};
	//pour calculer la distance entre deux position
	var getDistance = function(p1_lat,p1_lng , p2_lat,p2_lng) { 
		var R = 6378137;
		var dLat = rad(p2_lat - p1_lat);
		var dLong = rad(p2_lng - p1_lng);
		var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
		Math.cos(rad(p1_lat)) * Math.cos(rad(p2_lat)) *
		Math.sin(dLong / 2) * Math.sin(dLong / 2);
		var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
		var d = R * c;
		return d;
	};

</script>

<script src="{{asset('assets/frontassets/js/med_app.js')}}"></script>
<script src="{{asset('assets/frontassets/js/infobox.js')}}"></script>

@endsection