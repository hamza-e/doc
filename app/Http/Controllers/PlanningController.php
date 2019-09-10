<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Planning;
use Auth;
use Session;
class PlanningController extends Controller
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
    	$planning = Planning::where('medecin_id', Auth::user()->medecins[0]->id)->get();
    	$days = ['Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi','Dimanche'];
        return view('planning.index',compact('days','planning'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $days = ['Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi','Dimanche'];
        $medecin = Auth::user()->medecins[0];
        if($request->action == 'add'){
            $medecin->duree_rendezvous = $request->duree;
            foreach ($days as $d) {
                if(!in_array($d, $request->jour)){
                	$planning = new Planning();
                	$planning->jour = $d;
                	$planning->heure_debut = $request->input($d.'_de');
                	$planning->heure_fin = $request->input($d.'_a');
                    if( $request->input($d.'_pause_de') !== null && $request->input($d.'_pause_a') !== null ){
                        $planning->pause_de = $request->input($d.'_pause_de');
                        $planning->pause_a = $request->input($d.'_pause_a');
                    }else{
                        $planning->pause_de = null;
                        $planning->pause_a = null;
                    }
                	$planning->medecin_id = $medecin->id;
                	$planning->save();
                }
            }
            $medecin->save();

        }elseif($request->action == 'edit'){
            $medecin->duree_rendezvous = $request->duree;
            //dd($request->jour);
            if(!is_null($request->jour)){
                for ($i=0; $i < count($request->jour); $i++) { 
                    $planning = Planning::where(['jour'=>$request->jour[$i],'medecin_id'=>$medecin->id])->first();
                    if(!empty($planning))
                        $planning->delete();
                    //dd($planning);
                }
            }
        	foreach ($days as $d) {
                if (is_null($request->jour)) {
                    $request->jour= [];
                }
                if(!in_array($d, $request->jour)){
                    $planning = Planning::where(['jour'=>$d,'medecin_id'=>$medecin->id])->first();
                    if(empty($planning)){
                        $planning = new Planning();
                        $planning->jour = $d;
                        $planning->medecin_id = $medecin->id;
                    }
                	$planning->heure_debut = $request->input($d.'_de');
                	$planning->heure_fin = $request->input($d.'_a');
                    if( $request->input($d.'_pause_de') !== null && $request->input($d.'_pause_a') !== null ){
                    	$planning->pause_de = $request->input($d.'_pause_de');
                    	$planning->pause_a = $request->input($d.'_pause_a');
                    }else{
                        $planning->pause_de = null;
                        $planning->pause_a = null;
                    }
                	$planning->save();
                }
            }
            $medecin->save();
        }

        Session::flash('success', 'Le planning a été mis à jour !');
        return redirect()->route('planning');
    }
}
