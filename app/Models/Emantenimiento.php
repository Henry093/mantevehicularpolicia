<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Emantenimiento
 *
 * @property $id
 * @property $nombre
 * @property $created_at
 * @property $updated_at
 *
 * @property Rmantenimiento[] $rmantenimientos
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Emantenimiento extends Model
{
    
    static $rules = [
		'nombre' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['nombre'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function rmantenimientos()
    {
        return $this->hasMany('App\Models\Rmantenimiento', 'emantenimiento_id', 'id');
    }
    

}
