<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Vsubcircuito
 *
 * @property $id
 * @property $vehiculo_id
 * @property $dependencia_id
 * @property $usubcircuito_id
 * @property $asignacion_id
 * @property $estado_id
 * @property $created_at
 * @property $updated_at
 *
 * @property Asignacione $asignacione
 * @property Dependencia $dependencia
 * @property Estado $estado
 * @property Rmantenimiento[] $rmantenimientos
 * @property Usubcircuito $usubcircuito
 * @property Vehiculo $vehiculo
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Vsubcircuito extends Model
{
    
    static $rules = [
		'vehiculo_id' => 'required',
		'dependencia_id' => 'required',
		'usubcircuito_id' => 'required',
		'asignacion_id' => 'required',
		'estado_id' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['vehiculo_id','dependencia_id','usubcircuito_id','asignacion_id','estado_id'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function asignacione()
    {
        return $this->hasOne('App\Models\Asignacione', 'id', 'asignacion_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function dependencia()
    {
        return $this->hasOne('App\Models\Dependencia', 'id', 'dependencia_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function estado()
    {
        return $this->hasOne('App\Models\Estado', 'id', 'estado_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function rmantenimientos()
    {
        return $this->hasMany('App\Models\Rmantenimiento', 'vsubcircuito_id', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function usubcircuito()
    {
        return $this->hasOne('App\Models\Usubcircuito', 'id', 'usubcircuito_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function vehiculo()
    {
        return $this->hasOne('App\Models\Vehiculo', 'id', 'vehiculo_id');
    }
    

}
