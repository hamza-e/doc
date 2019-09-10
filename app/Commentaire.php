<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Commentaire extends Model
{
	protected $table = 'commentaires';
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
