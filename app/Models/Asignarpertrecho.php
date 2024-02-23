<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Asignarpertrecho
 *
 * @property $id
 * @property $pertrecho_id
 * @property $user_id
 * @property $created_at
 * @property $updated_at
 *
 * @property Pertrecho $pertrecho
 * @property User $user
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Asignarpertrecho extends Model
{
    
    static $rules = [
		'pertrecho_id' => 'required',
		'user_id' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['pertrecho_id','user_id'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function pertrecho()
    {
        return $this->hasOne('App\Models\Pertrecho', 'id', 'pertrecho_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }
    

}
