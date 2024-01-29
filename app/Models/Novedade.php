<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Novedade
 *
 * @property $id
 * @property $user_id
 * @property $mensaje
 * @property $tnovedad_id
 * @property $created_at
 * @property $updated_at
 *
 * @property Tnovedade $tnovedade
 * @property User $user
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Novedade extends Model
{
    
    static $rules = [
		'user_id' => 'required',
		'mensaje' => 'required',
    ];

    protected $perPage = 20;

    protected $hidden = [
        'tnovedad_id',
    ];
    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id','mensaje','tnovedad_id'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function tnovedade()
    {
        return $this->hasOne('App\Models\Tnovedade', 'id', 'tnovedad_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }
    

}
