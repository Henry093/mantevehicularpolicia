<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Marca
 *
 * @property $id
 * @property $tvehiculo_id
 * @property $nombre
 * @property $created_at
 * @property $updated_at
 *
 * @property Modelo[] $modelos
 * @property Tvehiculo $tvehiculo
 * @property Vehiculo[] $vehiculos
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Marca extends Model
{
    
    static $rules = [
		'tvehiculo_id' => 'required',
		'nombre' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['tvehiculo_id','nombre'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function modelos()
    {
        return $this->hasMany('App\Models\Modelo', 'marca_id', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function tvehiculo()
    {
        return $this->hasOne('App\Models\Tvehiculo', 'id', 'tvehiculo_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function vehiculos()
    {
        return $this->hasMany('App\Models\Vehiculo', 'marca_id', 'id');
    }
    

}
