<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens; 


class User extends Authenticatable implements MustVerifyEmail //Laravel gère automatiquement le champ email_verified_at.
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes, HasApiTokens;

     // Définir une constante pour les rôles autorisés
     public const ROLES = ['admin', 'customer'];

     public function orders()
    {
        return $this->hasMany(\App\Models\Order::class);
    }
    

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    

    
    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'password',
        'role',
        'birthdate',
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
}
