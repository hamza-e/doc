<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class rendezVous extends Model
{
    protected $table = 'rendez_vouses';

    /**
     * @var array
     */
    protected $fillable = ['date','motif','traite','medecin','patient_id','created_at','updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function medecin()
    {
        return $this->belongsTo('App\Medecin');
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function patient()
    {
        return $this->belongsTo('App\Patient');
    }
}
