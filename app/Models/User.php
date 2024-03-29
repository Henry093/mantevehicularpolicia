<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

/**
 * Class User
 *
 * @property $id
 * @property $name
 * @property $lastname
 * @property $cedula
 * @property $fecha_nacimiento
 * @property $sangre_id
 * @property $provincia_id
 * @property $canton_id
 * @property $parroquia_id
 * @property $telefono
 * @property $grado_id
 * @property $rango_id
 * @property $estado_id
 * @property $usuario
 * @property $email
 * @property $password
 * @property $email_verified_at
 * @property $remember_token
 * @property $created_at
 * @property $updated_at
 *
 * @property Canton $canton
 * @property Estado $estado
 * @property Grado $grado
 * @property Parroquia $parroquia
 * @property Provincia $provincia
 * @property Rango $rango
 * @property Sangre $sangre
 * @property Usubcircuito[] $usubcircuitos
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class User extends Authenticatable
{
    use HasRoles, HasApiTokens, HasFactory, Notifiable;


    static $rules = [
		'name' => 'required|max:50',
		'lastname' => 'required|max:50',
		'cedula' => 'required|numeric|unique:users,cedula|digits:10',
		'fecha_nacimiento' => 'required',
		'sangre_id' => 'required',
		'provincia_id' => 'required',
		'canton_id' => 'required',
		'parroquia_id' => 'required',
		'telefono' => 'required|numeric|unique:users,telefono|digits:10',
		'grado_id' => 'required',
		'rango_id' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name','lastname','cedula','fecha_nacimiento','sangre_id','provincia_id','canton_id','parroquia_id','telefono','grado_id','rango_id','estado_id','usuario','email','password'];


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
    public function grado()
    {
        return $this->hasOne('App\Models\Grado', 'id', 'grado_id');
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
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function rango()
    {
        return $this->hasOne('App\Models\Rango', 'id', 'rango_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function sangre()
    {
        return $this->hasOne('App\Models\Sangre', 'id', 'sangre_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function usersubcircuitos()
    {
        return $this->hasMany('App\Models\Usersubcircuito', 'user_id', 'id');
    }

     /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'estado_id',
        'usuario',
        'email'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    
    public function isAdmin()
    {
        // Obtener los roles del usuario
        $roles = $this->getRoleNames();
        
        // Verificar si alguno de los roles del usuario corresponde a un administrador
        return $roles->contains(function ($role) {
            return in_array($role, ['Administrador', 'Alta Gerencia', 'Técnico 1', 'Técnico 2']);
        });
    }

    public function asignarpertrechos()
    {
        return $this->hasMany(Asignarpertrecho::class);
    }
    
}
