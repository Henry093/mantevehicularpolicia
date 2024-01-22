<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Distrito
 *
 * @property $id
 * @property $provincia_id
 * @property $canton_id
 * @property $parroquia_id
 * @property $nombre
 * @property $codigo
 * @property $estado_id
 * @property $created_at
 * @property $updated_at
 *
 * @property Canton $canton
 * @property Circuito[] $circuitos
 * @property Dependencia[] $dependencias
 * @property Estado $estado
 * @property Parroquia $parroquia
 * @property Provincia $provincia
 * @property Subcircuito[] $subcircuitos
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Distrito extends Model
{
    
    static $rules = [
		'provincia_id' => 'required',
		'canton_id' => 'required',
		'parroquia_id' => 'required',
		'nombre' => 'required',
		'codigo' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['provincia_id','canton_id','parroquia_id','nombre','codigo','estado_id'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function canton()
    {
        return $this->hasOne('App\Models\Canton', 'id', 'canton_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function circuitos()
    {
        return $this->hasMany('App\Models\Circuito', 'distrito_id', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function dependencias()
    {
        return $this->hasMany('App\Models\Dependencia', 'distrito_id', 'id');
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
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subcircuitos()
    {
        return $this->hasMany('App\Models\Subcircuito', 'distrito_id', 'id');
    }
    
    protected $hidden = [
        'estado_id',
    ];

}
