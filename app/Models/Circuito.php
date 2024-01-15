<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Circuito
 *
 * @property $id
 * @property $distrito_id
 * @property $nombre
 * @property $codigo
 * @property $created_at
 * @property $updated_at
 *
 * @property Distrito $distrito
 * @property Subcircuito[] $subcircuitos
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Circuito extends Model
{
    
    static $rules = [
		'distrito_id' => 'required',
		'nombre' => 'required',
		'codigo' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['distrito_id','nombre','codigo'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function distrito()
    {
        return $this->hasOne('App\Models\Distrito', 'id', 'distrito_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subcircuitos()
    {
        return $this->hasMany(Circuito::class, 'App\Models\Subcircuito', 'circuito_id', 'id');
    }
    

}
