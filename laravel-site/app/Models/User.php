<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Hidden(['senha', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $table = '_tb_users';

    protected $primaryKey = 'id_user';

    public $timestamps = false;

    protected $fillable = [
        'nome',
        'login',
        'senha',
        'status',
        'unidade',
        'cod_nivel',
        'desc_nivel',
    ];

    public function getAuthPassword(): string
    {
        return (string) $this->senha;
    }

    public function getNameAttribute(): string
    {
        return (string) ($this->attributes['nome'] ?? $this->attributes['name_user'] ?? '');
    }

    public function getEmailAttribute(): string
    {
        return (string) ($this->attributes['login'] ?? $this->attributes['email_user'] ?? '');
    }

    public function isActive(): bool
    {
        return strtoupper((string) ($this->status ?? $this->status_user ?? '')) === 'ATIVO';
    }

    public function isAdmin(): bool
    {
        $level = strtolower((string) ($this->desc_nivel ?? $this->type_access ?? ''));
        $code = (string) ($this->cod_nivel ?? '');

        return $code === '0' || str_contains($level, 'admin');
    }

    protected function casts(): array
    {
        return [
            'id_user' => 'integer',
        ];
    }
}
