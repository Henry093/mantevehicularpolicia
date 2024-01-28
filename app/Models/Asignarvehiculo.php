<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Asignarvehiculo
 *
 * @property $id
 * @property $vehisubcircuito_id
 * @property $user_id
 * @property $created_at
 * @property $updated_at
 *
 * @property User $user
 * @property Vehisubcircuito $vehisubcircuito
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Asignarvehiculo extends Model
{
    
    static $rules = [
		'vehisubcircuito_id' => 'required',
		'user_id' => 'required',
        'orden_asignacion',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['vehisubcircuito_id','user_id'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function vehisubcircuito()
    {
        return $this->hasOne('App\Models\Vehisubcircuito', 'id', 'vehisubcircuito_id');
    }
    
    public function asignar()
    {
        return $this->hasMany('App\Models\Asignarvehiculo', 'vehisubcircuito_id', 'id');
    }

}
