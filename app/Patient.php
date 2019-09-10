<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class patient extends Model
{
	protected $table = 'patients';
	/**
     * @var array
     */
    protected $fillable = ['nom', 'prenom', 'telephone', 'sexe', 'age', 'user_id','created_at', 'updated_at'];

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
    public function rendezVouses()
    {
        return $this->hasMany('App\RendezVous');
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
    public function commentaires()
    {
        return $this->hasMany('App\Commentaire');
    }
}
