<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Treclamo
 *
 * @property $id
 * @property $nombre
 * @property $created_at
 * @property $updated_at
 *
 * @property Reclamo[] $reclamos
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Treclamo extends Model
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
    public function reclamos()
    {
        return $this->hasMany('App\Models\Reclamo', 'treclamo_id', 'id');
    }
    

}
