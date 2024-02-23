<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Pertrecho
 *
 * @property $id
 * @property $tpertrecho_id
 * @property $nombre
 * @property $descripcion
 * @property $codigo
 * @property $created_at
 * @property $updated_at
 *
 * @property Asignarpertrecho[] $asignarpertrechos
 * @property Tpertrecho $tpertrecho
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Pertrecho extends Model
{
    
    static $rules = [
		'tpertrecho_id' => 'required',
		'nombre' => 'required',
		'descripcion' => 'required',
		'codigo' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['tpertrecho_id','nombre','descripcion','codigo'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function asignarpertrechos()
    {
        return $this->hasMany('App\Models\Asignarpertrecho', 'pertrecho_id', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function tpertrecho()
    {
        return $this->hasOne('App\Models\Tpertrecho', 'id', 'tpertrecho_id');
    }
    

}
