<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Vehiregistro
 *
 * @property $id
 * @property $manteregistros_id
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
 * @property Manteregistro $manteregistro
 * @property Mantetipo $mantetipo
 * @property Vehientrega[] $vehientregas
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Vehiregistro extends Model
{
    
    static $rules = [
		'manteregistros_id' => 'required',
		'fecha_ingreso' => 'required',
		'hora_ingreso' => 'required',
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
    protected $fillable = ['manteregistros_id','fecha_ingreso','hora_ingreso','kilometraje','asunto','detalle','mantetipos_id','imagen'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function manteregistro()
    {
        return $this->hasOne('App\Models\Manteregistro', 'id', 'manteregistros_id');
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
