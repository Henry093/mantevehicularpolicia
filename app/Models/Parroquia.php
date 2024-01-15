<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Parroquia
 *
 * @property $id
 * @property $provincia_id
 * @property $canton_id
 * @property $nombre
 * @property $created_at
 * @property $updated_at
 *
 * @property Canton $canton
 * @property Dependencia[] $dependencias
 * @property Provincia $provincia
 * @property User[] $users
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Parroquia extends Model
{
    
    static $rules = [
		'provincia_id' => 'required',
		'canton_id' => 'required',
		'nombre' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['provincia_id','canton_id','nombre'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function canton()
    {
        return $this->hasOne( 'App\Models\Canton', 'id', 'canton_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function dependencias()
    {
        return $this->hasMany('App\Models\Dependencia', 'parroquia_id', 'id');
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
    public function users()
    {
        return $this->hasMany('App\Models\User', 'parroquia_id', 'id');
    }
    

    
}
