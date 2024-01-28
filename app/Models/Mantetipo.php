<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Mantetipo
 *
 * @property $id
 * @property $nombre
 * @property $valor
 * @property $descripcion
 * @property $created_at
 * @property $updated_at
 *
 * @property Vehiregistro[] $vehiregistros
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Mantetipo extends Model
{
    
    static $rules = [
		'nombre' => 'required',
		'descripcion' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['nombre','valor','descripcion'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function vehiregistros()
    {
        return $this->hasMany('App\Models\Vehiregistro', 'mantetipos_id', 'id');
    }
    

}
