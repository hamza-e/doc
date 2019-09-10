<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Maladie;
use Session;
use Auth;

class MaladieController extends Controller
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
        return view('maladie.index');
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
        if(Auth::user()->role != 'medecin')
            return redirect()->route('home');

        $request->validate([
                "libelle"   => "required|min:2",
            ]);

        $maladie = Maladie::where('libelle',$request->libelle)->first();
        if($maladie != null){
            $maladie->medecins()->sync(Auth::user()->medecins[0]->id,false);   
        }else{
            $maladie = new Maladie();
            $maladie->libelle = $request->libelle;
            $maladie->save();
            $maladie->medecins()->sync(Auth::user()->medecins[0]->id,false);
        }
        Session::flash('success', 'Maladie ajoutée avec succès!');
        return redirect()->route('maladies.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Auth::user()->role != 'medecin')
            return redirect()->route('home');
        $maladie = Maladie::find($id);
        $medecin = Auth::user()->medecins[0];
        $medecin->maladies()->detach($id);
        $nbr = $maladie->medecins()->count();
        if($nbr == 0)
            $maladie->delete();
        Session::flash('success', 'Maladie supprimée avec succès!');
        return redirect()->route('maladies.index');
    }

    public function getMaladie(Request $request)
    {
        if(Auth::user()->role != 'medecin')
            return redirect()->route('home');
        $maladies = Maladie::where('libelle','LIKE','%'.$request->libelle.'%')->get();
        return Response::json($maladies);
    }
}
