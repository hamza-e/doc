<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RendezVous;
use App\Expertie;
use App\Planning;
use App\Patient;
use App\RendezVousEmpechement;
use Illuminate\Support\Facades\Response;
use DateTime;
use Auth;
use Session;


class RendezVousController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $experties = Expertie::where('medecin_id',Auth::user()->medecins[0]->id)->get();
        $patients = Patient::whereHas('rendezVouses', function($q){
            $q->whereHas('medecin', function($query){
                $query->where('id', Auth::user()->medecins[0]->id);
            });
        })->distinct()->get();
        return view('rendezvous.scheduale',compact('experties','patients'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
                "patient_id"       => "required",
                "date"          => "required",
                "time"          => "required",
                "motif"         => "required"
            ]);
        $rendezvous = new RendezVous();
        $rendezvous->patient_id = $request->patient_id;
        $rendezvous->date = $request->input('date').' '.$request->input('time');
        $rendezvous->motif = $request->motif;
        $rendezvous->confirmed = 1;
        $rendezvous->medecin_id = Auth::user()->medecins[0]->id;
        $rendezvous->save();
        Session::flash('success', 'Le rendez-vous a été ajouté avec succès!');
        return redirect()->route('calendrier');
    }

	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listRendezVous()
    {
    	$rendezvous = RendezVous::where('medecin_id',Auth::user()->medecins[0]->id)->get();
    	$list = [];
    	$rv = [];
        $days = [
            'Lundi'     => 1,
            'Mardi'     => 2,
            'Mercredi'  => 3,
            'Jeudi'     => 4,
            'Vendredi'  => 5,
            'Samedi'    => 6,
            'Dimanche'  => 0
        ];
    	foreach ($rendezvous as $r ) {
            $e = Expertie::where(['libelle' => $r->motif,'medecin_id'=>Auth::user()->medecins[0]->id])->first();
            $r_color;
            if(!empty($e))
                $r_color = $e->couleur;
            else
                $r_color = '#000';
    		$rv['id'] = $r->id;
    		$rv['title'] = 'Rendez-vous avec '.$r->patient->nom .' '.$r->patient->prenom;
    		$rv['start'] = $r->date;
    		$end_time = new DateTime($r->date);
    		$end_time->modify('+'.Auth::user()->medecins[0]->duree_rendezvous.' minutes');
    		$rv['end'] = date_format($end_time,'Y-m-d H:i');
            $rv['borderColor'] = $r_color;
    		$list[]=$rv;
    	}
        $empechements = RendezVousEmpechement::where('medecin_id', Auth::user()->medecins[0]->id)->get();
        $planning = Planning::where('medecin_id',Auth::user()->medecins[0]->id)->get();
        $businessDays = [];
        foreach ($planning as $p) {
            array_push($businessDays, $days[$p->jour]);
        }

        foreach ($empechements as $e) {
            array_push($list,
                [
                    'start'     => date('Y-m-d',strtotime($e->date_de)),
                    'end'       => date('Y-m-d',strtotime($e->date_a)),
                    'overlap'   => false,
                    'rendering' => 'background',
                    'color'     => '#ff9f89'
                ]
            );
        }
        return Response::json(['listRV'=>$list,'businessDays'=>$businessDays]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listTableRendezvous()
    {
        $rendezvouses = RendezVous::where('medecin_id',Auth::user()->medecins[0]->id)->latest('date')->get();
        $experties = Expertie::where('medecin_id',Auth::user()->medecins[0]->id)->get();
        return view('rendezvous.index',compact('rendezvouses','experties'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    	$rendezvous = RendezVous::find($id);
        if (Auth::user()->medecins[0]->id == $rendezvous->medecin_id){
            if($rendezvous->delete())
                Session::flash('success', 'Le rendez vous a été supprimé avec succès!');
            else
                Session::flash('error', 'Erreur de supprission. Ressayer!');
            return redirect()->route('table_rendez_vous');
        }
        return view('404');
    }

    /**
     * 
     *
     * @return \Illuminate\Http\Response
     */
    public function rendezvousVisite($id,Request $request)
    {
        $rendezvous = RendezVous::find($id);
        if($rendezvous == null || Auth::user()->medecins[0]->id != $rendezvous->medecin_id){
            Session::flash('error', 'Error !!');
            return redirect()->route('table_rendez_vous');
        }
        if($rendezvous->traite == false) {
            $rendezvous->traite = true;
            $rendezvous->save();
            Session::flash('success', 'Le rendez vous terminé !!');
            return redirect()->route('table_rendez_vous');
        }else{
            $rendezvous->traite = false;
            $rendezvous->save();
            Session::flash('success', 'Le rendez vous terminé !!');
            return redirect()->route('table_rendez_vous');
        }

    }

    public function getRendezVous(Request $request)
    {
        $rendezvous = RendezVous::find($request->id);
        return Response::json($rendezvous);
    }

    //edit rendez vous depuis la table
    public function editRendezVous(Request $request)
    {
        $rendezvous = RendezVous::find($request->rendezvous_id);
        if($rendezvous == null || Auth::user()->medecins[0]->id != $rendezvous->medecin_id){
            Session::flash('error', 'Error !!');
            return redirect()->route('table_rendez_vous');
        }
        $rendezvous->date = $request->input('date').' '.$request->input('time');
        $rendezvous->motif = $request->motif;
        $rendezvous->save();
        Session::flash('success', 'Rendez-vous modifié !!');
        return redirect()->route('table_rendez_vous');
    }

    //edit rendez vous on drop
    public function editRendezVousOnDrop(Request $request)
    {
        $days = [
            'Mon'   => 'Lundi',
            'Tue'   => 'Mardi',
            'Wed'   => 'Mercredi',
            'Thu'   => 'Jeudi',
            'Fri'   => 'Vendredi',
            'Sat'   => 'Samedi',
            'Sun'   => 'Dimanche'
        ];
        $d = date("D",strtotime($request->date));
        $planning = Planning::where(['medecin_id' => Auth::user()->medecins[0]->id, 'jour'=> $days[$d]])->first();
        $x = strtotime(date('H:i:s',strtotime($request->date))); //heure rendez vous
        $y = strtotime(date('H:i:s',strtotime($planning->heure_debut)));//heure debut
        $z = strtotime(date('H:i:s',strtotime($planning->heure_fin))); //heure fin
        if(!($x >= $y) || !($x < $z))
            return Response::json(['status' => 'out']);
        //verifier si il ya un rendez-vous dans cette date
        $rv = RendezVous::where(['medecin_id' => Auth::user()->medecins[0]->id,'date' => $request->date])->first();
        if(!empty($rv))
            return Response::json(['status' => 'pris']);

        $rendezvous = RendezVous::find($request->id);
        if($rendezvous == null || Auth::user()->medecins[0]->id != $rendezvous->medecin_id){
            return Response::json(["status" => "error"]);
        }
        $rendezvous->date = $request->date;
        $rendezvous->save();

        return Response::json(["status" => "ok"]);
    }

    public function checkDispo(Request $request)
    {
        $days = [
            'Mon'   => 'Lundi',
            'Tue'   => 'Mardi',
            'Wed'   => 'Mercredi',
            'Thu'   => 'Jeudi',
            'Fri'   => 'Vendredi',
            'Sat'   => 'Samedi',
            'Sun'   => 'Dimanche'
        ];
        $medecin = Auth::user()->medecins[0];        

        //check rendezvous
        $rendezvous = RendezVous::where('medecin_id',$medecin->id)
            ->where('date','LIKE',$request->date.'%')
            ->get();
        $d = date("D",strtotime($request->date));
        $planning = Planning::where(['medecin_id' => $medecin->id, 'jour'=> $days[$d]])->first();
        if(empty($planning))
            return Response::json(['status'=>'Day not in the planning']);
        //check empechement
        $empechement = RendezVousEmpechement::where('medecin_id', $medecin->id)
            ->where(function ($q) use ($request) {
                $q->where('date_de','<',$request->date)
                    ->where('date_a','>=',$request->date)
                    ->orWhere('date_de','LIKE',$request->date .'%');
            })
            ->first();
        if(  !empty($empechement) &&
            ( date('Y-m-d',strtotime($empechement->date_de)) < date('Y-m-d',strtotime($request->date)) ) &&
            ( date('Y-m-d',strtotime($empechement->date_a)) > date('Y-m-d',strtotime($request->date)) ) ){
            return Response::json(['status'=>'Doctor not available']);
        }

        $heure_debut = explode(':', $planning->heure_debut);
        $heure_fin = explode(':', $planning->heure_fin);
        $l= []; //list dates
        $t = 60 / $medecin->duree_rendezvous; // nombre rendez-vous par heure
        $mins = 0; 
        for ($i=$heure_debut[0]; $i < $heure_fin[0]; $i++) { 
            if(explode(':', $planning->pause_de)[0] <= $i && $i < explode(':', $planning->pause_a)[0]){

            }else{
                for ($z=0; $z < $t ; $z++) {
                    array_push($l, $i.':'.$mins);
                    $mins = $mins + $medecin->duree_rendezvous;
                }
                $mins = 0;
            }
        }
        $new_l = [];

        if(!empty($empechement)){
            for ($i=0; $i < count($l); $i++) {
                // if( date('H:i:s',strtotime($empechement->date_de)) <= date('H:i:s',strtotime($l[$i])) ){
                //     break;
                // }else{
                //     $new_l[$i] = date('H:i:s',strtotime($l[$i]));
                // }
                if( date('Y-m-d',strtotime($empechement->date_de)) == date('Y-m-d',strtotime($request->date)) &&
                    date('Y-m-d',strtotime($empechement->date_a)) == date('Y-m-d',strtotime($request->date)) ){

                    $z = date('Y-m-d H:i:s',strtotime(date('H:i:s',strtotime($empechement->date_de))));
                    $x = date('Y-m-d H:i:s',strtotime(date('H:i:s',strtotime($empechement->date_a))));
                    $y = date('Y-m-d H:i:s',strtotime(date('H:i:s',strtotime($l[$i]))));
                    if( !($x > $y) ){
                        $new_l[$i] = date('H:i:s',strtotime($l[$i]));
                    }elseif( !( $z <= $y) ){
                        $new_l[$i] = date('H:i:s',strtotime($l[$i]));
                    }
                }elseif(date('Y-m-d',strtotime($empechement->date_de)) == date('Y-m-d',strtotime($request->date))){

                    $x = date('Y-m-d H:i:s',strtotime(date('H:i:s',strtotime($empechement->date_de))));
                    $y = date('Y-m-d H:i:s',strtotime(date('H:i:s',strtotime($l[$i]))));
                    if( !($x <= $y) ){
                        $new_l[$i] = date('H:i:s',strtotime($l[$i]));
                    }

                }elseif(date('Y-m-d',strtotime($empechement->date_a)) == date('Y-m-d',strtotime($request->date))){
                    
                    $x = date('Y-m-d H:i:s',strtotime(date('H:i:s',strtotime($empechement->date_a))));
                    $y = date('Y-m-d H:i:s',strtotime(date('H:i:s',strtotime($l[$i]))));
                    if( !($x >= $y) ){
                        $new_l[$i] = date('H:i:s',strtotime($l[$i]));
                    }
                }
            }
        }else{
            for ($i=0; $i < count($l); $i++) {
                $new_l[$i] = date('H:i:s',strtotime($l[$i]));
            }
        }

        // for ($i=0; $i < count($l); $i++) { 
        //    $l[$i]= date('H:i:s',strtotime($l[$i]));
        // }

        foreach ($rendezvous as $rv ) { 
            $pos = array_search(date('H:i:s',strtotime($rv->date)), $new_l);
            unset($new_l[$pos]);
        }
        $new_l = array_values($new_l);
        return Response::json($new_l);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexToConfirm()
    {
        $rendezvouses = RendezVous::where(['medecin_id' => Auth::user()->medecins[0]->id,'confirmed'=>0])->latest('date')->get();
        return view('rendezvous.unconfirmed',compact('rendezvouses'));
    }
}