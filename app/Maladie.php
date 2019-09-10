<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Maladie extends Model
{
	protected $table = 'maladies';

    public function medecins()
    {
    	return $this->belongsToMany('App\Medecin','medecin_maladie');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function visites()
    {
        return $this->hasMany('App\Visite');
    }
}
