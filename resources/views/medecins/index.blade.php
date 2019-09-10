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
    <section class="content home">
        <div class="container-fluid">
            <div class="block-header">
                <h1>Docteurs</h1>
                <h3 class="text-muted">liste
                	<a href="{{ route('medecins.create') }}" class="pull-right btn btn-raised btn-info waves-effect">Nouveau &nbsp;&nbsp;<i class="far fa-plus-square"></i></a>
                </h3>
            </div>

			@include('layouts.inc.message')
            
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="body">
                            <div class="table-responsive">
                              	<table class="table table-striped table-bordered table-hover">
                                	<thead class="thead-dark">
                                  		<tr>
		                                    <th>#</th>
		                                    <th>Nom Complet</th>
		                                    <th>Telephone</th>
		                                    <th>Email</th>
		                                    <th>Ville</th>
		                                    <th>Specialite</th>
		                                    <th>Active</th>
		                                    <th>Actions</th>
                                  		</tr>
	                                </thead>
	                                <tbody>
	                                	@foreach ($medecins as $medecin)
	                                  		<tr>
			                                    <td>{{ $loop->index+1 }}</td>
			                                    <td>{{ $medecin->prenom .' '. $medecin->nom }}</td>
			                                    <td>{{ $medecin->telephone }}</td>
			                                    <td>{{ $medecin->user->email }}</td>
			                                    <td>{{ $medecin->city }}</td>
			                                    <td>{{ $medecin->specialite->libelle }}</td>
			                                    <td>
			                                    	@if( $medecin->user->active == true)
			                                    		<i class="fa fa-check" style="color: green;"></i>
				                                    @else
				                                    	<i class="fa fa-times" style="color: red;"></i>
				                                    @endif
			                                    </td>
			                                    <td>
			                                    	<a href="{{route('medecins.edit',$medecin->id)}}" title="Modifier"><i class="far fa-edit"></i></a>
			                                    	@if( $medecin->user->active == 1 )
														<a href="{{route('medecins.active',['id'=> $medecin->user->id])}}" onclick="return confirm('Desactiver ce medecin ?');">
				                                    		<i class="fa fa-times" title="Desactiver ?"></i>
				                                    	</a>
			                                    	@else
			                                    		<a href="{{route('medecins.edit',['id'=> $medecin->id])}}">
				                                    		<i class="fa fa-check" title="Activer"></i>
				                                    	</a>
			                                    	@endif
			                                    	<a href="{{route('medecins.show',$medecin->id)}}" title="Afficher"><i class="far fa-eye"></i></a>
			                                    	<a style="color:red;" href="#" data-toggle="modal" data-target="#myModal{{$medecin->id}}" title="Supprimer"><i class="far fa-trash-alt"></i></a>

													<div id="myModal{{$medecin->id}}" class="modal fade" role="dialog">
													  	<div class="modal-dialog">
														    <div class="modal-content">
														      	{!! Form::open(['route'=>['medecins.destroy', $medecin->id],'method'=>'DELETE']) !!}
															      	<div class="modal-header">
																        <button type="button" class="close" data-dismiss="modal">&times;</button>
																        <h4 class="modal-title">Supprimer le medecin {{ $medecin->prenom .' '. $medecin->nom }}</h4>
															      	</div>
															      	<div class="modal-body">
															        	<p>voulez-vous vraiment supprimer ce medecin?</p>
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
@endsection

@section('footer')
	<script src="{{ asset('assets/js/datatables/dataTables.min.js') }}"></script>
	<script>
		$(document).ready( function () {
    		setTimeout(function(){ $('.alert').slideUp(); }, 2000);
		    $('.table').DataTable();
		});
	</script>
@endsection
