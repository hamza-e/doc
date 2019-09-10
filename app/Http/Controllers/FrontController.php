<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Hash;
use App\Medecin;
use App\RendezVousEmpechement;
use App\Planning;
use App\RendezVous;
use App\Patient;
use App\User;
use App\Specialite;

class FrontController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {	
        $specialite = Specialite::all();
        return view('front.index',compact('specialite'));
    }


    public function searchDoc(Request $request)
    {
        if ( preg_match('/\s/',$request->q) ){ //if search input has space to check for 'nom & prenom'
            $name = explode(" ",$request->q);
            $medecins = Medecin::where('city',$request->location)
            ->where(function ($query) use ($request,$name) {
                $query->where('nom','LIKE','%'.$request->q.'%')
                    ->orWhere('prenom','LIKE','%'.$request->q.'%')
                    ->orWhere('nom','LIKE','%'.$name[0].'%')
                    ->orWhere('prenom','LIKE','%'.$name[0].'%')
                    ->orWhere('nom','LIKE','%'.$name[1].'%')
                    ->orWhere('prenom','LIKE','%'.$name[1].'%')
                    ->orWhereHas('specialite',function ($q) use ($request) {
                        $q->where('libelle','LIKE','%'.$request->q.'%');
                    });
                })
            ->get();
            return Response::json($medecins);
        }else{
            $medecins = Medecin::where('city',$request->location)
            ->where(function ($query) use ($request) {
                $query->where('nom','LIKE','%'.$request->q.'%')
                    ->orWhere('prenom','LIKE','%'.$request->q.'%')
                    ->orWhereHas('specialite',function ($q) use ($request) {
                        $q->where('libelle','LIKE','%'.$request->q.'%');
                    });
                })
            ->get();
            return Response::json($medecins);
        }
        //$list_medecin = [];
        // foreach ($medecins as $m) {
        //     array_push($list_medecin, 
        //         [
        //             'medecin' => $m,
        //             'specialite' => $m->specialite->libelle,
        //     ]);
        // }
    	//return view('front.list',compact('medecins'));
    }



    public function disponibiliteMedecin(Request $request)
    {

        //return Response::json($request->all());
        $days = [
            'Mon'   => 'Lundi',
            'Tue'   => 'Mardi',
            'Wed'   => 'Mercredi',
            'Thu'   => 'Jeudi',
            'Fri'   => 'Vendredi',
            'Sat'   => 'Samedi',
            'Sun'   => 'Dimanche'
        ];

        $mois = array('','Janvier','Fevrier','Mars','Avril','Mai','Juin','Juillet','Août','Septembre','Octobre','Novembre','Décembre');
        $medecin = Medecin::find($request->id);
        $listDispo = [];

        //******
        $current_date = $request->date;
        $cal_days = [];
        $jour = date('Y-m-d',strtotime($request->date));
        for ($i=0; $i <= 2; $i++) {
            $cal_days['jour'.($i+1)] = [
                'jour' => $days[date("D",strtotime($jour))],
                'mois' => date("d",strtotime($jour)).' '.$mois[intval(date('m',strtotime($jour)))]
            ];
            $jour = date('Y-m-d',strtotime('+1 day',strtotime($jour)));
        }
        //*******
        $indexWhile=0;
        $dispoThisDate ='';
        $arraytest = [];
        do{ //do jusqu'a trouver un rendez vous libre
        //--------------
            for ($k=0; $k <= 2; $k++) { 
                //check rendezvous
                $rendezvous = RendezVous::where('medecin_id',$medecin->id)
                    ->where('date','LIKE',$request->date.'%')
                    ->get();
                $d = date("D",strtotime($request->date));
                $planning = Planning::where(['medecin_id' => $medecin->id, 'jour'=> $days[$d]])->first();

                if(!is_null($planning)){
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
                        //return Response::json(['status'=>'Doctor not available']);
                        $new_l = [];
                    }else{
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
                                    if( !($x > $y) ){
                                        $new_l[$i] = date('H:i:s',strtotime($l[$i]));
                                    }
                                }
                            }
                        }else{
                            for ($i=0; $i < count($l); $i++) {
                                $new_l[$i] = date('H:i:s',strtotime($l[$i]));
                            }
                        }
        
                        foreach ($rendezvous as $rv ) { 
                            $pos = array_search(date('H:i:s',strtotime($rv->date)), $new_l);
                            unset($new_l[$pos]);
                        }
                        $new_l = array_values($new_l);
                    }
                    // remove passed hours
                    if(date('Y-m-d',strtotime($request->date)) == date('Y-m-d')){
                        $arraysize = count($new_l);
                        for ($j=0; $j < $arraysize; $j++) {
                            if( date('H:i:s') > date('H:i:s',strtotime($request->date.' '.$new_l[$j]))){
                                unset($new_l[$j]);
                            }
                        }
                        $new_l = array_values($new_l);
                    }
                    // 
                    $listDispo['jour'.($k+1)] = $new_l;
                }else{
                    $listDispo['jour'.($k+1)] = [];
                }
                $request->date = date('Y-m-d',strtotime('+1 day',strtotime($request->date)));
            }

            //check si cette periode contient des rendez vous libre
            if($medecin->planning->isEmpty())
                break;

            if($indexWhile > 0 && (!empty($listDispo["jour1"]) 
                || !empty($listDispo["jour2"]) || !empty($listDispo["jour3"])) ){

                $dispoThisDate = date('Y-m-d',strtotime('-3 day',strtotime($request->date)));
            }

            $indexWhile++;

        }while(empty($listDispo["jour1"]) && empty($listDispo["jour2"]) && empty($listDispo["jour3"]));


        if(!empty($dispoThisDate)){
            $listDispo["jour1"] = [];
            $listDispo["jour2"] = [];
            $listDispo["jour3"] = [];
        }

        $totaldays = max(count($listDispo['jour1']),count($listDispo['jour2']),count($listDispo['jour3']));
        $listDispoFinal =[];
        for ($w=0; $w < $totaldays; $w++) {
            $dayslistheur=[];
            if(isset($listDispo['jour1'][$w]))
                $dayslistheur['jour1'] = date('Y-m-d\TH:i:s',strtotime($current_date.' '.$listDispo['jour1'][$w]));
            else
                $dayslistheur['jour1'] = null;

            if(isset($listDispo['jour2'][$w]))
                $dayslistheur['jour2'] = date('Y-m-d\TH:i:s',strtotime('+1 days',strtotime($current_date.' '.$listDispo['jour2'][$w])));
            else
                $dayslistheur['jour2'] = null;

            if(isset($listDispo['jour3'][$w]))
                $dayslistheur['jour3'] = date('Y-m-d\TH:i:s',strtotime('+2 days',strtotime($current_date.' '.$listDispo['jour3'][$w])));
            else
                $dayslistheur['jour3'] = null;

            $listDispoFinal[] = $dayslistheur;
        }

        return Response::json([
                'medecin'       =>$medecin,
                'specialite'    =>$medecin->specialite->libelle,
                'experties'     =>$medecin->experties,
                'formations'    =>$medecin->formations,
                'disponibilite' =>$listDispoFinal,
                'date'          =>$current_date,
                'jours'         =>$cal_days,
                'active'        =>$medecin->user->active,
                'dispoAtThis'   =>$dispoThisDate
            ]);
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
                "prenom"        => "required|min:2",
                "nom"           => "required|min:2",
                "email"         => "required",
                "password"      => "required|min:6",
                "sexe"          => "required",
                "telephone"     => "required",
                "age"           => "required",
                "date"          => "required",
                "motif"         => "required",
                "medecin"       => "required"
            ]);

        $patient = new Patient();
        $patient->nom = $request->nom;
        $patient->prenom = $request->prenom;
        $patient->Age = $request->age;
        $patient->sexe = $request->sexe;
        $patient->telephone = $request->telephone;
        
        //Rendez-vous
        $rendezvous = new RendezVous();
        $rendezvous->date = $request->date;
        $rendezvous->medecin_id = $request->medecin;
        $rendezvous->motif = $request->motif;

        //user create
        $user = new User();
        $user->name = $request->nom;
        $user->email = $request->email;
        $user->role = 'patient';
        $user->password = Hash::make($request->password);
        $user->active = 1;
        $user->save();

        $patient->user_id = $user->id;
        $patient->save();
        
        $rendezvous->patient_id = $patient->id;
        $rendezvous->save();
        //Session::flash('success', 'Le patient a été ajouté avec succès!');
        return redirect()->route('search');
    }

    public function authentifierAndPrendreRv(Request $request)
    {
        $request->session()->put('medecin', $request->id);
        $request->session()->put('date', $request->date);
        $request->session()->put('medecin_nom', Medecin::find($request->id)->nom.' '.Medecin::find($request->id)->prenom);
        return Response::json(['status' => 'OK']);
    }
    
    public function medecinComplete(Request $request)
    {
        $medecins = Medecin::where('nom','LIKE','%'.$request->s.'%')
            ->orWhere('prenom','LIKE','%'.$request->s.'%')
            ->get();
        return Response::json($medecins);
    }

    public function medecinProfil($id,$nom,$prenom,$ville,$specialite)
    {
        $medecin = Medecin::find($id);
        return view('front.profil',compact('medecin'));
    }
}