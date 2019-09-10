<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $specialite_id
 * @property string $libelle
 * @property string $created_at
 * @property string $updated_at
 * @property Specialite $specialite
 */
class SubSpecialite extends Model
{
    protected $table = 'sub_specialites';
    /**
     * @var array
     */
    protected $fillable = ['specialite_id', 'libelle', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function specialite()
    {
        return $this->belongsTo('App\Specialite');
    }
}
