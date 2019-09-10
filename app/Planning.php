<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class planning extends Model
{
	protected $table = 'plannings';
	/**
     * @var array
     */
    protected $fillable = ['jour','heur_debut','heur_fin','pause_de','pause_a','medecin_id','created_at','updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function medecin()
    {
        return $this->belongsTo('App\Medecin');
    }
}
