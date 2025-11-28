<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Crypt;

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
        'plain_password',
        'encrypted_password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'plain_password',
        'encrypted_password',
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

    /**
     * Mutator untuk plain_password - encrypt sebelum disimpan
     */
    public function setPlainPasswordAttribute(?string $value): void
    {
        if ($value) {
            $this->attributes['encrypted_password'] = Crypt::encryptString($value);
        }
    }

    /**
     * Accessor untuk plain_password - decrypt saat diambil
     */
    public function getPlainPasswordAttribute(): ?string
    {
        if ($this->attributes['encrypted_password'] ?? null) {
            try {
                return Crypt::decryptString($this->attributes['encrypted_password']);
            } catch (\Exception $e) {
                return null;
            }
        }

        return null;
    }

    public function pembina()
    {
        return $this->hasOne(Pembina::class);
    }

    public function peserta()
    {
        return $this->hasOne(Peserta::class);
    }
}
