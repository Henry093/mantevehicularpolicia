<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Subcircuito
 *
 * @property $id
 * @property $circuito_id
 * @property $nombre
 * @property $codigo
 * @property $created_at
 * @property $updated_at
 *
 * @property Circuito $circuito
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Subcircuito extends Model
{
    
    static $rules = [
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
    protected $fillable = ['circuito_id','nombre','codigo'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function circuito()
    {
        return $this->hasOne('App\Models\Circuito', 'id', 'circuito_id');
    }
    

}
