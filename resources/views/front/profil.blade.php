@extends('front.frontapp')

@section('head')
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
<div ng-controller="profilController">
<!-- Start Main Profil -->
<main>
	<div id="breadcrumb">
		<div class="container">
			<div class="row">
				<div class="col-md-6">
					<ul>
						<li><a href="{{route('search')}}">Accueil</a></li>
						<li>Profil du medecin</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<!-- /breadcrumb -->

	<div class="container margin_60">
		<div class="row">
			<div class="col-xl-8 col-lg-8">
				<nav id="secondary_nav">
					<div class="container">
						<ul class="clearfix">
							<li><a href="#section_1" class="active">Info General</a></li>
							<li><a href="#section_2">Reviews</a></li>
							<li><a href="#sidebar">Booking</a></li>
						</ul>
					</div>
				</nav>
				<div id="section_1">
					<div class="box_general_3">
						<div class="profile">
							<div class="row">
								<div class="col-lg-5 col-md-4">
									<figure>
										<img src="{{asset('/assets/images/'.$medecin->image)}}" alt="" class="img-fluid">
									</figure>
								</div>
								<div class="col-lg-7 col-md-8">
									<small>{{$medecin->specialite->libelle}}</small>
									<h1>Dr. {{$medecin->nom.' '.$medecin->prenom}}</h1>
									<span class="rating">
										<i class="icon_star voted"></i>
										<i class="icon_star voted"></i>
										<i class="icon_star voted"></i>
										<i class="icon_star voted"></i>
										<i class="icon_star"></i>
										<small>(145)</small>
										<!-- <a href="badges.html" data-toggle="tooltip" data-placement="top" data-original-title="Badge Level" class="badge_list_1"><img src="img/badges/badge_1.svg" width="15" height="15" alt=""></a> -->
									</span>
									<ul class="statistic">
										<li>854 Views</li>
										<li>124 Patients</li>
									</ul>
									<ul class="contacts">
										<li>
											<h6>Address</h6>
											{{$medecin->adresse}}
											<a href="https://www.google.com/maps/search/?api=1&query={{$medecin->latitude.','.$medecin->longitude}}" target="_blank"> <strong>View on map</strong></a>
										</li>
										<li>
											<h6>Phone</h6> <a href="tel://{{$medecin->telephone}}">
												{{$medecin->telephone}}
											</a>
										</li>
									</ul>
								</div>
							</div>
						</div>
						
						<hr>
						
						<!-- /profile -->
						<div class="indent_title_in">
							<i class="pe-7s-user"></i>
							<h3>Présentation du Cabinet</h3>
						</div>
						<div class="wrapper_indent">
							<p>{{$medecin->bio}}</p>
							<h6>Specializations</h6>
							<div class="row">
								<div class="col-lg-6">
									<ul class="bullets">
										@foreach($medecin->experties as $exp)
										<li>{{$exp->libelle}}</li>
										@endforeach
									</ul>
								</div>
							</div>
							<!-- /row-->
						</div>
						<!-- /wrapper indent -->

						<hr>

						<div class="indent_title_in">
							<i class="pe-7s-news-paper"></i>
							<h3>Education</h3>
						</div>
						<div class="wrapper_indent">
							<ul class="list_edu">
								@foreach($medecin->formations as $formation)
								<li>
									<strong>{{date('Y',strtotime($formation->datedebut))}} - {{date('Y',strtotime($formation->datefin))}}</strong> : {{$formation->libelle}}
								</li>
								@endforeach
							</ul>
						</div>
						<!--  End wrapper indent -->

						<hr>
					</div>
					<!-- /section_1 -->
				</div>
				<!-- /box_general -->

				<div id="section_2">
					<div class="box_general_3">
						<div class="reviews-container">
						{{--	<!--  Rating div -->
							 <div class="row">
								<div class="col-lg-3">
									<div id="review_summary">
										<strong>4.7</strong>
										<div class="rating">
											<i class="icon_star voted"></i><i class="icon_star voted"></i><i class="icon_star voted"></i><i class="icon_star voted"></i><i class="icon_star"></i>
										</div>
										<small>Based on 4 reviews</small>
									</div>
								</div>
								<div class="col-lg-9">
									<div class="row">
										<div class="col-lg-10 col-9">
											<div class="progress">
												<div class="progress-bar" role="progressbar" style="width: 90%" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"></div>
											</div>
										</div>
										<div class="col-lg-2 col-3"><small><strong>5 stars</strong></small></div>
									</div>
									<!-- /row -->
									<div class="row">
										<div class="col-lg-10 col-9">
											<div class="progress">
												<div class="progress-bar" role="progressbar" style="width: 95%" aria-valuenow="95" aria-valuemin="0" aria-valuemax="100"></div>
											</div>
										</div>
										<div class="col-lg-2 col-3"><small><strong>4 stars</strong></small></div>
									</div>
									<!-- /row -->
									<div class="row">
										<div class="col-lg-10 col-9">
											<div class="progress">
												<div class="progress-bar" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
											</div>
										</div>
										<div class="col-lg-2 col-3"><small><strong>3 stars</strong></small></div>
									</div>
									<!-- /row -->
									<div class="row">
										<div class="col-lg-10 col-9">
											<div class="progress">
												<div class="progress-bar" role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
											</div>
										</div>
										<div class="col-lg-2 col-3"><small><strong>2 stars</strong></small></div>
									</div>
									<!-- /row -->
									<div class="row">
										<div class="col-lg-10 col-9">
											<div class="progress">
												<div class="progress-bar" role="progressbar" style="width: 0" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
											</div>
										</div>
										<div class="col-lg-2 col-3"><small><strong>1 stars</strong></small></div>
									</div>
									<!-- /row -->
								</div>
							</div>
							<hr>
							<!-- /row --> --}}

							<div id="comment-section">
							<p>Commentaires:</p>
								@foreach($medecin->commentaires as $commentaire)
								<div class="review-box commentaire-box clearfix" id="comment_{{$commentaire->id}}">
									@if(Auth::check() && Auth::user()->role == 'admin')
									<a href="#0" style="float: right;overflow: hidden;position: relative;z-index: 10;" onclick="deleteComment({{$commentaire->id}})">
										<i class="icon-cancel"></i>
									</a>
									@endif
									<figure class="rev-thumb"><img src="http://via.placeholder.com/150x150.jpg" alt="">
									</figure>
										
									<div class="rev-content">
										<div class="rating">
											<i class="icon_star voted"></i><i class="icon_star voted"></i><i class="icon_star voted"></i><i class="icon_star voted"></i><i class="icon_star"></i>
										</div>
										<div class="rev-info">
											{{$commentaire->patient->nom.' '.$commentaire->patient->prenom}} – {{$commentaire->date}}:
										</div>
										<div class="rev-text">
											<p>
												{{$commentaire->texte}}
											</p>
										</div>
									</div>
								</div>
								@endforeach
							</div>
							@if(Auth::check() && Auth::user()->role =='patient')
							<!-- start post a comment form -->
							<div class="review-box clearfix">
								<p>Votre avis sur ce medecin :</p>
								<form id="formComment" method="POST">
									<input type="hidden" name="patient" id="patientid" value="{{Auth::user()->patients[0]->id}}">
									<input type="hidden" name="medecin" value="{{$medecin->id}}">
									<textarea id="commentText" class="form-group col-md-12" name="texte" required></textarea>
									<button type="submit" class="btn_1">Ajouter</button>
								</form>
							</div>
							<!-- End post a comment form -->
							@elseif(!Auth::check())
							<div class="review-box clearfix">
								<a href="{{route('login')}}" class="btn_1 center" style="width: 50%;margin-left: 20%">
									<center>Se connecter</center>
								</a>
							</div>
							@endif
						</div>
						<!-- End review-container -->
					</div>
				</div>
				<!-- /section_2 -->
			</div>
			<!-- /col -->
			<aside class="col-xl-4 col-lg-4" id="sidebar">
				<div class="box_general_3 booking">
					<table class="table">
						<thead>
							<tr>
								<th>
								<p>
								<a href="#" ng-click="prev_dates_profil()"><i class="icon-left-open"></i></a>
								<span class="nom-jour">[[medecin.jours.jour1.jour]]</span>
								</p>
								<p class="date-jour">[[medecin.jours.jour1.mois]]</p>
								</th>
								<th>
								<p class="nom-jour">[[medecin.jours.jour2.jour]]</p>
								<p class="date-jour">[[medecin.jours.jour2.mois]]</p>
								</th>
								<th>
								<p>
								<span class="nom-jour">[[medecin.jours.jour3.jour]]</span>
								<a href="#" ng-click="next_dates_profil()"><i class="icon-right-open"></i></a>
								</p>
								<p class="date-jour">[[medecin.jours.jour3.mois]]</p>
								</th>
							</tr>
						</thead>
						<tbody>
							<tr ng-repeat="x in medecin.disponibilite" ng-if="medecin.active == '1'">
								<td><button ng-click="modalBookProfil(medecin.medecin.id,x.jour1)" data-toggle="modal" data-target="#myModal" class="btn btn_hours form-control" ng-if="x.jour1 != null" value="[[x.jour1]]">[[x.jour1|date:'HH:mm']]</button></td>
								<td><button ng-click="modalBookProfil(medecin.medecin.id,x.jour2)" data-toggle="modal" data-target="#myModal" class="btn btn_hours form-control" ng-if="x.jour2 != null" value="[[x.jour2]]">[[x.jour2|date:'HH:mm']]</button></td>
								<td><button ng-click="modalBookProfil(medecin.medecin.id,x.jour3)" data-toggle="modal" data-target="#myModal" class="btn btn_hours form-control" ng-if="x.jour3 != null" value="[[x.jour3]]">[[x.jour3|date:'HH:mm']]</button></td>
							</tr>
							<tr ng-if="medecin.active != '1'">
								<td colspan="3">
									<div>
										<center class="not-active-doc">
										<p>Pas de rendez-vous disponible en ligne.</p>
										<p>Contacter le medecin :</p>
										<a href="tel://[[medecin.medecin.telephone]]">
											[[medecin.medecin.telephone]]
										</a>
										</center>
									</div>
								</td>
							</tr>
							<tr ng-if="medecin.dispoAtThis != ''">
								<td colspan="3">
									<center class="proch-rv-dispo">
									<p>Prochain Rendez-vous :
										<a href="#0" ng-click="goToThisDate()">
											<i class="icon-right-open-big"></i>
										</a>
									</p>
									</center>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
				<!-- /box_general -->
			</aside>
			<!-- /asdide -->
		</div>
		<!-- /row -->
	</div>
	<!-- /container -->
</main>
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
					<input type="hidden" name="medecin" value="{{$medecin->id}}">
					<input type="hidden" name="date" value="[[daterendezvous]]">
					<input type="hidden" name="patient" value="{{Auth::user()->patients[0]->id}}">
					<div class="row">
						<div class="col-md-6 ">
							<div class="form-group">
								<label class="label-control">Rendez-vous avec Dr. {{$medecin->nom.' '.$medecin->prenom}}</label>
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
									@foreach($medecin->experties as $exp)
									<option value="{{$exp->libelle}}">{{$exp->libelle}}</option>
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
					<input type="hidden" name="medecin" value="{{$medecin->id}}">
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
								<label class="label-control">Rendez-vous avec Dr. {{$medecin->nom.' '.$medecin->prenom}}</label>
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
									@foreach($medecin->experties as $exp)
									<option value="{{$exp->libelle}}">{{$exp->libelle}}</option>
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
									@foreach($medecin->experties as $exp)
									<option value="{{$exp->libelle}}">{{$exp->libelle}}</option>
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

</div>
@endsection

@section('scripts')
	<script type="text/javascript">
		app.controller('profilController',function ($scope,$http,DisponibiliteFact) {
			//get disponibilite de ce medecin
			$scope.getDisponibiliteMed = function () {
				DisponibiliteFact.getDisp({{$medecin->id}},today).then(
					function (result) {
						$scope.medecin = result.data;
						console.log(result.data);
					},function (message) {
						alert(message);
					}
				);
			}
			$scope.getDisponibiliteMed();


			$scope.next_dates_profil = function () { //prochaine dates du calendrier
				var x = moment($scope.medecin.date,['YYYY-MM-DD']);
				x.add(3,'days');
				var z = x.format('YYYY-MM-DD');
				console.log(z);

				DisponibiliteFact.getDisp({{$medecin->id}},z).then(
					function (result) {
						console.log(result.data);
						$scope.medecin = result.data;
					},function (message) {
						alert(message);
					}
				);
			}
			$scope.prev_dates_profil = function () { //dates precedente du calendrier
				var datediff = moment(today).diff(moment($scope.medecin.date,['YYYY-MM-DD']),'days');
				if(datediff < 0){
					var x = moment($scope.medecin.date,['YYYY-MM-DD']);
					x.subtract(3,'days');
					var z = x.format('YYYY-MM-DD');
					console.log(z);
					DisponibiliteFact.getDisp({{$medecin->id}},z).then(
						function (result) {
							console.log(result.data);
							$scope.medecin = result.data;
						},function (message) {
							alert(message);
						}
					);
				}
			}

			$scope.modalBookProfil = function (id,date) { //modal prendre rendez vous
				$scope.id_medecin = id;
				$scope.daterendezvous = date;
				$scope.date_du_rendezvous = moment(date).format('[Le] DD-MM-YYYY [à] HH:mm');
				console.log(id,date);
			}

			$scope.preLog = function () { //add medecin et date au session avant login
				$http({
					method : 'GET',
					async : true,
					url : session_rdv,
					headers : {'Content-Type' : 'application/json'},
					params : {id: {{$medecin->id}} ,date:$scope.daterendezvous}
				}).then(function (response) {
					console.log(response.data);
				});
			}

			$scope.goToThisDate = function () {	//Allez à prochaine date dispo dans le calendrier
				DisponibiliteFact.getDisp({{$medecin->id}},$scope.medecin.dispoAtThis).then(
					function (result) {
						$scope.medecin = result.data;
					},function (message) {
						alert(message);
					}
				);
			}

		});
	</script>
	<script type="text/javascript">
		$('#formComment').submit(function (e) {
			e.preventDefault();
			$.ajax({url: "{{route('commentaire.store')}}",
                dataType: 'json',
                contentType: 'application/json',
                async: true,
                data:{
                	texte:$('#commentText').val(),
                	medecin:{{$medecin->id}},
                	patient:$('#patientid').val()
                },
                success:function(data) {
                    console.log(data);
           			if(data.status = 'ok'){
	                    var comment='<div class="review-box commentaire-box clearfix">'
										+'<figure class="rev-thumb"><img src="http://via.placeholder.com/150x150.jpg" alt="">'
										+'</figure>'
										+'<div class="rev-content">'
											+'<div class="rating">'
												+'<i class="icon_star voted"></i><i class="icon_star voted"></i><i class="icon_star voted"></i><i class="icon_star voted"></i><i class="icon_star"></i>'
											+'</div>'
											+'<div class="rev-info">'+
												data.patient+' – '+data.data.date+':'
											+'</div>'
											+'<div class="rev-text">'
												+'<p>'+data.data.texte+'</p>'
											+'</div>'
										+'</div>'
									+'</div>';
						$('#comment-section').fadeIn('slow',function () {
							$(this).append(comment)
						});
						$('#commentText').val('');
					}else{
						alert('error');
					}
                }
            });
		});

		function deleteComment(id) {
  			if(confirm('Supprimer ce commentaire ?')){
  				$.ajax({url: "{{route('commentaire.delete')}}",
	                dataType: 'json',
	                contentType: 'application/json',
	                async: true,
	                data:{id:id},
	                success:function(data) {
	                    console.log(data);
	           			if(data.status == 'ok'){
							$("#comment_"+id).fadeOut("slow", function() {
								$(this).remove();
							});
						}else{
							alert('error');
						}
	                }
	            });
  			}
		}
		
	</script>
@endsection