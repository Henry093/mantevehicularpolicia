<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Subcircuito
 *
 * @property $id
 * @property $provincia_id
 * @property $distrito_id
 * @property $circuito_id
 * @property $nombre
 * @property $codigo
 * @property $created_at
 * @property $updated_at
 *
 * @property Circuito $circuito
 * @property Dependencia[] $dependencias
 * @property Distrito $distrito
 * @property Provincia $provincia
 * @property Reclamo[] $reclamos
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Subcircuito extends Model
{
    
    static $rules = [
		'provincia_id' => 'required',
		'distrito_id' => 'required',
		'circuito_id' => 'required',
		'nombre' => 'required',
		'codigo' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['provincia_id','distrito_id','circuito_id','nombre','codigo'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function circuito()
    {
        return $this->hasOne('App\Models\Circuito', 'id', 'circuito_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function dependencias()
    {
        return $this->hasMany('App\Models\Dependencia', 'subcircuito_id', 'id');
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
    public function provincia()
    {
        return $this->hasOne('App\Models\Provincia', 'id', 'provincia_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reclamos()
    {
        return $this->hasMany('App\Models\Reclamo', 'subcircuito_id', 'id');
    }
    

}
