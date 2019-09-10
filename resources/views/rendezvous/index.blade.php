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
                <h1>Rendez-vous</h1>
                <h3 class="text-muted">Liste des Rendez vous
                	<a href="{{ route('patients.create') }}" class="pull-right btn btn-raised btn-info waves-effect">Nouveau &nbsp;&nbsp;<i class="far fa-plus-square"></i></a>
                </h3>
            </div>

			@include('layouts.inc.message')
            
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="body">
                        	<div class="col-md-4">
								<div class="form-group">
					                <div class="form-line">
					                    <input id="date" type="date" name="date" class="form-control" placeholder="Durée de rendez-vous">
					                </div>
					            </div>
					        </div>
                            <div class="table-responsive">
                              	<table class="table table-striped table-bordered table-hover">
                                	<thead class="thead-dark">
                                  		<tr>
		                                    <th>#</th>
		                                    <th>Patient</th>
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
			                                    <td>{{ $rendezvous->patient->prenom .' '. $rendezvous->patient->nom }}</td>
			                                    <td>{{ $rendezvous->date }}</td>
			                                    <td>{{ $rendezvous->motif}}</td>
			                                    <td>
			                                    @if( $rendezvous->traite == true)
			                                    	<i class="fa fa-check" style="color: green;"></i>
			                                    @else
			                                    	<i class="fa fa-times" style="color: red;"></i>
			                                    @endif
			                                    </td>
			                                    <td>
			                                    	<a href="{{route('traite_rendez_vous',['id'=> $rendezvous->id])}}">
			                                    		<i class="fa fa-{{$rendezvous->traite == true ? 'times':'check' }}" title="Visité ?"></i>
			                                    	</a>
			                                    	<a href="#" data-toggle="modal" data-target="#myModalEdit"><i class="far fa-edit" onclick="editDateRv({{$rendezvous->id}})"></i></a>
			                                    	<a href="{{route('patients.show',['id'=> $rendezvous->patient->id])}}"><i class="far fa-eye"></i></a>
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
    <div id="myModalEdit" class="modal fade" role="dialog">
	  	<div class="modal-dialog modal-lg">
		    <div class="modal-content">
		    	{!! Form::open(['route' => 'rendezvous.edit','method'=>'POST']) !!}
			      	<div class="modal-header">
				        <button type="button" class="close" data-dismiss="modal">&times;</button>
				        <h4 class="modal-title">Modifier Date Rendez Vous</h4>
			      	</div>
			      	<div class="modal-body">
			        	<input id="rendezvous_id" type="hidden" name="rendezvous_id">
			        	<div class="col-md-6">
			        		<div class="form-group">
                                <div class="form-line">
			        				<select id="motif" name="motif" class="form-control" required>
                                        <option value="">--Motif--</option>
                                        @foreach($experties as $expertie)
                                        <option value="{{$expertie->libelle}}">{{$expertie->libelle}}</option>
                                        @endforeach
                                        <option value="Consultation">Consultation</option>
                                        <option value="Autre">Autre</option>
                                    </select>
			        			</div>
			        		</div>
			        	</div>
				        <div class="row clearfix">
				        	<div class="col-md-4">
	                            <div class="form-group">
	                                <div class="form-line">
	                                    <input type="date" id="date_rendezvous" name="date" class="form-control" placeholder="Date Rendez-vous" required>
	                                </div>
	                            </div>
	                        </div>
	                        <div class="col-sm-3">
	                            <div class="form-group">
	                                <div class="form-line">
	                                    <select id="dispoHours" class="form-control" name="time" required>
	                                        
	                                    </select>
	                                </div>
	                            </div>
	                        </div>
				        </div>
			      	</div>
			      	<div class="modal-footer">
                    	<button type="submit" class="btn btn-danger" style="color: #000;">Changer</button>
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
		    var table = $('.table').DataTable();
		    $('#date').change(function () {
			    table.columns(2).search($('#date').val()).draw();
		    });
		});

		function editDateRv(id) {
			$('#rendezvous_id').val(id);
			$.ajax({url: "{{route('rendezvous.get')}}",
				dataType: 'json',
				contentType: 'application/json',
				async: true,
				data:{id:id},
				success:function(data) {
					var date = new Date(data.date).toJSON().slice(0,19);
					var res = date.split('T');
					$("#date_rendezvous").val(res[0]);
					//$("#time_rendezvous").val(res[1]);
					$('#motif').val(data.motif);
		            $.ajax({url: "{{route('rendezvous.checkDispo')}}",
		                dataType: 'json',
		                contentType: 'application/json',
		                async: true,
		                data:{date:res[0]},
		                success:function(data) {
		                    $('#dispoHours').children('option').remove();
		                    console.log(data);
		                    $('#dispoHours').append('<option value="'+res[1]+'">'+res[1]+'</option>');
		                    for (var i = 0; i < data.length; i++) {
		                        $('#dispoHours').append(
		                            '<option value="'+data[i]+'">'+data[i]+'</option>'
		                        );
		                    }
		                }
		            });
				}
			});
		}

		$('#date_rendezvous').change(function () {
            $.ajax({url: "{{route('rendezvous.checkDispo')}}",
                dataType: 'json',
                contentType: 'application/json',
                async: true,
                data:{date:$("#date_rendezvous").val()},
                success:function(data) {
                    $('#dispoHours').children('option').remove();
                    console.log(data);
                    for (var i = 0; i < data.length; i++) {
                        $('#dispoHours').append(
                            '<option value="'+data[i]+'">'+data[i]+'</option>'
                        );
                    }
                }
            });
        });

	</script>
@endsection