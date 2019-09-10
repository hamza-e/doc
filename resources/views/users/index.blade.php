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
            <h1>Users</h1>
            <h3 class="text-muted">Liste des uses
            	<a href="#" data-toggle="modal" data-target="#myModalAdd" class="pull-right btn btn-raised btn-info waves-effect">Nouveau &nbsp;&nbsp;<i class="far fa-plus-square"></i></a>
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
	                                    <th>Name</th>
	                                    <th>E-mail</th>
	                                    <th>Rôle</th>
	                                    <th>Active</th>
	                                    <th>Actions</th>
                              		</tr>
                                </thead>
                                <tbody>
                                	@foreach($users as $user) 
                                  		<tr>
		                                    <td>{{ $loop->index+1 }}</td>
		                                    <td>{{ $user->name }}</td>
		                                    <td>{{ $user->email }}</td>
		                                    <td>{{ $user->role}}</td>
		                                    <td>
		                                    	@if( $user->active == true)
			                                    	<i class="fa fa-check" style="color: green;"></i>
				                                @else
				                                    <i class="fa fa-times" style="color: red;"></i>
				                                @endif
		                                    </td>
		                                    <td>
		                                    	<a href="#" data-toggle="modal" data-target="#myModalEdit" onclick="editUser({{$user->id}})" title="Modifier"><i class="far fa-edit"></i></a>
		                                    	<a href="{{route('users.active',['id'=> $user->id])}}">
			                                    <i class="fa fa-{{$user->active == true ? 'times':'check' }}" title="Activer/Desactiver ?"></i>
			                                    </a>
		                                    	<a style="color:red;" href="#" data-toggle="modal" data-target="#myModal{{ $user->id }}" title="Supprimer"><i class="far fa-trash-alt"></i></a>

												<div id="myModal{{ $user->id }}" class="modal fade" role="dialog">
												  	<div class="modal-dialog">
													    <div class="modal-content">
															{!! Form::open(['route'=>['users.destroy',$user->id ],'method'=>'DELETE']) !!}
														      	<div class="modal-header">
															        <button type="button" class="close" data-dismiss="modal">&times;</button>
															        <h4 class="modal-title">Supprimer l'utilisateur</h4>
														      	</div>
														      	<div class="modal-body">
														        	<p>voulez-vous vraiment supprimer cet utilisateur</p>
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
<!-- start Modal add user -->
<div id="myModalAdd" class="modal fade" role="dialog">
  	<div class="modal-dialog modal-lg">
	    <div class="modal-content">
	    	{!! Form::open(['route' => 'users.store','method'=>'POST']) !!}
		      	<div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal">&times;</button>
			        <h4 class="modal-title">Ajout Utilisateur</h4>
		      	</div>
		      	<div class="modal-body">
		        	<div class="col-md-6">
		        		<div class="form-group">
                            <div class="form-line">
		        				<select name="role" class="form-control" required>
                                    <option value="">--Rôle--</option>
                                    <option value="manager">Manager</option>
                                </select>
		        			</div>
		        		</div>
		        	</div>
			        <div class="row clearfix">
			        	<div class="col-md-4">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" name="name" class="form-control" placeholder="Nom" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="form-line">
                                	<input type="email" name="email" class="form-control" placeholder="E-mail" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="form-line">
                                	<input type="password" name="password" class="form-control" placeholder="Password" required>
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

<!-- end Modal add user -->

<!-- start Modal edit user -->
<div id="myModalEdit" class="modal fade" role="dialog">
  	<div class="modal-dialog modal-lg">
	    <div class="modal-content">
	    	{!! Form::open(['route' => 'users.update','method'=>'POST']) !!}
		      	<div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal">&times;</button>
			        <h4 class="modal-title">Ajout Utilisateur</h4>
		      	</div>
		      	<input id="user_id" type="hidden" name="user_id">
		      	<div class="modal-body">
		        	<div class="col-md-6">
		        		<div class="form-group">
                            <div class="form-line">
		        				<select id="role" name="role" class="form-control" required>
                                    <option value="">--Rôle--</option>
                                    <option value="manager">Manager</option>
                                </select>
		        			</div>
		        		</div>
		        	</div>
			        <div class="row clearfix">
			        	<div class="col-md-4">
                            <div class="form-group">
                                <div class="form-line">
                                    <input id="name" type="text" name="name" class="form-control" placeholder="Nom" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="form-line">
                                	<input id="email" type="email" name="email" class="form-control" placeholder="E-mail" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="form-line">
                                	<input type="password" name="password" class="form-control" placeholder="Password">
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
<!-- end Modal edit user -->


@endsection

@section('footer')
	<script src="{{ asset('assets/js/datatables/dataTables.min.js') }}"></script>
	<script>
		$(document).ready( function () {
    		setTimeout(function(){ $('.alert').slideUp(); }, 2000);
		    $('.table').DataTable();
		});

		function editUser(id) {
			$('#user_id').val(id);
			$.ajax({url: "{{route('users.get')}}",
                dataType: 'json',
                contentType: 'application/json',
                async: true,
                data:{id:id},
                success:function(data) {
                    $('#role').val(data.role);
                    $('#name').val(data.name);
                    $('#email').val(data.email);
                }
            });
		}
	</script>
@endsection