<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Nmantenimiento
 *
 * @property $id
 * @property $novedad
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Nmantenimiento extends Model
{
    
    static $rules = [
		'novedad' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['novedad'];



}
