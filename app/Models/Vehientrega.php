<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Vehientrega
 *
 * @property $id
 * @property $manteregistros_id
 * @property $vehiregistros_id
 * @property $fecha_entrega
 * @property $p_retiro
 * @property $km_actual
 * @property $km_proximo
 * @property $observaciones
 * @property $created_at
 * @property $updated_at
 *
 * @property Manteregistro $manteregistro
 * @property Vehiregistro $vehiregistro
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Vehientrega extends Model
{
    
    static $rules = [
		'manteregistros_id' => 'required',
		'vehiregistros_id' => 'required',
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
    protected $fillable = ['manteregistros_id','vehiregistros_id','fecha_entrega','p_retiro','km_actual','km_proximo','observaciones'];


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
    public function vehiregistro()
    {
        return $this->hasOne('App\Models\Vehiregistro', 'id', 'vehiregistros_id');
    }
    

}
