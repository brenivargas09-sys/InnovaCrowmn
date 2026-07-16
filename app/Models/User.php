<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'username',
        'email',
        'password',
        'role',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function client()
    {
        return $this->hasOne(Client::class);
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isRecepcionista(): bool
    {
        return $this->role === 'recepcionista';
    }

    public function isCliente(): bool
    {
        return $this->role === 'cliente';
    }

    public function getFullNameAttribute(): string
    {
        $client = $this->client;
        if ($client) {
            return $client->first_name . ' ' . $client->last_name;
        }
        return $this->username;
    }
}
