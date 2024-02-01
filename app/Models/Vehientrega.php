<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Vehientrega
 *
 * @property $id
 * @property $vehirecepciones_id
 * @property $fecha_entrega
 * @property $p_retiro
 * @property $km_actual
 * @property $km_proximo
 * @property $observaciones
 * @property $created_at
 * @property $updated_at
 *
 * @property Vehirecepcione $vehirecepcione
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Vehientrega extends Model
{
    
    static $rules = [
		'vehirecepciones_id' => 'required',
		'fecha_entrega' => 'required',
		'p_retiro' => 'required',
		'km_actual' => 'required',
		'observaciones' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['vehirecepciones_id','fecha_entrega','p_retiro','km_actual','km_proximo','observaciones'];
    
    protected $hidden = [
      'km_proximo',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function vehirecepcione()
    {
        return $this->hasOne('App\Models\Vehirecepcione', 'id', 'vehirecepciones_id');
    }
    
    // Evento que se ejecuta antes de guardar el modelo
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($vehientrega) {
            $mantetipo = $vehientrega->vehirecepcione->mantetipo; // Obtén el tipo de mantenimiento asociado

            // Lógica para calcular km_proximo
            if ($mantetipo->id == 1 || $mantetipo->id == 2 || $mantetipo->id == 4) {
                $vehientrega->km_proximo = $vehientrega->km_actual + 5000;
            } elseif ($mantetipo->id == 3) {
                $vehientrega->km_proximo = $vehientrega->km_actual + 2000;
            }
        });
    }

}
