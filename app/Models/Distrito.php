<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Distrito
 *
 * @property $id
 * @property $provincia_id
 * @property $nombre
 * @property $codigo
 * @property $created_at
 * @property $updated_at
 *
 * @property Circuito[] $circuitos
 * @property Provincia $provincia
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Distrito extends Model
{
    
    static $rules = [
		'provincia_id' => 'required',
		'nombre' => 'required',
		'codigo' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['provincia_id','nombre','codigo'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function circuitos()
    {
        return $this->hasMany('App\Models\Circuito', 'distrito_id', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function provincia()
    {
        return $this->hasOne('App\Models\Provincia', 'id', 'provincia_id');
    }
    

}
