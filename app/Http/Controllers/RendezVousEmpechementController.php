<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;
use App\RendezVousEmpechement;
use App\RendezVous;
use Session;
use Auth; 

class RendezVousEmpechementController extends Controller
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
        if(Auth::user()->role != "medecin")
            return redirect()->route('home');
        $empechements = RendezVousEmpechement::where('medecin_id',Auth::user()->medecins[0]->id)->get();
        return view('rendezvous.empechement',compact('empechements'));
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
                "date_de"       => "required",
                "date_a"        => "required",
            ]);
        $empechement = new RendezVousEmpechement();
        $empechement->medecin_id = Auth::user()->medecins[0]->id;
        $empechement->libelle = $request->libelle;
        $empechement->date_de = $request->date_de .' '. $request->time_de;
        $empechement->date_a  = $request->date_a .' '. $request->time_a;
        $empechement->save();
        Session::flash('success', 'L\'empêchement a été ajouté avec succès!');
        return redirect()->route('empechement');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
                "date_de"       => "required",
                "date_a"        => "required",
            ]);
        $empechement = RendezVousEmpechement::find($request->id_empechement);
        $empechement->libelle = $request->libelle;
        $empechement->date_de = $request->date_de .' '. $request->time_de;
        $empechement->date_a  = $request->date_a .' '. $request->time_a;
        $empechement->save();
        Session::flash('success', 'L\'empêchement a été modifié avec succès!');
        return redirect()->route('empechement');
    }


    public function getEmpechement(Request $request)
    {
        $empechement = RendezVousEmpechement::find($request->id);
        return Response::json($empechement);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    	$empechement = RendezVousEmpechement::find($id);
        if (Auth::user()->medecins[0]->id == $empechement->medecin_id){
            if($empechement->delete())
                Session::flash('success', 'Empêchement a été supprimé avec succès!');
            else
                Session::flash('error', 'Erreur de supprission. Ressayer!');
            return redirect()->route('empechement');
        }
        return view('404');
    }

    public function checkReposPossibility(Request $request)
    {
        $rendezvous = RendezVous::where('medecin_id',Auth::user()->medecins[0]->id)
            ->where(function ($q) use ($request) {
                $q->where('date','>=',$request->date_de.' '.$request->time_de)
                  ->Where('date','<',$request->date_a.' '.$request->time_a);
            })
            ->get();
        if(sizeof($rendezvous) == 0){
            return Response::json(['status' => 'OK']);
        }else{
            return Response::json(['status' => 'no']);
        }
    }
}
