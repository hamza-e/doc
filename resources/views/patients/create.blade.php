@extends('layouts.app')

@section('content')

<section class="content">
    <div class="container-fluid">
        <div class="block-header">
        	@include('layouts.inc.message') 
            <h2>Ajout Patient</h2>
            <small class="text-muted">Welcome to Swift application</small>
            <a href="#/" id="newPatient" class="pull-right btn btn-raised btn-info waves-effect">
            <b>Nouveau Patient</b>
            </a>
            <a href="#/" id="oldPatient" class="pull-right btn btn-raised btn-info waves-effect">
            <b>Déja existant</b>
            </a>
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
                        <form id="form1" method="POST" action="{{ route('patients.store') }}">
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
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="number" name="age" class="form-control" placeholder="Age" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group drop-custum">
                                        <select class="form-control show-tick" name="sexe" required>
                                            <option value="">-- Gender --</option>
                                            <option value="Homme">Male</option>
                                            <option value="Femme">Female</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" name="telephone" class="form-control" placeholder="Telephone" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row col-sm-12">
                                    <h4 style="margin-left: 2%;">Date Rendez-vous</h4>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select name="motif" class="form-control" required>
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
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input id="date" type="date" name="date" class="form-control" placeholder="Date Rendezvous" required>
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
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn-raised g-bg-cyan">Submit</button>
                                    <a href="{{ route('home') }}" class="btn btn-raised">Cancel</a>
                                </div>
                            </div>
                        </form>
                        <form id="form2" method="post" action="{{route('rendezvous.store')}}">
                            @csrf
                            <div class="row clearfix">
                                <div class="row col-sm-6">
                                    <div class="form-group" style="margin-left: 14px;">
                                        <div class="form-line">
                                            <input id="patient_name" type="text" class="form-control" name="" list="datalist1" placeholder="Le patient nom/prenom ...">
                                            <input id="patient_id" type="hidden" name="patient_id">
                                        </div>
                                    </div>
                                </div>
                                <datalist id="datalist1">
                                    @foreach($patients as $patient)
                                        <option data-id="{{$patient->id}}" value="{{ $patient->nom . ' ' . $patient->prenom }}"></option>
                                    @endforeach
                                </datalist>
                                <div class="row col-sm-12">
                                    <h4 style="margin-left: 2%;">Date Rendez-vous</h4>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select id="motif" name="motif" class="form-control mdb-select md-form" required>
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
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input id="date2" type="date" name="date" class="datetimepicker form-control" placeholder="Date Rendezvous" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select id="dispoHours2" class="form-control" name="time" required>
                                                
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn-raised g-bg-cyan">Submit</button>
                                    <a href="{{ route('home') }}" class="btn btn-raised">Cancel</a>
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

@section('footer')
<script type="text/javascript">
    $('#form2').hide();
    $('#oldPatient').click(function () {
        $('#form2').show();
        $('#form1').hide();
    });
    $('#newPatient').click(function () {
        $('#form1').show();
        $('#form2').hide();
    });

    $('#date').change(function () {
        $.ajax({url: "{{route('rendezvous.checkDispo')}}",
            dataType: 'json',
            contentType: 'application/json',
            async: true,
            data:{date:$("#date").val()},
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

    $('#date2').change(function () {
        $.ajax({url: "{{route('rendezvous.checkDispo')}}",
            dataType: 'json',
            contentType: 'application/json',
            async: true,
            data:{date:$("#date2").val()},
            success:function(data) {
                $('#dispoHours2').children('option').remove();
                console.log(data);
                for (var i = 0; i < data.length; i++) {
                    $('#dispoHours2').append(
                            '<option value="'+data[i]+'">'+data[i]+'</option>'
                        );
                }
            }
        });
    });
    
    $('#patient_name').blur(function () {
        var patient_id = $("#datalist1 option[value='" + $('#patient_name').val() + "']").attr('data-id');
        $('#patient_id').val(patient_id);
    });
</script>
@endsection