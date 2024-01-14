<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Dependencia
 *
 * @property $id
 * @property $provincia_id
 * @property $num_distritos
 * @property $canton_id
 * @property $parroquia_id
 * @property $cod_distrito
 * @property $nom_distrito
 * @property $num_circuitos
 * @property $cod_circuito
 * @property $nom_circuito
 * @property $num_subcircuitos
 * @property $cod_subcircuito
 * @property $nom_subcircuito
 * @property $estado_id
 * @property $created_at
 * @property $updated_at
 *
 * @property Canton $canton
 * @property Estado $estado
 * @property Parroquia $parroquia
 * @property Provincia $provincia
 * @property Usubcircuito[] $usubcircuitos
 * @property Vsubcircuito[] $vsubcircuitos
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Dependencia extends Model
{
    
    static $rules = [
		'provincia_id' => 'required',
		'canton_id' => 'required',
		'parroquia_id' => 'required',
		'cod_distrito' => 'required',
		'nom_distrito' => 'required',
		'cod_circuito' => 'required',
		'nom_circuito' => 'required',
		'cod_subcircuito' => 'required',
		'nom_subcircuito' => 'required',
		'estado_id' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['provincia_id','num_distritos','canton_id','parroquia_id','cod_distrito','nom_distrito','num_circuitos','cod_circuito','nom_circuito','num_subcircuitos','cod_subcircuito','nom_subcircuito','estado_id'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function canton()
    {
        return $this->hasOne('App\Models\Canton', 'id', 'canton_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function estado()
    {
        return $this->hasOne('App\Models\Estado', 'id', 'estado_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function parroquia()
    {
        return $this->hasOne('App\Models\Parroquia', 'id', 'parroquia_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function provincia()
    {
        return $this->hasOne('App\Models\Provincia', 'id', 'provincia_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function usubcircuitos()
    {
        return $this->hasMany('App\Models\Usubcircuito', 'dependencia_id', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function vsubcircuitos()
    {
        return $this->hasMany('App\Models\Vsubcircuito', 'dependencia_id', 'id');
    }
    

}
