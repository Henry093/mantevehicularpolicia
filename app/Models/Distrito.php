<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Distrito
 *
 * @property $id
 * @property $canton_id
 * @property $nombre
 * @property $codigo
 * @property $created_at
 * @property $updated_at
 *
 * @property Canton $canton
 * @property Circuito[] $circuitos
 * @property Dependencia[] $dependencias
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Distrito extends Model
{
    
    static $rules = [
		'canton_id' => 'required',
		'nombre' => 'required',
		'codigo' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['canton_id','nombre','codigo'];


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
    

}
