@extends('layouts.app')

@section('head')
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/datatables/dataTables.min.css') }}">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
	<style type="text/css">
		.modal-backdrop.show{ display: none; }
		.pull-right{ float: right; }
	</style>
@endsection

@section('content')
<section class="content profile-page">
	<div class="container-fluid">
		<div class="row clearfix">
			<div class="col-md-12 p-l-0 p-r-0">
				<section class="boxs-simple">
					<div class="profile-header">
                        <div class="profile_info">
                            <div class="profile-image"> <img src="{{ asset('assets/images/patients/random-avatar1.jpg') }}" alt=""> </div>
                            <h4 class="mb-0"><strong>{{ $patient->sexe == "Homme" ? "Mr.":"Mme" }} {{ $patient->nom }}</strong> {{ $patient->prenom }}</h4>
                            <span class="text-muted col-white">{{' '}}</span>
                            <div class="mt-10">
                                <a href="{{ route('patients.edit', ['patient' => $patient->id ]) }}" class="btn btn-raised btn-default bg-blush btn-sm">Edit</a>
                            </div>
                        </div>
                    </div>
				</section>
			</div>
		</div>

		@include('layouts.inc.message')

		<div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="body">
                    	<div class="block-header">
							<h1>Liste Visites</h1>
                			<a class="pull-right btn btn-raised btn-info waves-effect" data-toggle="modal" data-target="#myModalAdd">Nouvelle Visite &nbsp;&nbsp;<i class="far fa-plus-square"></i></a>
						</div>
						<div class="col-md-4">
							<div class="form-group">
				                <div class="form-line">
				                    <input id="date_visite" type="date" name="date" class="form-control" placeholder="Durée de rendez-vous">
				                </div>
				            </div>
				        </div>
                        <div class="table-responsive">
                          	<table id="table_visite" class="table table-striped table-bordered table-hover">
                            	<thead class="thead-dark">
                              		<tr>
	                                    <th>#</th>
	                                    <th>Date</th>
	                                    <th>Diagnostic</th>
	                                    <th>Actions</th>
                              		</tr>
                                </thead>
                                <tbody>
                                	@foreach ($visites as $visite)
                                  		<tr>
		                                    <td>{{ $loop->index+1 }}</td>
		                                    <td>{{ $visite->date }}</td>
		                                    <td>
		                                    	{{ $visite->maladie != null ? $visite->maladie->libelle:'Autre' }}
		                                    </td>
		                                    <td>
		                                    	<a href="#" data-toggle="modal" data-target="#myModalEdit"><i class="far fa-edit" onclick="editVisite({{$visite->id}})"></i></a>
		                                    	<a href="#" data-toggle="modal" data-target="#myModalVisite{{ $visite->id }}"><i class="far fa-eye"></i></a>
		                                    	<!-- modal Visite info -->
												<div id="myModalVisite{{ $visite->id }}" class="modal fade" role="dialog">
													<div class="modal-dialog modal-lg">
													    <div class="modal-content">
													    	<div class="modal-header">
																<button type="button" class="close" data-dismiss="modal">&times;</button>
																<h4 class="modal-title">Visite Informations </h4>
															</div>
															<div class="modal-body">
																<div class="row clearfix">
													        		<b>Nom du patient : </b> {{ $patient->nom.' '.$patient->prenom}}
																</div>
																<div class="row clearfix">
													        		<b>Age : </b> {{ $patient->age}}
																</div>
																<div class="row clearfix">
													        		<b>Sexe : </b> {{ $patient->sexe}}
																</div>
																<div class="row clearfix">
													        		<b>Date Visite : </b> {{ $visite->date}}
																</div>
																<div class="row clearfix">
													        		<b>Diagnostic : </b> {{ $visite->maladie != null ? $visite->maladie->libelle:'Autre' }}
																</div>
																<div class="row clearfix">
													        		<b>Note : </b> {{ $visite->note}}
																</div>
															</div>
															<div class="modal-footer">
										                    	<button type="submit" class="btn btn-danger" style="color: #000;">Imprimer</button>
													        	<button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
															</div>
													    </div>
													</div>
												</div>

		                                    	<a style="color:red;" href="#" data-toggle="modal" data-target="#myModal{{ $visite->id }}"><i class="far fa-trash-alt"></i></a>

		                                    	<!-- modal delete -->
												<div id="myModal{{ $visite->id }}" class="modal fade" role="dialog">
													<div class="modal-dialog">
													    <div class="modal-content">
													    	{!! Form::open(['route'=>['visites.destroy',$patient->id,$visite->id ],'method'=>'DELETE']) !!}
														      	<div class="modal-header">
															        <button type="button" class="close" data-dismiss="modal">&times;</button>
															        <h4 class="modal-title">Supprimer</h4>
																</div>
																<div class="modal-body">
														        	<p>Voulez-vous vraiment supprimer cette visite?</p>
																</div>
																<div class="modal-footer">
											                    	<button type="submit" class="btn btn-danger" style="color: #000;">OUI</button>
														        	<button type="button" class="btn btn-default" data-dismiss="modal">NON</button>
																</div>
															{!! Form::close() !!}
													    </div>
													</div>
												</div>
		                                    </td>
	                                  	</tr>
                                	@endforeach
                                </tbody>
                          	</table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Start Tables Rendez-vous  -->

        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="body">
                    	<div class="block-header">
							<h1>Liste Rendez-vous</h1>
						</div>

						<div class="col-md-4">
							<div class="form-group">
				                <div class="form-line">
				                    <input id="date_rendezvous" type="date" name="date" class="form-control" placeholder="Durée de rendez-vous">
				                </div>
				            </div>
				        </div>
                        <div class="table-responsive">
                          	<table id="table_rendezvous" class="table table-striped table-bordered table-hover">
                            	<thead class="thead-dark">
                              		<tr>
	                                    <th>#</th>
	                                    <th>Date</th>
	                                    <th>Motif</th>
	                                    <th>Visité</th>
	                                    <th>Actions</th>
                              		</tr>
                                </thead>
                                <tbody>
                                	@foreach ($rendezvouses as $rendezvous)
                                  		<tr>
		                                    <td>{{ $loop->index+1 }}</td>
		                                    <td>{{ $rendezvous->date }}</td>
		                                    <td>{{ $rendezvous->motif }}</td>
		                                    <td>
		                                    @if( $rendezvous->traite == true)
		                                    	<i class="fa fa-check" style="color: green;"></i>
		                                    @else
		                                    	<i class="fa fa-times" style="color: red;"></i>
		                                    @endif
		                                    </td>
		                                    <td>
		                                    	<a style="color:red;" href="#" data-toggle="modal" data-target="#myModal{{ $rendezvous->id }}"><i class="far fa-trash-alt"></i></a>

												<div id="myModal{{ $rendezvous->id }}" class="modal fade" role="dialog">
												  	<div class="modal-dialog">
													    <div class="modal-content">
													    	{!! Form::open(['route'=>['rendezvous.destroy',$rendezvous->id ],'method'=>'DELETE']) !!}
														      	<div class="modal-header">
															        <button type="button" class="close" data-dismiss="modal">&times;</button>
															        <h4 class="modal-title">Supprimer le rendez vous  du patient {{ $rendezvous->patient->prenom .' '. $rendezvous->patient->nom }}</h4>
														      	</div>
														      	<div class="modal-body">
														        	<p>voulez-vous vraiment supprimer ce rendez-vous?</p>
														      	</div>
														      	<div class="modal-footer">
											                    	<button type="submit" class="btn btn-danger" style="color: #000;">OUI</button>
														        	<button type="button" class="btn btn-default" data-dismiss="modal">NON</button>
														      	</div>
														    {!! Form::close() !!}
													    </div>
												  	</div>
												</div>

		                                    </td>
	                                  	</tr>
                                	@endforeach
                                </tbody>
                          	</table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

	</div>
</section>

<!-- Start Modal Add Visite -->
	<div id="myModalAdd" class="modal fade" role="dialog">
	  	<div class="modal-dialog modal-lg">
		    <div class="modal-content">
		    	{!! Form::open(['route' => ['visites.store','id'=>$patient->id],'method'=>'POST']) !!}
			      	<div class="modal-header">
				        <button type="button" class="close" data-dismiss="modal">&times;</button>
				        <h4 class="modal-title">Modifier Date Rendez Vous</h4>
			      	</div>
			      	<div class="modal-body">
						<div class="row clearfix">
							<div class="col-md-6">
				        		<div class="form-group">
	                                <div class="form-line">
				        				<select id="motif" name="maladie" class="form-control">
	                                        <option value="">--Maladie--</option>
	                                        @foreach($maladies as $maladie)
	                                        <option value="{{$maladie->id}}"> {{$maladie->libelle}}</option>
	                                        @endforeach
	                                    </select>
				        			</div>
				        		</div>
				        	</div>
							<div class="col-md-4">
	                            <div class="form-group">
	                                <div class="form-line">
	                                    <input type="date" name="date" class="form-control" required>
	                                </div>
	                            </div>
	                        </div>
				        </div>
				        <div class="row clearfix">
	                        <div class="col-md-12">
	                            <div class="form-group">
	                                <div class="form-line">
										<textarea name="note" class="form-control" placeholder="Notes ...."></textarea>
	                                </div>
	                            </div>
							</div>
	                    </div>
			      	</div>
			      	<div class="modal-footer">
                    	<button type="submit" class="btn btn-danger" style="color: #000;">Submit</button>
			        	<button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
			      	</div>
			    {!! Form::close() !!}
		    </div>
	  	</div>
	</div>
<!-- End Modal Add Visite -->

<!-- Start Modal Edit Visite -->
	<div id="myModalEdit" class="modal fade" role="dialog">
	  	<div class="modal-dialog modal-lg">
		    <div class="modal-content">
		    	{!! Form::open(['route' => ['visites.update',$patient->id],'method'=>'POST']) !!}
			      	<div class="modal-header">
				        <button type="button" class="close" data-dismiss="modal">&times;</button>
				        <h4 class="modal-title">Modifier Date Rendez Vous</h4>
			      	</div>
			      	<div class="modal-body">
			      		<input id="id_visite" type="hidden" name="id_visite">
						<div class="row clearfix">
							<div class="col-md-6">
				        		<div class="form-group">
	                                <div class="form-line">
				        				<select id="maladie" name="maladie" class="form-control">
	                                        <option value="">--Maladie--</option>
	                                        @foreach($maladies as $maladie)
	                                        <option value="{{$maladie->id}}"> {{$maladie->libelle}}</option>
	                                        @endforeach
	                                    </select>
				        			</div>
				        		</div>
				        	</div>
							<div class="col-md-4">
	                            <div class="form-group">
	                                <div class="form-line">
	                                    <input id="date" type="date" name="date" class="form-control" required>
	                                </div>
	                            </div>
	                        </div>
				        </div>
				        <div class="row clearfix">
	                        <div class="col-md-12">
	                            <div class="form-group">
	                                <div class="form-line">
										<textarea id="note" name="note" class="form-control" placeholder="Notes ...."></textarea>
	                                </div>
	                            </div>
							</div>
	                    </div>
			      	</div>
			      	<div class="modal-footer">
                    	<button type="submit" class="btn btn-danger" style="color: #000;">Submit</button>
			        	<button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
			      	</div>
			    {!! Form::close() !!}
		    </div>
	  	</div>
	</div>
<!-- End Modal Edit Visite -->

@endsection

@section('footer')
	<script src="{{ asset('assets/js/datatables/dataTables.min.js') }}"></script>
	<script>
		$(document).ready( function () {
    		setTimeout(function(){ $('.alert').slideUp(); }, 2000);
		    var table_visite = $('#table_visite').DataTable();
		    var table_rendezvous = $('#table_rendezvous').DataTable();

		    $('#date_visite').change(function () {
			    table_visite.columns(1).search($('#date_visite').val()).draw();
		    });

		    $('#date_rendezvous').change(function () {
			    table_rendezvous.columns(1).search($('#date_rendezvous').val()).draw();
		    });
		});

		function editVisite(id) {
			$('#id_visite').val(id);
			$.ajax({url: "{{route('visites.get')}}",
                dataType: 'json',
                contentType: 'application/json',
                async: true,
                data:{id:id},
                success:function(data) {
                    console.log(data);
                    $('#maladie').val(data.maladie_id);
                    $('#date').val(data.date);
                    $('#note').val(data.note);
                }
            });
		}
	</script>
@endsection