<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Medecin;
use App\Specialite;
use App\Formation;
use App\Expertie;
use Auth;
use Session;
use Image;
use App\User;
use Illuminate\Support\Facades\Hash;


class MedecinController extends Controller
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
        if(Auth::user()->role != "admin" && Auth::user()->role != "manager")
            return redirect()->route('home');
        $medecins = Medecin::all();
        return view('medecins.index')->withMedecins($medecins);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->role != "admin" && Auth::user()->role != "manager")
            return redirect()->route('home');
        $specialities = Specialite::all();
        return view('medecins.create',compact('specialities'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Auth::user()->role != "admin" && Auth::user()->role != "manager")
            return redirect()->route('home');

        $request->validate([
                "prenom"        => "required|min:2",
                "nom"           => "required|min:2",
                "sexe"          => "required",
                "telephone"     => "required",
                "adresse"       => "required|min:4",
                "langues"       => "required",
                "specialite"    => "required",
                "city"          => "required",
                "email"         => "required|string|email|max:255|unique:users",
                "password"      => "required|string|min:6"
            ]);
        $medecin = new Medecin();
        $user = new User();
        $user->name = $request->nom;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role = "medecin";
        
        if($request->specialite_id == null){
            $specialite = new Specialite();
            $specialite->libelle = $request->specialite;
            $specialite->save();
            $medecin->specialite_id = $specialite->id;
            dump($request->specialite);
        }else{
            $medecin->specialite_id = $request->specialite_id;
            dump($request->specialite_id);
        }
        $medecin->prenom = $request->input('prenom');
        $medecin->nom = $request->input('nom');
        $medecin->sexe = $request->input('sexe');
        $medecin->telephone = $request->input('telephone');
        $medecin->langues = $request->input('langues');
        $medecin->adresse = $request->input('adresse');
        $medecin->bio = $request->input('bio');
        $medecin->latitude = $request->latitude;
        $medecin->longitude = $request->longitude;
        if($request->pack != null){
            $user->active = 1;
            if($request->pack == 1){
                if($request->date_pack != null){
                    $user->active_de = $request->date_pack;
                    $user->active_a = date('Y-m-d',strtotime('+3 months',strtotime($request->date_pack)));
                }else{
                    $user->active_de = date('Y-m-d');
                    $user->active_a = date('Y-m-d',strtotime('+3 months'));
                }
            }elseif($request->pack == 2){
                if($request->date_pack != null){
                    $user->active_de = $request->date_pack;
                    $user->active_a = date('Y-m-d',strtotime('+6 months',strtotime($request->date_pack)));
                }else{
                    $user->active_de = date('Y-m-d');
                    $user->active_a = date('Y-m-d',strtotime('+6 months'));
                }
            }elseif($request->pack == 3){
                if($request->date_pack != null){
                    $user->active_de = $request->date_pack;
                    $user->active_a = date('Y-m-d',strtotime('+1 year',strtotime($request->date_pack)));
                }else{
                    $user->active_de = date('Y-m-d');
                    $user->active_a = date('Y-m-d',strtotime('+1 year'));
                }
            }
        }
        if($request->hasFile('image')){
            $image = $request->file('image');
            $filename = time() .'.'. $image->getClientOriginalExtension();
            $location = public_path('assets/images/'.$filename);
            Image::make($image)->resize(600,600)->save($location);
            $medecin->image = $filename;
        }
        $medecin->city = $request->input('city');
        $medecin->tarif_de = $request->input('tarif_de');
        $medecin->tarif_a = $request->input('tarif_a');

        $user->save();

        $medecin->user_id = $user->id;
        $medecin->save();
        Session::flash('success', 'Le medecin a été ajouté avec succès!');
        return redirect()->route('medecins.index'); 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(Auth::user()->role != "admin" && Auth::user()->medecins[0]->id != $id )
            return redirect()->route('home');
        $medecin = Medecin::find($id);
        return view('medecins.show',compact('medecin'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if( Auth::user()->role != "admin" && 
            Auth::user()->role != "manager" && 
            Auth::user()->medecins[0]->id != $id )
            return redirect()->route('home');
        $medecin = Medecin::find($id);
        $specialities = Specialite::all();
        $formations = Formation::where('medecin_id',$medecin->id)->get();
        $experties = Expertie::where('medecin_id',$medecin->id)->get();
        return view('medecins.edit',compact('medecin','specialities','formations','experties'));
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
        if( Auth::user()->role != "admin" && 
            Auth::user()->role != "manager" && 
            Auth::user()->medecins[0]->id != $id)
            return redirect()->route('home');
        $request->validate([
                "prenom"        => "required|min:2",
                "nom"           => "required|min:2",
                "sexe"          => "required",
                "telephone"     => "required",
                "adresse"       => "required|min:4",
                "langues"       => "required",
                "specialite"    => "required",
                "city"          => "required",
            ]);
        $medecin = Medecin::find($id);
        if($request->specialite_id == null){
            $specialite = new Specialite();
            $specialite->libelle = $request->specialite;
            $specialite->save();
            $medecin->specialite_id = $specialite->id;
        }else{
            $medecin->specialite_id = $request->specialite_id;
        }
        $medecin->prenom = $request->input('prenom');
        $medecin->nom = $request->input('nom');
        $medecin->sexe = $request->input('sexe');
        $medecin->telephone = $request->input('telephone');
        $medecin->langues = $request->input('langues');
        $medecin->adresse = $request->input('adresse');
        $medecin->bio = $request->input('bio');
        $medecin->latitude = $request->latitude;
        $medecin->longitude = $request->longitude;
        if($request->pack != null){
            $medecin->user->active = 1;
            if($request->pack == 1){
                if($request->date_pack != null){
                    $medecin->user->active_de = $request->date_pack;
                    $medecin->user->active_a = date('Y-m-d',strtotime('+3 months',strtotime($request->date_pack)));
                }else{
                    $medecin->user->active_de = date('Y-m-d');
                    $medecin->user->active_a = date('Y-m-d',strtotime('+3 months'));
                }
            }elseif($request->pack == 2){
                if($request->date_pack != null){
                    $medecin->user->active_de = $request->date_pack;
                    $medecin->user->active_a = date('Y-m-d',strtotime('+6 months',strtotime($request->date_pack)));
                }else{
                    $medecin->user->active_de = date('Y-m-d');
                    $medecin->user->active_a = date('Y-m-d',strtotime('+6 months'));
                }
            }elseif($request->pack == 3){
                if($request->date_pack != null){
                    $medecin->user->active_de = $request->date_pack;
                    $medecin->user->active_a = date('Y-m-d',strtotime('+1 year',strtotime($request->date_pack)));
                }else{
                    $medecin->user->active_de = date('Y-m-d');
                    $medecin->user->active_a = date('Y-m-d',strtotime('+1 year'));
                }
            }
        }

        if($request->hasFile('image')){
            $image = $request->file('image');
            $filename = time() .'.'. $image->getClientOriginalExtension();
            $location = public_path('assets/images/'.$filename);
            Image::make($image)->resize(600,600)->save($location);
            $medecin->image = $filename;
        }
        $medecin->city = $request->input('city');
        $medecin->tarif_de = $request->input('tarif_de');
        $medecin->tarif_a = $request->input('tarif_a');
        $medecin->user->name = $request->nom;
        $medecin->user->email = $request->email;
        if($request->password !== null){
            $medecin->user->password = Hash::make($request->password);
        }
        $medecin->save();
        $medecin->user->save();

        Session::flash('success', 'Le medecin a été modifié avec succès!');
        return redirect()->route('medecins.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Auth::user()->role == 'admin' && Auth::user()->role != "manager"){
            $medecin = Medecin::find($id);

            if($medecin->delete() && $medecin->user->delete())
                Session::flash('success', 'Le medecin a été supprimé avec succès!');
            else
                Session::flash('error', 'Erreur de supprission. Ressayer!');
            return redirect()->route('medecins.index');
        }
        return view('404');
    }

    public function addFormations($id,Request $request)
    {
        $request->validate([
                "libelle"       => "required",
                "date_debut"    => "required",
                "date_fin"      => "required",
                "adresse"       => "required"
            ]);
        $medecin = Medecin::find($id);
        if($medecin->formations()->delete() || $medecin->formations->isEmpty()){
            for ($i=0; $i < count($request->libelle); $i++) { 
                $formation = new Formation();
                $formation->libelle = $request->libelle[$i];
                $formation->datedebut = $request->date_debut[$i];
                $formation->datefin = $request->date_fin[$i];
                $formation->adresse = $request->adresse[$i];
                $formation->medecin_id = $id;
                $formation->save();
            }
        }
        return redirect()->route('medecins.show',compact('medecin'));
    }

    public function addExperties($id,Request $request)
    {
        $request->validate([
                "libelle"       => "required",
            ]);
        $medecin = Medecin::find($id);
        if($medecin->experties()->delete() || $medecin->experties->isEmpty()){
            for ($i=0; $i < count($request->libelle); $i++) { 
                $expertie = new Expertie();
                $expertie->libelle = $request->libelle[$i];
                $expertie->couleur = $request->couleur[$i];
                $expertie->medecin_id = $medecin->id;
                $expertie->save();
            }
        }
        return redirect()->route('medecins.show',compact('medecin'));
    }

    public function activateMedecin($id)
    {
        if(Auth::user()->role != 'admin' && Auth::user()->role != "manager")
            return redirect()->route('home');
        $user = User::find($id);
        if($user->active === 1){
            $user->active = 0;
        }elseif($user->active === 0){
            $user->active = 1;
        }
        $user->save();
        return redirect()->route('medecins.index');
    }

    public function packEdit($id,Request $request)
    {
        if(Auth::user()->role != 'admin' && Auth::user()->role != "manager")
            return redirect()->route('home');
        $medecin = Medecin::find($id);
        if($request->action == 'edit_pack'){
            $medecin->user->active = 1;
            if($request->pack == 1){
                if($request->date_pack != null){
                    $medecin->user->active_de = $request->date_pack;
                    $medecin->user->active_a = date('Y-m-d',strtotime('+3 months',strtotime($request->date_pack)));
                }else{
                    $medecin->user->active_de = date('Y-m-d');
                    $medecin->user->active_a = date('Y-m-d',strtotime('+3 months'));
                }
            }elseif($request->pack == 2){
                if($request->date_pack != null){
                    $medecin->user->active_de = $request->date_pack;
                    $medecin->user->active_a = date('Y-m-d',strtotime('+6 months',strtotime($request->date_pack)));
                }else{
                    $medecin->active_de = date('Y-m-d');
                    $medecin->active_a = date('Y-m-d',strtotime('+6 months'));
                }
            }elseif($request->pack == 3){
                if($request->date_pack != null){
                    $medecin->user->active_de = $request->date_pack;
                    $medecin->user->active_a = date('Y-m-d',strtotime('+1 year',strtotime($request->date_pack)));
                }else{
                    $medecin->user->active_de = date('Y-m-d');
                    $medecin->user->active_a = date('Y-m-d',strtotime('+1 year'));
                }
            }
        }elseif($request->action == 'renew_pack'){
            $medecin->user->active = 1;
            if($request->pack == 1){
                $medecin->user->active_a = date('Y-m-d',strtotime('+3 months',strtotime($medecin->user->active_a)));
            }elseif($request->pack == 2){
                $medecin->user->active_a = date('Y-m-d',strtotime('+6 months',strtotime($medecin->user->active_a)));
            }elseif($request->pack == 3){
                $medecin->user->active_a = date('Y-m-d',strtotime('+1 year',strtotime($medecin->user->active_a)));
            }
        }
        $medecin->user->save();
        return redirect()->route('medecins.edit',compact('medecin'));
    }
}
