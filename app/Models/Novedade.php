<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Novedade
 *
 * @property $id
 * @property $user_id
 * @property $mensaje
 * @property $atendida
 * @property $created_at
 * @property $updated_at
 *
 * @property User $user
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Novedade extends Model
{
    
    static $rules = [
		'user_id' => 'required',
		'mensaje' => 'required',
		'atendida' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id','mensaje','atendida'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }
    

}
