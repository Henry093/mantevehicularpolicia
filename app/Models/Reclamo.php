<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Reclamo
 *
 * @property $id
 * @property $circuito_id
 * @property $subcircuito_id
 * @property $treclamo_id
 * @property $detalle
 * @property $contacto
 * @property $apellidos
 * @property $nombres
 * @property $created_at
 * @property $updated_at
 *
 * @property Circuito $circuito
 * @property Subcircuito $subcircuito
 * @property Treclamo $treclamo
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Reclamo extends Model
{
    
    static $rules = [
		'circuito_id' => 'required',
		'subcircuito_id' => 'required',
		'treclamo_id' => 'required',
		'detalle' => 'required',
		'contacto' => 'required',
		'apellidos' => 'required',
		'nombres' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['circuito_id','subcircuito_id','treclamo_id','detalle','contacto','apellidos','nombres'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function circuito()
    {
        return $this->hasOne('App\Models\Circuito', 'id', 'circuito_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function subcircuito()
    {
        return $this->hasOne('App\Models\Subcircuito', 'id', 'subcircuito_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function treclamo()
    {
        return $this->hasOne('App\Models\Treclamo', 'id', 'treclamo_id');
    }
    

}
