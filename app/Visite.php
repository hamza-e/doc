<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Visite extends Model
{
    protected $table = 'visites';

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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function maladie()
    {
        return $this->belongsTo('App\Maladie');
    }
}
