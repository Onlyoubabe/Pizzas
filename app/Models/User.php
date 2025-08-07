<?php
namespace App\Models;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', 
        'email',
        'password',
        'role',
        'google_id', // Añadido para autenticación con Google
        'avatar',    // Opcional: para guardar la URL del avatar de Google
    ];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
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
    /**
     * Verifica si el usuario es un administrador.
     *
     * @return bool
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }
    /**
     * Verifica si el usuario es un usuario regular.
     *
     * @return bool
     */
    public function isUser()
    {
        return $this->role === 'usuario';
    }
    /**
     * Verifica si el usuario es un empleado.
     *
     * @return bool
     */
    public function isEmpleado()
    {
        return $this->role === 'empleado';
    }
    
    /**
     * Relación con las órdenes del usuario.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}