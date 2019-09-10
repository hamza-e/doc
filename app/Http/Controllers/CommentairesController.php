<?php

namespace App\Http\Controllers;

use App\Commentaire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Auth;

class CommentairesController extends Controller
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
    public function store(Request $request)
    {
        if(Auth::user()->role != 'patient')
            return route('home');

        $request->validate([
                "texte"        => "string",
            ]);
        $commentaire = new Commentaire();
        $commentaire->texte = $request->texte;
        $commentaire->medecin_id = $request->medecin;
        $commentaire->patient_id = $request->patient;
        $commentaire->date = date('Y-m-d');
        
        if($commentaire->save())
            return Response::json([
                'status'=> 'ok',
                'data'=>$commentaire,
                'patient'=> $commentaire->patient->nom.' '.$commentaire->patient->prenom
                ]);
        else
            return Response::json(['status'=>'error']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Commentaire  $commentaire
     * @return \Illuminate\Http\Response
     */
    public function show(Commentaire $commentaire)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Commentaire  $commentaire
     * @return \Illuminate\Http\Response
     */
    public function edit(Commentaire $commentaire)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Commentaire  $commentaire
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Commentaire $commentaire)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Commentaire  $commentaire
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if(Auth::user()->role != 'admin')
            return view('404');

        $commentaire = Commentaire::find($request->id);
        if($commentaire->delete())
            return Response::json(['status'=>'ok']);
        else
            return Response::json(['status'=>'error']);
    }
}
