<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;


class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'carnet_identidad',
        'nombre',
        'apellido_paterno',
        'apellido_materno',
        'telefono',
        'fecha_nacimiento',
        'jefe_id',
        // 'profile_photo_path',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function examenes()
    {
        return $this->hasMany(Examen::class);
    }

    public function ejecuciones(){
        return $this->belongsToMany(Ejecucion::class, 'calificacions', 'ejecucion_id', 'user_id')
                    ->withTimestamps();
    }

    public function anomalias()
    {
        return $this->belongsToMany(Ejecucion::class, 'anomalias', 'user_id', 'ejecucion_id')
                    ->withTimestamps();
    }

    public function jefe()
    {
        return $this->belongsTo(User::class, 'jefe_id');
    }

    public function subalternos()
    {
        return $this->hasMany(User::class, 'jefe_id');
    }

    public function grupo_materia()
    {
        return $this->belongsToMany(GrupoMateria::class, 'ingresos', 'user_id', 'grupo_materia_id')
                    ->withTimestamps();
    }


    public function grupo_materia_docente()
    {
        return $this->hasMany(GrupoMateria::class, 'user_docente_id');
    }

    public function comprobantes()
    {
        return $this->hasMany(Comprobante::class, 'user_estudiante_id');
    }
}
