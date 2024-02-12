<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Usersubcircuito
 *
 * @property $id
 * @property $user_id
 * @property $provincia_id
 * @property $canton_id
 * @property $parroquia_id
 * @property $distrito_id
 * @property $circuito_id
 * @property $subcircuito_id
 * @property $asignacion_id
 * @property $created_at
 * @property $updated_at
 *
 * @property Asignacion $asignacion
 * @property Canton $canton
 * @property Circuito $circuito
 * @property Distrito $distrito
 * @property Parroquia $parroquia
 * @property Provincia $provincia
 * @property Subcircuito $subcircuito
 * @property User $user
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Usersubcircuito extends Model
{
    
    static $rules = [
		'user_id' => 'required',
		'provincia_id' => 'required',
		'canton_id' => 'required',
		'parroquia_id' => 'required',
		'distrito_id' => 'required',
		'circuito_id' => 'required',
		'subcircuito_id' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id','provincia_id','canton_id','parroquia_id','distrito_id','circuito_id','subcircuito_id','asignacion_id'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function asignacion()
    {
        return $this->hasOne('App\Models\Asignacion', 'id', 'asignacion_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function canton()
    {
        return $this->hasOne('App\Models\Canton', 'id', 'canton_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function circuito()
    {
        return $this->hasOne('App\Models\Circuito', 'id', 'circuito_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function distrito()
    {
        return $this->hasOne('App\Models\Distrito', 'id', 'distrito_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function parroquia()
    {
        return $this->hasOne('App\Models\Parroquia', 'id', 'parroquia_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function provincia()
    {
        return $this->hasOne('App\Models\Provincia', 'id', 'provincia_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function subcircuito()
    {
        return $this->hasOne('App\Models\Subcircuito', 'id', 'subcircuito_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }
    protected $hidden = [
        'asignacion_id',
    ];

    
    public function asignar()
    {
        return $this->hasMany(Asignarvehiculo::class, 'user_id');
    }
    
    public function vehiAsignado()
    {
        return $this->asignar()->exists();
    }

    public function asignaciones()
    {
            return $this->hasMany(Asignarvehiculo::class, 'user_id');
    }
}
