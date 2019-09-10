<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\RendezVous;
use Auth;

/**
 * @property int $id
 * @property int $user_id
 * @property int $specialite_id
 * @property string $nom
 * @property string $prenom
 * @property string $sexe
 * @property string $image
 * @property string $adresse
 * @property string $bio
 * @property string $telephone
 * @property string $langues
 * @property float $tarif_de
 * @property float $tarif_a
 * @property string $created_at
 * @property string $updated_at
 * @property Specialite $specialite
 * @property User $user
 * @property Formation[] $formations
 * @property Image[] $images
 */
class Medecin extends Model
{
    protected $table = 'medecins';
    /**
     * @var array
     */
    protected $fillable = ['user_id', 'specialite_id', 'nom', 'prenom', 'sexe', 'image', 'adresse', 'bio', 'telephone', 'langues', 'city', 'tarif_de', 'tarif_a', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function specialite()
    {
        return $this->belongsTo('App\Specialite');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function formations()
    {
        return $this->hasMany('App\Formation');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function experties()
    {
        return $this->hasMany('App\Expertie');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function images()
    {
        return $this->hasMany('App\Image');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function rendezVouses()
    {
        return $this->hasMany('App\RendezVous');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function rendezVousEmpechement()
    {
        return $this->hasMany('App\RendezVousEmpechement');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function visites()
    {
        return $this->hasMany('App\Visite');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function planning()
    {
        return $this->hasMany('App\Planning');
    }

    public function maladies()
    {
        return $this->belongsToMany('App\Maladie','medecin_maladie');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function commentaires()
    {
        return $this->hasMany('App\Commentaire');
    }

    public function nombreRendezVousAujourdhui()
    {
        $nbr_rv = RendezVous::where(
            [
                'medecin_id'=> Auth::user()->medecins[0]->id,
                ['date','LIKE',date('Y-m-d %')]
            ]
        )->count();
        return $nbr_rv;
    }

    public function nombreRendezVousNonTraite()
    {
        $nbr_rv = RendezVous::where(
            [
                'medecin_id'=> Auth::user()->medecins[0]->id,
                ['date','LIKE',date('Y-m-d %')],
                'traite'    => 0,
            ]
        )->count();
        return $nbr_rv;
    }

    public function nombreRendezVousTraite()
    {
        $nbr_rv = RendezVous::where(
            [
                'medecin_id'=> Auth::user()->medecins[0]->id,
                ['date','LIKE',date('Y-m-d %')],
                'traite'    => 1,
            ]
        )->count();
        return $nbr_rv;
    }
}
