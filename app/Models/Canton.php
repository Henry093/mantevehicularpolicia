<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Canton
 *
 * @property $id
 * @property $provincia_id
 * @property $nombre
 * @property $created_at
 * @property $updated_at
 *
 * @property Dependencia[] $dependencias
 * @property Parroquia[] $parroquias
 * @property Provincia $provincia
 * @property User[] $users
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Canton extends Model
{
    
    static $rules = [
		'provincia_id' => 'required',
		'nombre' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['provincia_id','nombre'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function dependencias()
    {
        return $this->hasMany('App\Models\Dependencia', 'canton_id', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function parroquias()
    {
        return $this->hasMany(Parroquia::class, 'App\Models\Parroquia', 'canton_id', 'id');
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
        return $this->hasMany('App\Models\User', 'canton_id', 'id');
    }
    

}
