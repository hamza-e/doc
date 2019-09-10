<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $libelle
 * @property string $created_at
 * @property string $updated_at
 * @property Medecin[] $medecins
 * @property SubSpecialite[] $subSpecialites
 */
class Specialite extends Model
{
    protected $table = 'specialites';
    /**
     * @var array
     */
    protected $fillable = ['libelle', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function medecins()
    {
        return $this->hasMany('App\Medecin');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subSpecialites()
    {
        return $this->hasMany('App\SubSpecialite');
    }
}
