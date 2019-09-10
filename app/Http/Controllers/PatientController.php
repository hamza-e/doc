<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Patient;
use App\RendezVous;
use App\Expertie;
use App\Visite;
use Session;
use Auth;

class PatientController extends Controller
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

        $patients = Patient::whereHas('rendezVouses', function($q){
            $q->whereHas('medecin', function($query){
                $query->where('id', Auth::user()->medecins[0]->id);
            });
        })->distinct()->get();
        return view('patients.index',compact('patients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->role != "medecin")
            return redirect()->route('home');
        $experties = Expertie::where('medecin_id',Auth::user()->medecins[0]->id)->get();
        $patients = Patient::whereHas('rendezVouses', function($q){
            $q->whereHas('medecin', function($query){
                $query->where('id', Auth::user()->medecins[0]->id);
            });
        })->distinct()->get();
        return view('patients.create',compact('experties','patients'));
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
                "sexe"          => "required",
                "telephone"     => "required",
                "age"           => "required",
                "date"          => "required",
                "time"          => "required",
            ]);

        //patient
        $patient = new Patient();
        $patient->nom = $request->input('nom');
        $patient->prenom = $request->input('prenom');
        $patient->Age = $request->input('age');
        $patient->sexe = $request->input('sexe');
        $patient->telephone = $request->input('telephone');
        //Rendez-vous

        $rendezvous = new RendezVous();
        $rendezvous->date = $request->input('date').' '.$request->input('time');
        $rendezvous->medecin_id = Auth::user()->medecins[0]->id;
        $rendezvous->motif = $request->motif;
        $rendezvous->confirmed = 1;

        $patient->save();
        
        $rendezvous->patient_id = $patient->id;
        $rendezvous->save();
        Session::flash('success', 'Le patient a été ajouté avec succès!');
        return redirect()->route('calendrier');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::user()->role != "medecin")
            return redirect()->route('home');
        $patient = Patient::find($id);
        return view('patients.edit',compact('patient'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(Auth::user()->role != "medecin")
            return redirect()->route('home');
        $patient = Patient::find($id);
        $rendezvouses = $patient->rendezVouses;
        $visites = $patient->visites->where('medecin_id',Auth::user()->medecins[0]->id);
        $maladies = Auth::user()->medecins[0]->maladies;
        return view('patients.show',compact('patient','rendezvouses','visites','maladies'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
                "prenom"        => "required|min:2",
                "nom"           => "required|min:2",
                "sexe"          => "required",
                "telephone"     => "required",
                "age"           => "required",
            ]);

        //patient
        $patient = Patient::find($id);
        $patient->nom = $request->input('nom');
        $patient->prenom = $request->input('prenom');
        $patient->Age = $request->input('age');
        $patient->sexe = $request->input('sexe');
        $patient->telephone = $request->input('telephone');
        //Rendez-vous
        return redirect()->route('patients.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Auth::user()->role == 'medecin'){
            $patient = Patient::find($id);
            $patient->rendezVouses()->delete();
            if($patient->delete())
                Session::flash('success', 'Le patient a été supprimé avec succès!');
            else
                Session::flash('error', 'Erreur de suppression. Ressayer!');
            return redirect()->route('patients.index');
        }
        return view('404');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeFromFront(Request $request)
    {
        $request->validate([
                "medecin"   => "required",
                "date"      => "required",
                "patient"   => "required",
                "motif"     => "required",
            ]);

        $rendezvous = new RendezVous();
        $rendezvous->medecin_id = $request->medecin;
        $rendezvous->patient_id = $request->patient;
        $rendezvous->date = $request->date;
        $rendezvous->motif = $request->motif;
        $rendezvous->save();
        $request->session()->forget('medecin');
        $request->session()->forget('experties');
        $request->session()->forget('date');
        $request->session()->forget('medecin_nom');
        $request->session()->flash('status', 'Rendez-vous Pris avec succès!');
        return redirect()->route('search');
    }
}
