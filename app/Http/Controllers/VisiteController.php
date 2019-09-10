<?php

namespace App\Http\Controllers;

use App\Visite;
use App\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Auth;
use Session;
class VisiteController extends Controller
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
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$id)
    {
        if (Auth::user()->role != 'medecin')
            return view('404');
        $request->validate([
                "date"           => "required",
            ]);

        $visite = new Visite();
        $visite->patient_id = $id;
        $visite->medecin_id = Auth::user()->medecins[0]->id;
        $visite->maladie_id = $request->maladie;
        $visite->date = $request->date;
        $visite->note = $request->note;
        $visite->save();
        Session::flash('success', 'Visite ajoutée avec succès!');
        return redirect()->route('patients.show',['id'=>$id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Visite  $visite
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Visite  $visite
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Visite  $visite
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        if (Auth::user()->role != 'medecin')
            return view('404');
        $request->validate([
                "date"           => "required",
            ]);

        $visite = Visite::find($request->id_visite);
        $visite->maladie_id = $request->maladie;
        $visite->date = $request->date;
        $visite->note = $request->note;
        $visite->save();
        Session::flash('success', 'Visite Modifiée avec succès!');
        return redirect()->route('patients.show',$id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Visite  $visite
     * @return \Illuminate\Http\Response
     */
    public function destroy($idp,$idv)
    {
        if (Auth::user()->role == 'medecin'){
            $visite = Visite::find($idv);
            if($visite->delete())
                Session::flash('success', 'Visite supprimée avec succès!');
            else
                Session::flash('error', 'Erreur de suppression. Ressayer!');
            return redirect()->route('patients.show',['id'=>$idp]);
        }
        return view('404');
    }

    public function getVisite(Request $request)
    {
        if (Auth::user()->role != 'medecin')
            return Response::json('ERROR!!!');
        return Response::json(Visite::find($request->id));
    }
}
