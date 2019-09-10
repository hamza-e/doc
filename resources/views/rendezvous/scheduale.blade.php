@extends('layouts.app')

@section('styles')
    <link href="assets/plugins/fullcalendar/fullcalendar.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://uicdn.toast.com/tui-calendar/latest/tui-calendar.css" />
    <style type="text/css">
        td.fc-day.fc-past {
    background-color: #f1f1f154;
}
    </style>
@endsection

@section('content')

<section class="content page-calendar">
    <div class="container-fluid">
            <a href="#" class="pull-right btn btn-raised btn-info waves-effect" data-toggle="modal" data-target="#modalAdd"><i class="zmdi zmdi-plus"></i> Nouveau</a>
        <div class="row">
            <div class="col-md-12 col-lg-12 col-xl-12">
                <div class="card m-t-20">
                    <div class="body">
                        <button class="btn btn-raised btn-success btn-sm m-r-0 m-t-0" id="change-view-today">today</button>
                        <button class="btn btn-raised btn-default btn-sm m-r-0 m-t-0" id="change-view-day" >Day</button>
                        <button class="btn btn-raised btn-default btn-sm m-r-0 m-t-0" id="change-view-week">Week</button>
                        <button class="btn btn-raised btn-default btn-sm m-r-0 m-t-0" id="change-view-month">Month</button>                        
                        <div id="calendar"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



<!-- Start Modal Ajout Rendez-vous -->
<div id="modalAdd" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Ajout Rendez-vous</h4>
            </div>
            <div class="modal-body">
            <a href="#/" id="newPatient" class="pull-right btn btn-raised btn-info waves-effect">
                <b>Nouveau Patient</b>
            </a>
            <a href="#/" id="oldPatient" class="pull-right btn btn-raised btn-info waves-effect">
                <b>Déja existant</b>
            </a>
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
                            </div>
                        </div>
                    </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>
<!-- End Modal Ajout Rendez-vous -->


@endsection


@section('scripts')
    <script type="text/javascript">
        var listRendezVous;
        var get_list_rendezvous = "{{route('list_rendez_vous')}}";
        var edit_list_ondrop = "{{route('rendezvous.edit.ondrop')}}";
        var rendezvous_duree = {{Auth::user()->medecins[0]->duree_rendezvous}};
        var route_checkdispo = "{{route('rendezvous.checkDispo')}}";

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
        
        $('#modalAdd').on('hidden.bs.modal', function () {
            $('#dispoHours').children('option').remove();
            $('#dispoHours2').children('option').remove();
        })

        $('#patient_name').blur(function () {
            var patient_id = $("#datalist1 option[value='" + $('#patient_name').val() + "']").attr('data-id');
            $('#patient_id').val(patient_id);
        });

    </script>
    <script src="{{asset('assets/bundles/fullcalendarscripts.bundle.js')}}"></script>
    <script src="{{asset('assets/js/pages/calendar/calendar.js')}}"></script>
@endsection