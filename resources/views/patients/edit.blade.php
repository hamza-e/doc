@extends('layouts.app')

@section('content')

<section class="content">
    <div class="container-fluid">
        <div class="block-header">
        	@include('layouts.inc.message') 
            <h2>Modification Patient</h2>
            <small class="text-muted">Welcome to Swift application</small>
        </div>
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="header">
                        <h2>Basic Information <small>Description text here...</small> </h2>
                         <ul class="header-dropdown m-r--5">
                            <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="zmdi zmdi-more-vert"></i></a>
                                <ul class="dropdown-menu pull-right">
                                    <li><a href="javascript:void(0);" class=" waves-effect waves-block">Action</a></li>
                                    <li><a href="javascript:void(0);" class=" waves-effect waves-block">Another action</a></li>
                                    <li><a href="javascript:void(0);" class=" waves-effect waves-block">Something else here</a></li>
                                </ul>
                            </li>
                        </ul> 
                    </div>
                    <div class="body">
                        <form method="POST" action="{{ route('patients.update',['patient' => $patient->id ]) }}">
                            {{ csrf_field() }}
                            {{ method_field('PATCH') }}
                            <div class="row clearfix">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" name="prenom" class="form-control" placeholder="First Name" value="{{ $patient->prenom }}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" name="nom" class="form-control" placeholder="Last Name" value="{{ $patient->nom }}" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="number" name="age" class="form-control" placeholder="Age" value="{{ $patient->age }}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group drop-custum">
                                        <select class="form-control show-tick" name="sexe" required>
                                            <option value="">-- Gender --</option>
                                            <option value="Homme" {{ $patient->sexe == 'Homme' ? 'selected':''}} >Male</option>
                                            <option value="Femme" {{ $patient->sexe == 'Femme' ? 'selected':''}}>Female</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" name="telephone" class="form-control" placeholder="Telephone" value="{{ $patient->telephone }}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn-raised g-bg-cyan">Submit</button>
                                    <a href="{{ route('medecins.index') }}" class="btn btn-raised">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection