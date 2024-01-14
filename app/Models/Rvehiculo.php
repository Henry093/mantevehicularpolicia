<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Rvehiculo
 *
 * @property $id
 * @property $rmantenimiento_id
 * @property $fecha_ingreso
 * @property $hora_ingreso
 * @property $kilometraje
 * @property $asunto
 * @property $detalle
 * @property $tmantenimiento_id
 * @property $imagen
 * @property $created_at
 * @property $updated_at
 *
 * @property Evehiculo[] $evehiculos
 * @property Rmantenimiento $rmantenimiento
 * @property Tmantenimiento $tmantenimiento
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Rvehiculo extends Model
{
    
    static $rules = [
		'rmantenimiento_id' => 'required',
		'fecha_ingreso' => 'required',
		'hora_ingreso' => 'required',
		'asunto' => 'required',
		'detalle' => 'required',
		'tmantenimiento_id' => 'required',
		'imagen' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['rmantenimiento_id','fecha_ingreso','hora_ingreso','kilometraje','asunto','detalle','tmantenimiento_id','imagen'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function evehiculos()
    {
        return $this->hasMany('App\Models\Evehiculo', 'rvehiculo_id', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function rmantenimiento()
    {
        return $this->hasOne('App\Models\Rmantenimiento', 'id', 'rmantenimiento_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function tmantenimiento()
    {
        return $this->hasOne('App\Models\Tmantenimiento', 'id', 'tmantenimiento_id');
    }
    

}
