<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Illuminate\Database\Eloquent\Concerns\HasUuids;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasUuids;

    protected $fillable = ['name', 'nim', 'fakultas', 'prodi', 'email', 'passwordHash', 'role'];

    protected $hidden = ['passwordHash', 'remember_token'];

    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';

    public function getAuthPassword()
    {
        return $this->passwordHash;
    }

    public function getAuthPasswordName()
    {
        return 'passwordHash';
    }

    public function attempts()
    {
        return $this->hasMany(\App\Models\TestAttempt::class, 'userId', 'id');
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'passwordHash' => 'hashed',
        ];
    }
}
