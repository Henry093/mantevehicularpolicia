<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Provincia
 *
 * @property $id
 * @property $nombre
 * @property $created_at
 * @property $updated_at
 *
 * @property Cantone[] $cantones
 * @property Parroquia[] $parroquias
 * @property User[] $users
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Provincia extends Model
{
    
    static $rules = [
		'nombre' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['nombre'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cantones()
    {
        return $this->hasMany(Canton::class, 'App\Models\Cantone', 'provincia_id', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function parroquias()
    {
        return $this->hasMany('App\Models\Parroquia', 'provincia_id', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany('App\Models\User', 'provincia_id', 'id');
    }
    

}
