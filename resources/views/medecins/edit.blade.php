
@extends('layouts.app')

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>Edit Doctor</h2>
            <small class="text-muted">Welcome to Swift application</small>
            @include('layouts.inc.message')
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
                        <form method="POST" action="{{ route('medecins.update',['medecin'=> $medecin->id]) }}" enctype="multipart/form-data" onsubmit="return checkPassConfirmed()">
                            {{ csrf_field() }}
                            {{ method_field('PATCH') }}
                            <div class="row clearfix">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" name="prenom" class="form-control" placeholder="First Name" value="{{$medecin->prenom}}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" name="nom" class="form-control" placeholder="Last Name" value="{{$medecin->nom}}" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <!-- <select name="specialite" class="form-control" required>
                                                <option value="">--Specialitées--</option>
                                                @foreach($specialities as $specialite)
                                                <option value="{{$specialite->id}}" {{$specialite->id === $medecin->specialite->id ? 'selected':''}}>{{$specialite->libelle}}</option>
                                                @endforeach
                                            </select> -->
                                            <input id="specialite" type="text" name="specialite" class="form-control" list="listSpecialite" placeholder="Specialité ..." value="{{$medecin->specialite->libelle}}">
                                            <input id="specialite_id" type="hidden" name="specialite_id" value="{{$medecin->specialite_id}}">
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
                                            <option value="Homme" {{ $medecin->sexe == "Homme" ? "selected":"" }}>Male</option>
                                            <option value="Femme" {{ $medecin->sexe == "Femme" ? "selected":"" }}>Female</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" name="telephone" class="form-control" placeholder="Phone" value="{{$medecin->telephone}}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" name="adresse" class="form-control" placeholder="Adresse" value="{{$medecin->adresse}}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select id="langue" name="langues" class="form-control" placeholder="Langues" required>
                                                <option value="">--Langues--</option>
                                                <option value="Français" {{ $medecin->langues == "Français" ? "selected":"" }}>Français</option>
                                                <option value="Arabe" {{ $medecin->langues == "Arabe" ? "selected":"" }}>Arabe</option>
                                                <option value="Anglais" {{ $medecin->langues == "Anglais" ? "selected":"" }}>Anglais</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" name="email" class="form-control" placeholder="E-mail" value="{{$medecin->user->email}}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input id="password" type="password" name="password" class="form-control" placeholder="Password">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input id="confirmePass" type="password" name="" class="form-control" placeholder="Confirme Password">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" name="city" class="form-control" placeholder="Ville" value="{{$medecin->city}}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" name="tarif_de" class="form-control" placeholder="Tarif de ..." value="{{$medecin->tarif_de}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" name="tarif_a" class="form-control" placeholder="Tarif à ..." value="{{$medecin->tarif_a}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row col-md-12">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" name="latitude" class="form-control" placeholder="Map latitude EX: 31.633049" value="{{$medecin->latitude}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" name="longitude" class="form-control" placeholder="Map longitude EX: -8.008520" value="{{$medecin->longitude}}">
                                            </div>
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
                                            <input name="image" type="file" />
                                        </div>
                                    <!-- </form> -->
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <textarea rows="4" name="bio" class="form-control no-resize" placeholder="Bio .... ">{{$medecin->bio}}</textarea>
                                        </div>
                                    </div>
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
        <div class="row clearfix">
            <div class="col-md-12">
                <div class="card">
                    <div class="header">
                        <h2>Formations du Medecin<small>Description text here...</small> </h2>
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
                    <form action="{{route('medecins.addformation',['id' => $medecin->id])}}" method="post">
                        @csrf
                        <div class="body">
                            <div class="row clearfix">
                                <div class="row col-lg-12">
                                @if(!$formations->isEmpty())
                                    @foreach($formations as $formation)
                                    <div id="new_formation{{$loop->index}}" class="row col-lg-12">
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="text" class="form-control" name="libelle[]" placeholder="Formation" value="{{$formation->libelle}}" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="text" class="form-control" name="adresse[]" placeholder="Adresse formation" value="{{$formation->adresse}}" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="date" class="form-control" name="date_debut[]" placeholder="Date Debut" value="{{$formation->datedebut}}" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="date" class="form-control" name="date_fin[]" placeholder="Date Fin" value="{{$formation->datefin}}" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <a href="#/" class="btn btn-raised bg-red"  onclick="deleteFormation({{$loop->index}})">x</a>
                                        </div>
                                    </div>
                                    @endforeach
                                @else
                                    <div id="new_formation0" class="row col-lg-12">
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="text" class="form-control" name="libelle[]" placeholder="Formation" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="text" class="form-control" name="adresse[]" placeholder="Adresse formation" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="date" class="form-control" name="date_debut[]" placeholder="Date Debut" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="date" class="form-control" name="date_fin[]" placeholder="Date Fin" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <a href="#/" class="btn btn-raised bg-red" onclick="deleteFormation(0)">x</a>
                                        </div>
                                    </div>
                                @endif
                                </div>
                                <div id="body_formations" class="row col-lg-12">
                                    
                                </div>
                                <div class="col-sm-12">    
                                    <a href="#/" class="btn btn-raised g-bg-cyan" onclick="addFormation(1)"><i class="zmdi zmdi-plus"></i></a>
                                </div>
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn-raised g-bg-cyan">Submit</button>
                                    <a href="#/" class="btn btn-raised">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-md-12">
                <div class="card">
                    <div class="header">
                        <h2>Doctor Experties <small>Description text here...</small> </h2>
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
                    <form method="post" action="{{route('medecins.addexperties',['id' => $medecin->id])}}">
                        @csrf
                        <div class="body">
                            <div class="row clearfix">
                                <div id="expertiesDiv" class="col-lg-12 col-sm-12 col-md-12">
                                    @if(!$experties->isEmpty())
                                        @foreach($experties as $expertie)
                                            <div id="expertie{{$loop->index}}" class="row col-sm-12">
                                                <div class="col-sm-8">
                                                    <div class="form-group">
                                                        <div class="form-line">
                                                            <input type="text" name="libelle[]" class="form-control" placeholder="Experties" value="{{$expertie->libelle}}" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-2">
                                                    <div class="form-group">
                                                        <input type="color" name="couleur[]" value="{{$expertie->couleur}}">
                                                    </div>
                                                </div>
                                                <div class="col-sm-2">
                                                    <a href="#/" class="pull-right btn btn-raised bg-red" onclick="deleteExpertie({{$loop->index}})">X</a>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div id="expertie0" class="row col-sm-12">
                                            <div class="col-sm-8">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input type="text" name="libelle[]" class="form-control" placeholder="Experties" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="form-group">
                                                    <input type="color" name="couleur[]">
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <a href="#/" class="pull-right btn btn-raised bg-red" onclick="deleteExpertie(0)">X</a>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-sm-12">    
                                    <a href="#/" class="btn btn-raised g-bg-cyan" onclick="addExperties(1)">
                                        <i class="zmdi zmdi-plus"></i>
                                    </a>
                                </div>
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn-raised g-bg-cyan">Submit</button>
                                    <a href="#/" class="btn btn-raised">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!--  -->
        @if( Auth::user()->role == 'admin')
        <div class="row clearfix">
            <div class="col-md-12">
                <div class="card">
                    <div class="header">
                        <h2>Pack information<small>Description text here...</small> </h2>
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
                    <div class="row clearfix">
                        <div class="col-sm-12">
                            @if($medecin->user->active == 1)
                                <h3 style="margin-left: 20px"><i>Pack Activé du</i>
                                    <span style="color:#ff0303">{{$medecin->user->active_de}}</span> <i>au</i> <span style="color:#ff0303">{{$medecin->user->active_a}}</span>
                                </h3>
                            @else
                                <h3 style="margin-left: 20px;color:#ff0303;"><i>Aucun Pack Activé</i></h3>
                            @endif
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-sm-12">
                                <a id="editPack" href="#0" class="btn btn-raised" style="margin-left: 20px">Modifier pack</a>
                                <a id="newPack" href="#0" class="btn btn-raised">Renouveler pack</a>
                        </div>
                    </div>

                    <form id="form_edit_pack" method="post" action="{{route('medecins.pack.edit',['id' => $medecin->id])}}">
                        @csrf
                        <div class="body">
                            <div class="row clearfix"> 
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select name="pack" class="form-control" required>
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
                                <div class="col-sm-12">
                                    <button name="action" value="edit_pack" type="submit" class="btn btn-raised g-bg-cyan">Submit</button>
                                    <a href="#/" class="btn btn-raised">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </form>
                    <form id="form_renew_pack" method="post" action="{{route('medecins.pack.edit',['id' => $medecin->id])}}">
                        @csrf
                        <div class="body">
                            <div class="row clearfix"> 
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select name="pack" class="form-control" required>
                                                <option value="">--- Pack ---</option>
                                                <option value="1">Pack 3 mois</option>
                                                <option value="2">Pack 6 mois</option>
                                                <option value="3">Pack 1 an</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <button name="action" value="renew_pack" type="submit" class="btn btn-raised g-bg-cyan">Submit</button>
                                    <a href="#/" class="btn btn-raised">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endif
        <!--  -->
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

    var x = parseInt({{$formations->isEmpty() ? '0':$formations->count()}}); //formation input incrementation var
    var y = parseInt({{$experties->isEmpty() ? '0':$experties->count()}});
    //ajout inputs formation
    function addFormation(i) {
        x = i + x;
        $('#body_formations').append(
            '<div id="new_formation'+x+'" class="row col-lg-12">'
                +'<div class="col-sm-3">'
                    +'<div class="form-group">'
                        +'<div class="form-line">'
                            +'<input type="text" class="form-control" name="libelle[]" placeholder="Formation" required>'
                        +'</div>'
                    +'</div>'
                +'</div>'
                +'<div class="col-sm-3">'
                    +'<div class="form-group">'
                        +'<div class="form-line">'
                            +'<input type="text" class="form-control" name="adresse[]" placeholder="Adresse formation" required>'
                        +'</div>'
                    +'</div>'
                +'</div>'
                +'<div class="col-sm-2">'
                    +'<div class="form-group">'
                        +'<div class="form-line">'
                            +'<input type="date" class="form-control" name="date_debut[]" placeholder="Date Debut " required>'
                        +'</div>'
                    +'</div>'
                +'</div>'
                +'<div class="col-sm-2">'
                    +'<div class="form-group">'
                        +'<div class="form-line">'
                            +'<input type="date" class="form-control" name="date_fin[]" placeholder="Date Fin" required>'
                        +'</div>'
                    +'</div>'
                +'</div>'
                +'<div class="col-sm-2">'
                    +'<a href="#/" class="btn btn-raised bg-red" onclick="deleteFormation('+x+')">x</a>'
                +'</div>'
            +'</div>'
        );
    }

    function deleteFormation(i) {
        $('#new_formation'+i).remove();
    }


    // Ajout input Experties
    function addExperties(i) {
        y = i + y;
        $('#expertiesDiv').append(
                '<div id="expertie'+y+'" class="row col-sm-12">'
                    +'<div class="col-sm-8">'
                        +'<div class="form-group">'
                            +'<div class="form-line">'
                                +'<input type="text" name="libelle[]" class="form-control" placeholder="Experties" required>'
                            +'</div>'
                        +'</div>'
                    +'</div>'
                    +'<div class="col-sm-2">'
                        +'<div class="form-group">'
                            +'<input type="color" name="couleur[]">'
                        +'</div>'
                    +'</div>'
                    +'<div class="col-sm-2">'
                        +'<a href="#/" class="pull-right btn btn-raised bg-red" onclick="deleteExpertie('+y+')">X</a>'
                    +'</div>'
                +'</div>'
            );
    }

    function deleteExpertie(i) {
        $('#expertie'+i).remove();
    }


    $('#form_edit_pack').hide();
    $('#form_renew_pack').hide();

    $('#editPack').click(function () {
        $('#form_renew_pack').hide();
        $('#form_edit_pack').show();
    });

    $('#newPack').click(function () {
        $('#form_edit_pack').hide();
        $('#form_renew_pack').show();
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