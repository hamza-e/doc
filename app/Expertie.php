<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $medecin_id
 * @property string $libelle
 * @property string $datedebut
 * @property string $datefin
 * @property string $adresse
 * @property string $created_at
 * @property string $updated_at
 * @property Medecin $medecin
 */
class expertie extends Model
{
    protected $table = 'experties';
    /**
     * @var array
     */
    protected $fillable = ['medecin_id', 'libelle', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function medecin()
    {
        return $this->belongsTo('App\Medecin');
    }
}
