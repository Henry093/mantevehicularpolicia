<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Vehiculo
 *
 * @property $id
 * @property $tvehiculo_id
 * @property $placa
 * @property $chasis
 * @property $marca_id
 * @property $modelo_id
 * @property $motor
 * @property $kilometraje
 * @property $cilindraje
 * @property $vcarga_id
 * @property $vpasajero_id
 * @property $estado_id
 * @property $created_at
 * @property $updated_at
 *
 * @property Estado $estado
 * @property Marca $marca
 * @property Modelo $modelo
 * @property Tvehiculo $tvehiculo
 * @property Vcarga $vcarga
 * @property Vpasajero $vpasajero
 * @property Vsubcircuito[] $vsubcircuitos
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Vehiculo extends Model
{
    
    static $rules = [
		'tvehiculo_id' => 'required',
		'placa' => 'required|unique:vehiculos,placa|max:8',
		'chasis' => 'required|unique:vehiculos,chasis',
		'marca_id' => 'required',
		'modelo_id' => 'required',
		'motor' => 'required|unique:vehiculos,motor',
		'kilometraje' => 'required|numeric|max:999999',
		'cilindraje' => 'required',
		'vcarga_id' => 'required',
		'vpasajero_id' => 'required',
		'estado_id' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['tvehiculo_id','placa','chasis','marca_id','modelo_id','motor','kilometraje','cilindraje','vcarga_id','vpasajero_id','estado_id'];


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
    public function marca()
    {
        return $this->hasOne('App\Models\Marca', 'id', 'marca_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function modelo()
    {
        return $this->hasOne('App\Models\Modelo', 'id', 'modelo_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function tvehiculo()
    {
        return $this->hasOne('App\Models\Tvehiculo', 'id', 'tvehiculo_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function vcarga()
    {
        return $this->hasOne('App\Models\Vcarga', 'id', 'vcarga_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function vpasajero()
    {
        return $this->hasOne('App\Models\Vpasajero', 'id', 'vpasajero_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function vsubcircuitos()
    {
        return $this->hasMany('App\Models\Vsubcircuito', 'vehiculo_id', 'id');
    }
    

}
