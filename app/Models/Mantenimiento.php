<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Mantenimiento
 *
 * @property $id
 * @property $user_id
 * @property $vehiculo_id
 * @property $fecha
 * @property $hora
 * @property $kilometraje
 * @property $observaciones
 * @property $mantestado_id
 * @property $created_at
 * @property $updated_at
 *
 * @property Mantestado $mantestado
 * @property User $user
 * @property Vehiculo $vehiculo
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Mantenimiento extends Model
{
    
    static $rules = [
		'user_id' => 'required',
		'vehiculo_id' => 'required',
		'fecha' => 'required',
		'hora' => 'required',
		'kilometraje' => 'required',
    ];

    protected $hidden = [
        'mantestado_id',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id','vehiculo_id','fecha','hora','kilometraje','observaciones','mantestado_id'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function mantestado()
    {
        return $this->hasOne('App\Models\Mantestado', 'id', 'mantestado_id');
    }
    
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
    public function vehiculo()
    {
        return $this->hasOne('App\Models\Vehiculo', 'id', 'vehiculo_id');
    }
    

}
