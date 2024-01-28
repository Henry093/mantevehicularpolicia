<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Manteregistro
 *
 * @property $id
 * @property $asignarvehiculos_id
 * @property $fecha_inicio
 * @property $hora
 * @property $kilometraje
 * @property $observacion
 * @property $mantestados_id
 * @property $novedad
 * @property $created_at
 * @property $updated_at
 *
 * @property Asignarvehiculo $asignarvehiculo
 * @property Mantestado $mantestado
 * @property Vehientrega[] $vehientregas
 * @property Vehiregistro[] $vehiregistros
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Manteregistro extends Model
{
    
    static $rules = [
		'asignarvehiculos_id' => 'required',
		'fecha_inicio' => 'required',
		'hora' => 'required',
		'kilometraje' => 'required',
		'observacion' => 'required',
    ];

    protected $hidden = [
        'mantestados_id',
    ];
    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['asignarvehiculos_id','fecha_inicio','hora','kilometraje','observacion','mantestados_id','novedad'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function asignarvehiculo()
    {
        return $this->hasOne('App\Models\Asignarvehiculo', 'id', 'asignarvehiculos_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function mantestado()
    {
        return $this->hasOne('App\Models\Mantestado', 'id', 'mantestados_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function vehientregas()
    {
        return $this->hasMany('App\Models\Vehientrega', 'manteregistros_id', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function vehiregistros()
    {
        return $this->hasMany('App\Models\Vehiregistro', 'manteregistros_id', 'id');
    }
    

}
