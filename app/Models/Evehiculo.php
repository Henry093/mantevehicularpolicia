<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Evehiculo
 *
 * @property $id
 * @property $rmantenimiento_id
 * @property $rvehiculo_id
 * @property $fecha_entrega
 * @property $p_retiro
 * @property $km_actual
 * @property $km_proximo
 * @property $observaciones
 * @property $created_at
 * @property $updated_at
 *
 * @property Rmantenimiento $rmantenimiento
 * @property Rvehiculo $rvehiculo
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Evehiculo extends Model
{
    
    static $rules = [
		'rmantenimiento_id' => 'required',
		'rvehiculo_id' => 'required',
		'fecha_entrega' => 'required',
		'p_retiro' => 'required',
		'observaciones' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['rmantenimiento_id','rvehiculo_id','fecha_entrega','p_retiro','km_actual','km_proximo','observaciones'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function rmantenimiento()
    {
        return $this->hasOne('App\Models\Rmantenimiento', 'id', 'rmantenimiento_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function rvehiculo()
    {
        return $this->hasOne('App\Models\Rvehiculo', 'id', 'rvehiculo_id');
    }
    

}
