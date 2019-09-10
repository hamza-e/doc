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
		    <h1>Repos</h1>
		    <h3 class="text-muted">Liste
		    	<a href="#" class="pull-right btn btn-raised btn-info waves-effect" data-toggle="modal" data-target="#myModalAdd">Nouveau &nbsp;&nbsp;<i class="far fa-plus-square"></i></a>
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
	                                    <th>Libelle</th>
	                                    <th>Date de </th>
	                                    <th>Date a</th>
	                                    <th>Actions</th>
                              		</tr>
                                </thead>
                                <tbody>
                                	@foreach($empechements as $empechement) 
                                  		<tr>
		                                    <td>{{ $loop->index+1 }}</td>
		                                    <td>{{ $empechement->libelle }}</td>
		                                    <td>{{ $empechement->date_de }}</td>
		                                    <td>{{ $empechement->date_a}}</td>
		                                    <td>
		                                    	<a href="#" data-toggle="modal" data-target="#myModalEdit" onclick="editEmpechement({{$empechement->id}})"><i class="far fa-edit"></i></a>
		                                    	<a style="color:red;" href="#" data-toggle="modal" data-target="#myModal{{ $empechement->id }}"><i class="far fa-trash-alt"></i></a>

												<div id="myModal{{ $empechement->id }}" class="modal fade" role="dialog">
												  	<div class="modal-dialog">
													    <div class="modal-content">
															{!! Form::open(['route'=>['empechement.destroy',$empechement->id ],'method'=>'DELETE']) !!}
														      	<div class="modal-header">
															        <button type="button" class="close" data-dismiss="modal">&times;</button>
															        <h4 class="modal-title">Supprimer l'empechement</h4>
														      	</div>
														      	<div class="modal-body">
														        	<p>voulez-vous vraiment supprimer cet empêchement</p>
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
<div id="myModalAdd" class="modal fade" role="dialog">
  	<div class="modal-dialog modal-lg">
	    <div class="modal-content">
	    	{!! Form::open(['route' => 'empechement.store','method'=>'POST','id' => 'form1']) !!}
		      	<div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal">&times;</button>
			        <h4 class="modal-title">Ajout Empechement</h4>
		      	</div>
		      	<div class="modal-body">
		        	<div class="col-md-6">
		        		<div class="form-group">
                            <div class="form-line">
		        				<input type="text" name="libelle" class="form-control" placeholder="Libelle ...">
		        			</div>
		        		</div>
		        	</div>
			        <div class="row clearfix">
			        	<div class="col-md-4">
                            <div class="form-group">
                            	<label class="label-control">Date De</label>
                                <div class="form-line">
                                    <input id="date_de1" type="date" name="date_de" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                            	<label class="label-control">Heure</label>
                                <div class="form-line">
                                	<input id="time_de1" type="time" name="time_de" class="form-control">
                                </div>
                            </div>
                        </div>
			        </div>
			        <div class="row clearfix">
			        	<div class="col-md-4">
                            <div class="form-group">
                            	<label class="label-control">Date à</label>
                                <div class="form-line">
                                    <input id="date_a1" type="date" name="date_a" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                            	<label class="label-control">Heure</label>
                                <div class="form-line">
                                	<input id="time_a1" type="time" name="time_a" class="form-control">
                                </div>
                            </div>
                        </div>
			        </div>
		      	</div>
		      	<div class="modal-footer">
                	<button type="submit" class="btn btn-danger" style="color: #000;">Ajouter</button>
		        	<button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
		      	</div>
		    {!! Form::close() !!}
	    </div>
  	</div>
</div>
<div id="myModalEdit" class="modal fade" role="dialog">
  	<div class="modal-dialog modal-lg">
	    <div class="modal-content">
	    	{!! Form::open(['route' => 'empechement.update','method'=>'POST','id' => 'form2']) !!}
		      	<div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal">&times;</button>
			        <h4 class="modal-title">Edit Empechement</h4>
		      	</div>
		      	<div class="modal-body">
		        	<input id="id_empechement" type="hidden" name="id_empechement">
		        	<div class="col-md-6">
		        		<div class="form-group">
                            <div class="form-line">
		        				<input id="libelle" type="text" name="libelle" class="form-control" placeholder="Libelle ...">
		        			</div>
		        		</div>
		        	</div>
			        <div class="row clearfix">
			        	<div class="col-md-4">
                            <div class="form-group">
                            	<label class="label-control">Date De</label>
                                <div class="form-line">
                                    <input id="date_de" type="date" name="date_de" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                            	<label class="label-control">Heure</label>
                                <div class="form-line">
                                	<input id="time_de" type="time" name="time_de" class="form-control">
                                </div>
                            </div>
                        </div>
			        </div>
			        <div class="row clearfix">
			        	<div class="col-md-4">
                            <div class="form-group">
                            	<label class="label-control">Date à</label>
                                <div class="form-line">
                                    <input id="date_a" type="date" name="date_a" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                            	<label class="label-control">Heure</label>
                                <div class="form-line">
                                	<input id="time_a" type="time" name="time_a" class="form-control">
                                </div>
                            </div>
                        </div>
			        </div>
		      	</div>
		      	<div class="modal-footer">
                	<button type="submit" class="btn btn-danger" style="color: #000;">Modifier</button>
		        	<button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
		      	</div>
		    {!! Form::close() !!}
	    </div>
  	</div>
</div>
@endsection

@section('footer')
	<script src="{{ asset('assets/js/datatables/dataTables.min.js') }}"></script>
	<script>
		$(document).ready( function () {
    		setTimeout(function(){ $('.alert').slideUp(); }, 2000);
		    $('.table').DataTable();
		});

		function editEmpechement(id){
			$('#id_empechement').val(id);
			$.ajax({url: "{{route('empechement.get')}}",
				dataType: 'json',
				contentType: 'application/json',
				async: true,
				data:{id:id},
				success:function(data) {
					var date_de = new Date(data.date_de).toJSON().slice(0,19);
					var res1 = date_de.split('T');
					var date_a = new Date(data.date_a).toJSON().slice(0,19);
					var res2 = date_a.split('T');
					$('#libelle').val(data.libelle);
					$('#date_de').val(res1[0]);
					$('#date_a').val(res2[0]);
					$('#time_de').val(res1[1]);
					$('#time_a').val(res2[1]);
				}
			});
		}

		$('#form1').submit(function (e) {
			e.preventDefault();
			var form = this;
			$.ajax({url: "{{route('empechement.checkReposPossible')}}",
				dataType: 'json',
				contentType: 'application/json',
				async: true,
				data:{date_de:$('#date_de1').val(),time_de:$('#time_de1').val(),date_a:$('#date_a1').val(),time_a:$('#time_a1').val()},
				success:function(data) {
					if (data.status == 'OK') {
						form.submit();
					}else{
						alert('Vous avez des rendez-vous dans cette periode, Veuillez modifier leurs dates d\'abord');
					}
				}
			});
		});

		$('#form2').submit(function (e) {
			e.preventDefault();
			var form = this;
			$.ajax({url: "{{route('empechement.checkReposPossible')}}",
				dataType: 'json',
				contentType: 'application/json',
				async: true,
				data:{date_de:$('#date_de').val(),time_de:$('#time_de').val(),date_a:$('#date_a').val(),time_a:$('#time_a').val()},
				success:function(data) {
					if (data.status == 'OK') {
						form.submit();
					}else{
						alert('Vous avez des rendez-vous dans cette periode, Veuillez modifier leurs dates d\'abord');
					}
				}
			});
		});
	</script>
@endsection