<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Vehieliminacion
 *
 * @property $id
 * @property $placa
 * @property $chasis
 * @property $motor
 * @property $motivo
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Vehieliminacion extends Model
{
    
    static $rules = [
		'placa' => 'required',
		'chasis' => 'required',
		'motor' => 'required',
		'motivo' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['placa','chasis','motor','motivo'];



}
