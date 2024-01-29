<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Vehiregistro
 *
 * @property $id
 * @property $mantenimientos_id
 * @property $fecha_ingreso
 * @property $hora_ingreso
 * @property $kilometraje
 * @property $asunto
 * @property $detalle
 * @property $mantetipos_id
 * @property $imagen
 * @property $created_at
 * @property $updated_at
 *
 * @property Mantenimiento $mantenimiento
 * @property Mantetipo $mantetipo
 * @property Vehientrega[] $vehientregas
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Vehiregistro extends Model
{
    
    static $rules = [
		'mantenimientos_id' => 'required',
		'fecha_ingreso' => 'required',
		'hora_ingreso' => 'required',
		'kilometraje' => 'required',
		'asunto' => 'required',
		'detalle' => 'required',
		'mantetipos_id' => 'required',
		'imagen' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['mantenimientos_id','fecha_ingreso','hora_ingreso','kilometraje','asunto','detalle','mantetipos_id','imagen'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function mantenimiento()
    {
        return $this->hasOne('App\Models\Mantenimiento', 'id', 'mantenimientos_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function mantetipo()
    {
        return $this->hasOne('App\Models\Mantetipo', 'id', 'mantetipos_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function vehientregas()
    {
        return $this->hasMany('App\Models\Vehientrega', 'vehiregistros_id', 'id');
    }
    

}
