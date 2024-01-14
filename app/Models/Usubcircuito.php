<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Usubcircuito
 *
 * @property $id
 * @property $user_id
 * @property $dependencia_id
 * @property $asignacion_id
 * @property $estado_id
 * @property $created_at
 * @property $updated_at
 *
 * @property Asignacione $asignacione
 * @property Dependencia $dependencia
 * @property Estado $estado
 * @property User $user
 * @property Vsubcircuito[] $vsubcircuitos
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Usubcircuito extends Model
{
    
    static $rules = [
		'user_id' => 'required',
		'dependencia_id' => 'required',
		'asignacion_id' => 'required',
		'estado_id' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id','dependencia_id','asignacion_id','estado_id'];


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
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function vsubcircuitos()
    {
        return $this->hasMany('App\Models\Vsubcircuito', 'usubcircuito_id', 'id');
    }
    

}
