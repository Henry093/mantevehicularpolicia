<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Tmantenimiento
 *
 * @property $id
 * @property $nombre
 * @property $valor
 * @property $descripcion
 * @property $created_at
 * @property $updated_at
 *
 * @property Rvehiculo[] $rvehiculos
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Tmantenimiento extends Model
{
    
    static $rules = [
		'nombre' => 'required',
		'descripcion' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['nombre','valor','descripcion'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function rvehiculos()
    {
        return $this->hasMany('App\Models\Rvehiculo', 'tmantenimiento_id', 'id');
    }
    

}
