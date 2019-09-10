@extends('layouts.app')

@section('head')
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
	<style type="text/css">
		.modal-backdrop.show{ display: none; }
		.pull-right{ float: right; }
	</style>
@endsection

@section('content')
<section class="content profile-page">
	<div class="container-fluid">
		<div class="row clearfix">
			<div class="col-md-12 p-l-0 p-r-0">
				<section class="boxs-simple">
					<div class="profile-header">
                        <div class="profile_info">
                            <div class="profile-image"> <img src="{{asset('assets/images/'.$medecin->image)}}" alt="" width="120px" height="120px"> </div>
                            <h4 class="mb-0"><strong>Dr. {{$medecin->nom}}</strong> {{$medecin->prenom}}</h4>
                            <span class="text-muted col-white">{{$medecin->specialite->libelle}}</span>
                            <div class="mt-10">
                                <a href="{{ route('medecins.edit', ['medecin' => $medecin->id ]) }}" class="btn btn-raised btn-default bg-blush btn-sm">Edit</a>
                            </div>
                        </div>
                    </div>
				</section>
			</div>
		</div>
	</div>
</section>


@endsection