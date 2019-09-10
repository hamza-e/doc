<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $medecin_id
 * @property string $src
 * @property string $created_at
 * @property string $updated_at
 * @property Medecin $medecin
 */
class Image extends Model
{
    protected $table = 'images';
    /**
     * @var array
     */
    protected $fillable = ['medecin_id', 'src', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function medecin()
    {
        return $this->belongsTo('App\Medecin');
    }
}
