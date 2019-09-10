@extends('layouts.app')

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>Docteurs</h2>
            <small class="text-muted">Creation d'un nouveau medecin</small>
            @include('layouts.inc.message')
        </div>
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="header">
                        <h2>Basic Information <small>Description text here...</small></h2>
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
                        <form method="POST" action="{{ route('medecins.store') }}" enctype="multipart/form-data" onsubmit="return checkPassConfirmed()">
                            {{ csrf_field() }}
                            <div class="row clearfix">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" name="prenom" class="form-control" placeholder="First Name" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" name="nom" class="form-control" placeholder="Last Name" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input id="specialite" type="text" name="specialite" class="form-control" list="listSpecialite" placeholder="Specialité ...">
                                            <input id="specialite_id" type="hidden" name="specialite_id">
                                            <datalist id="listSpecialite">
                                                @foreach($specialities as $specialite)
                                                    <option data-id="{{$specialite->id}}" value="{{$specialite->libelle}}"></option>
                                                @endforeach
                                            </datalist>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group drop-custum">
                                        <select class="form-control show-tick" name="sexe" required>
                                            <option value="">-- Gender --</option>
                                            <option value="Homme">Male</option>
                                            <option value="Femme">Female</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" name="telephone" class="form-control" placeholder="Phone" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" name="adresse" class="form-control" placeholder="Adresse" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select id="langue" name="langues" class="form-control" placeholder="Langues" required>
                                                <option value="">--Langues--</option>
                                                <option value="Français">Français</option>
                                                <option value="Arabe">Arabe</option>
                                                <option value="Anglais">Anglais</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" name="email" class="form-control" placeholder="E-mail" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input id="password" type="password" name="password" class="form-control" placeholder="Password" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input id="confirmePass" type="password" name="" class="form-control" placeholder="Confirme Password" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" name="city" class="form-control" placeholder="Ville">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" name="tarif_de" class="form-control" placeholder="Tarif de ...">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" name="tarif_a" class="form-control" placeholder="Tarif à ...">
                                        </div>
                                    </div>
                                </div>
                                <div class="row col-md-12">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" name="latitude" class="form-control" placeholder="Map latitude EX: 31.633049">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" name="longitude" class="form-control" placeholder="Map longitude EX: -8.008520">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select name="pack" class="form-control">
                                                <option value="">--- Pack ---</option>
                                                <option value="1">Pack 3 mois</option>
                                                <option value="2">Pack 6 mois</option>
                                                <option value="3">Pack 1 an</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="date" name="date_pack" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                <!--    <form action="/" id="frmFileUpload" class="dropzone" method="post" enctype="multipart/form-data"> -->
                                        <div class="dz-message">
                                            <div class="drag-icon-cph"> <i class="material-icons">touch_app</i> </div>
                                            <h3>Drop files here or click to upload.</h3>
                                            <em>(This is just a demo dropzone. Selected files are <strong>not</strong> actually uploaded.)</em> </div>
                                        <div class="fallback">
                                            <input name="image" type="file"/>
                                        </div>
                                    <!-- </form> -->
                                </div>
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn-raised g-bg-cyan">Submit</button>
                                    <a href="{{ route('medecins.index') }}" class="btn btn-raised">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('footer')
<script type="text/javascript">
    $('#specialite').blur(function () {
        var specialite_id = $("#listSpecialite option[value='" + $('#specialite').val() + "']").attr('data-id');
        $('#specialite_id').val(specialite_id);
        console.log($('#specialite_id').val());
    });

    function checkPassConfirmed() {
        if($('#confirmePass').val() != $('#password').val()){
            $('#confirmePass').css('background-color','red');
            $('#password').css('background-color','red');
            alert('Les mots de passe ne sont pas identiques');
            return false;
        }
        return true;
    }

</script>
@endsection