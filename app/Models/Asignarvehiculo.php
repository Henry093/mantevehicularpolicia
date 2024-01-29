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
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function vehisubcircuito()
    {
        return $this->belongsTo('App\Models\Vehisubcircuito', 'vehisubcircuito_id', 'id');
    }
    
    public function asignar()
    {
        return $this->belongsToMany('App\Models\Vehisubcircuito', 'asignarvehiculos', 'user_id', 'vehisubcircuito_id');
    }

}
