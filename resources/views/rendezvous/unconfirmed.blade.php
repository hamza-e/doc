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
                <h1>Rendez-vous à confirmer</h1>
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
			                                    	<a href="">
			                                    		<i class="fa fa-{{$rendezvous->traite == true ? 'times':'check' }}" title="Visité ?"></i>
			                                    	</a>
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