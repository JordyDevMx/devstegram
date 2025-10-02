<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'username'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function posts()
    {
        return $this->hasMany(Post::class)->select([
            'name',
            'username'
        ]);
    }

    public function likes() 
    {
        return $this->hasMany(Like::class);
    }

    // Almacena los seguidores de un usuario
    public function followers()
    {
        return $this->belongsToMany(User::class, 'followers', 'user_id', 'follower_id');  
        // En caso que te salgas de las convenciones de laravel es necesario agregar el campo de la tabla que esta relacionada y las llaves foraneas -> 'followers', 'user_id', 'follower_id'
    }

    // Almacena los que seguimos
    public function followings()
    {
        return $this->belongsToMany(User::class, 'followers', 'follower_id', 'user_id');  
        // Para tomar el valor al revez se cambian las columnas en este caso -> 'follower_id', 'user_id'
    }

    // Comprobar si una persona sigue a otro
    public function siguiendo(User $user)
    {
        return $this->followers->contains( $user->id ); // El metodo contains funciona que va leer la funcion que le indicas  en este caso followers
    }
}
