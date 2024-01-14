<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Rango
 *
 * @property $id
 * @property $grado_id
 * @property $nombre
 * @property $created_at
 * @property $updated_at
 *
 * @property Grado $grado
 * @property User[] $users
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Rango extends Model
{
    
    static $rules = [
		'grado_id' => 'required',
		'nombre' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['grado_id','nombre'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function grado()
    {
        return $this->hasOne('App\Models\Grado', 'id', 'grado_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany('App\Models\User', 'rango_id', 'id');
    }
    

}
