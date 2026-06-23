<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

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
        // JANGAN cast passwordHash sebagai 'hashed' karena kita sudah meng-hash
        // secara manual dengan Hash::make() di controller.
        // Cast 'hashed' akan menyebabkan double-hashing: hash(hash(password))
        // yang menyebabkan verifikasi password selalu gagal.
        return [];
    }
}
