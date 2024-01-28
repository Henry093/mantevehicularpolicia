<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Mantestado
 *
 * @property $id
 * @property $nombre
 * @property $created_at
 * @property $updated_at
 *
 * @property Manteregistro[] $manteregistros
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Mantestado extends Model
{
    
    static $rules = [
		'nombre' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['nombre'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function manteregistros()
    {
        return $this->hasMany('App\Models\Manteregistro', 'mantestados_id', 'id');
    }
    

}
