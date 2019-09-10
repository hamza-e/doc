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
            <h1>Maladies</h1>
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
	                                    <th>Maladies</th>
	                                    <th>Actions</th>
                              		</tr>
                                </thead>
                                <tbody>
                                	@foreach (Auth::user()->medecins[0]->maladies as $maladie)
                                  		<tr>
		                                    <td>{{ $loop->index+1 }}</td>
		                                    <td>{{ $maladie->libelle }}</td>
		                                    <td>
		                                    	<!-- <a href="#"><i class="far fa-edit"></i></a> -->
		                                    	<a style="color:red;" href="#" data-toggle="modal" data-target="#myModal{{$maladie->id}}"><i class="far fa-trash-alt"></i></a>

												<div id="myModal{{$maladie->id}}" class="modal fade" role="dialog">
												  	<div class="modal-dialog">
													    <div class="modal-content">
													    {!! Form::open(['route'=>['maladies.destroy', $maladie->id],'method'=>'DELETE']) !!}
														      	<div class="modal-header">
															        <button type="button" class="close" data-dismiss="modal">&times;</button>
															        <h4 class="modal-title">Supprimer la maladie</h4>
														      	</div>
														      	<div class="modal-body">
														        	<p>voulez-vous vraiment supprimer la maladie?</p>
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

<!-- Start Modal Ajout -->
<div id="myModalAdd" class="modal fade" role="dialog">
  	<div class="modal-dialog modal-lg">
	    <div class="modal-content">
	    	{!! Form::open(['route' => 'maladies.store','method'=>'POST']) !!}
		      	<div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal">&times;</button>
			        <h4 class="modal-title">Ajout Maladie</h4>
		      	</div>
		      	<div class="modal-body">
		        	<div class="col-md-6">
		        		<div class="form-group">
                            <div class="form-line">
		        				<input id="libelle" type="text" name="libelle" class="form-control" placeholder="Libelle ..." list="datalist1">
		        			</div>
		        		</div>
		        	</div>
		      	</div>
		      	<datalist id="datalist1">
		      		
		      	</datalist>
		      	<div class="modal-footer">
                	<button type="submit" class="btn btn-danger" style="color: #000;">Ajouter</button>
		        	<button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
		      	</div>
		    {!! Form::close() !!}
	    </div>
  	</div>
</div>
<!-- End Modal Ajout -->

@endsection

@section('footer')
	<script src="{{ asset('assets/js/datatables/dataTables.min.js') }}"></script>
	<script>
		$(document).ready( function () {
    		setTimeout(function(){ $('.alert').slideUp(); }, 2000);
		    $('.table').DataTable();
		});

		$('#libelle').keyup(function () {
			$.ajax({url: "{{route('maladies.get')}}",
                dataType: 'json',
                contentType: 'application/json',
                async: false,
                data:{libelle:$("#libelle").val()},
                success:function(data) {
                    console.log(data);
                    $('#datalist1').empty();
                    for (var i = 0; i < data.length; i++) {
                    	$('#datalist1').append('<option value="'+data[i].libelle+'">');
                    }
                }
            });
		});
	</script>
@endsection