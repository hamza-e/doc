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
                <h1>Planning</h1>
            </div>


			@include('layouts.inc.message')
            <form method="POST" action="{{route('planning.store')}}">
            	@csrf
	            <div class="row clearfix">
	                <div class="col-lg-12 col-md-12 col-sm-12">
	                    <div class="card">
	                        <div class="body">
	                        @if($planning->isEmpty())
		                        <button type="submit" name="action" value="add" class="pull-right btn btn-raised btn-info waves-effect">Enregistrer &nbsp;&nbsp;<i class="far fa-plus-square"></i>
		                        </button>
		                    @else
		                    	<button type="submit" name="action" value="edit" class="pull-right btn btn-raised btn-info waves-effect">Enregistrer &nbsp;&nbsp;<i class="far fa-plus-square"></i>
		                        </button>
		                    @endif
		                    	<div class="col-md-4">
									<div class="form-group">
                                        <div class="form-line">
                                            <select name="duree" class="form-control">
                                            	<option value="">--Durée Rendez-vous</option>
                                            	<option value="5" {{Auth::user()->medecins[0]->duree_rendezvous == '5' ? 'selected':''}}>5 Minutes</option>
                                            	<option value="10" {{Auth::user()->medecins[0]->duree_rendezvous == '10' ? 'selected':''}}>10 Minutes</option>
                                            	<option value="15" {{Auth::user()->medecins[0]->duree_rendezvous == '15' ? 'selected':''}}>15 Minutes</option>
                                            	<option value="20" {{Auth::user()->medecins[0]->duree_rendezvous == '20' ? 'selected':''}}>20 Minutes</option>
                                            	<option value="30" {{Auth::user()->medecins[0]->duree_rendezvous == '30' ? 'selected':''}}>30 Minutes</option>
                                            </select>
                                        </div>
                                    </div>		                        	
		                        </div>
	                            <div class="table-responsive">
	                              	<table class="table table-striped table-bordered table-hover">
	                                	<thead class="thead-dark">
	                                  		<tr>
			                                    <th>Jour</th>
			                                    <th>De</th>
			                                    <th>A</th>
			                                    <th>Pause de</th>
			                                    <th>Pause a</th>
			                                    <th></th>
	                                  		</tr>
		                                </thead>
		                                <tbody>
		                                		@foreach($days as $day)
		                                  		<tr id="t_row_{{$day}}" {{empty($planning[$loop->index]->heure_debut) ? 'style=background-color:#949393':''}}>
				                                    <td>{{$day}}</td>
				                                    <td>
				                                    	<input id="{{$day}}_de" type="time" name="{{$day}}_de" class="form-control" value="{{!empty($planning[$loop->index]->heure_debut) ? $planning[$loop->index]->heure_debut:''}}" {{!empty($planning[$loop->index]->heure_debut) ? 'required':''}}>
				                                    </td>
				                                    <td>
				                                    	<input id="{{$day}}_a" type="time" name="{{$day}}_a" class="form-control" value="{{!empty($planning[$loop->index]->heure_fin) ? $planning[$loop->index]->heure_fin:''}}" {{!empty($planning[$loop->index]->heure_debut) ? 'required':''}}>
				                                    </td>
				                                    <td>
				                                    	<input id="pause_{{$day}}_de" type="time" name="{{$day}}_pause_de" class="form-control" value="{{!empty($planning[$loop->index]->pause_de) ? $planning[$loop->index]->pause_de:''  }}">
				                                    </td>
				                                    <td>
				                                    	<input id="pause_{{$day}}_a" type="time" name="{{$day}}_pause_a" class="form-control" value="{{!empty($planning[$loop->index]->pause_a) ? $planning[$loop->index]->pause_a:'' }}">
				                                    </td>
				                                    <td>
				                                    	<a class="btn btn-sm btn-jour" href="#0"><i class="fas fa-times"></i></a>
				                                    	<input id="{{$day}}" type="checkbox" name="jour[]" value="{{$day}}" {{empty($planning[$loop->index]->heure_debut) ? 'checked':''}}>
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
            </form>
        </div>
    </section>

@endsection

@section('footer')
	<script src="{{ asset('assets/js/datatables/dataTables.min.js') }}"></script>
	<script>
		$(document).ready( function () {
    		setTimeout(function(){ $('.alert').slideUp(); }, 2000);
		    //$('.table').DataTable();
		});

		$('.btn-jour').click(function(){
			console.log($(this).next().attr('id'));
			var day = $(this).next().attr('id');
			if(!$(this).next().is(':checked')){
				$('#t_row_'+day).css('background-color','#949393');
				$(this).next().prop('checked',true);
				$('#'+day+'_de').val('');
				$('#'+day+'_a').val('');
				$('#pause_'+day+'_de').val('');
				$('#pause_'+day+'_a').val('');
				$('#'+day+'_de').removeAttr('required');
				$('#'+day+'_a').removeAttr('required');
				console.log('checked');
			}else{
				$('#t_row_'+day).removeAttr('style');
				$(this).next().prop('checked',false);
				$('#'+day+'_de').attr('required',true);
				$('#'+day+'_a').attr('required',true);
				console.log('unchecked');
			}

		});
	</script>
@endsection