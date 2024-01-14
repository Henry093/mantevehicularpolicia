<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Modelo
 *
 * @property $id
 * @property $marca_id
 * @property $nombre
 * @property $created_at
 * @property $updated_at
 *
 * @property Marca $marca
 * @property Vehiculo[] $vehiculos
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Modelo extends Model
{
    
    static $rules = [
		'marca_id' => 'required',
		'nombre' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['marca_id','nombre'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function marca()
    {
        return $this->hasOne('App\Models\Marca', 'id', 'marca_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function vehiculos()
    {
        return $this->hasMany('App\Models\Vehiculo', 'modelo_id', 'id');
    }
    

}
