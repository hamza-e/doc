<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RendezVousEmpechement extends Model
{
    protected $table = 'rendezvous_empechement';
	/**
     * @var array
     */
    protected $fillable = ['libelle','date_de','date_a','medecin_id','created_at','updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function medecin()
    {
        return $this->belongsTo('App\Medecin');
    }
}
