<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Rmantenimiento
 *
 * @property $id
 * @property $vsubcircuito_id
 * @property $fecha_inicio
 * @property $hora
 * @property $kilometraje
 * @property $observacion
 * @property $emantenimiento_id
 * @property $created_at
 * @property $updated_at
 *
 * @property Emantenimiento $emantenimiento
 * @property Evehiculo[] $evehiculos
 * @property Rvehiculo[] $rvehiculos
 * @property Vsubcircuito $vsubcircuito
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Rmantenimiento extends Model
{
    
    static $rules = [
		'vsubcircuito_id' => 'required',
		'fecha_inicio' => 'required',
		'hora' => 'required',
		'observacion' => 'required',
		'emantenimiento_id' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['vsubcircuito_id','fecha_inicio','hora','kilometraje','observacion','emantenimiento_id'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function emantenimiento()
    {
        return $this->hasOne('App\Models\Emantenimiento', 'id', 'emantenimiento_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function evehiculos()
    {
        return $this->hasMany('App\Models\Evehiculo', 'rmantenimiento_id', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function rvehiculos()
    {
        return $this->hasMany('App\Models\Rvehiculo', 'rmantenimiento_id', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function vsubcircuito()
    {
        return $this->hasOne('App\Models\Vsubcircuito', 'id', 'vsubcircuito_id');
    }
    

}
