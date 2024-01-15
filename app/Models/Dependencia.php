<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Dependencia
 *
 * @property $id
 * @property $provincia_id
 * @property $canton_id
 * @property $parroquia_id
 * @property $distrito_id
 * @property $circuito_id
 * @property $subcircuito_id
 * @property $estado_id
 * @property $created_at
 * @property $updated_at
 *
 * @property Canton $canton
 * @property Circuito $circuito
 * @property Distrito $distrito
 * @property Estado $estado
 * @property Parroquia $parroquia
 * @property Provincia $provincia
 * @property Subcircuito $subcircuito
 * @property Usubcircuito[] $usubcircuitos
 * @property Vsubcircuito[] $vsubcircuitos
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Dependencia extends Model
{
    
    static $rules = [
		'provincia_id' => 'required',
		'canton_id' => 'required',
		'parroquia_id' => 'required',
		'distrito_id' => 'required',
		'circuito_id' => 'required',
		'subcircuito_id' => 'required',
		'estado_id' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['provincia_id','canton_id','parroquia_id','distrito_id','circuito_id','subcircuito_id','estado_id'];


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
    public function estado()
    {
        return $this->hasOne('App\Models\Estado', 'id', 'estado_id');
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
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function usubcircuitos()
    {
        return $this->hasMany('App\Models\Usubcircuito', 'dependencia_id', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function vsubcircuitos()
    {
        return $this->hasMany('App\Models\Vsubcircuito', 'dependencia_id', 'id');
    }
    

}
