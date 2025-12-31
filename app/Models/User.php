<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relationships
    public function pembayarans()
    {
        return $this->hasMany(Pembayaran::class);
    }

    public function pemasukans()
    {
        return $this->hasMany(Pemasukan::class);
    }

    public function pengeluarans()
    {
        return $this->hasMany(Pengeluaran::class);
    }

    public function jurnals()
    {
        return $this->hasMany(Jurnal::class);
    }

    public function auditLogs()
    {
        return $this->hasMany(AuditLog::class);
    }

    // Helper methods for role checking
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isBendahara()
    {
        return $this->role === 'bendahara';
    }

    public function isTu()
    {
        return $this->role === 'tu';
    }

    public function isKepalaSekolah()
    {
        return $this->role === 'kepala_sekolah';
    }

    // Get role label
    public function getRoleLabelAttribute()
    {
        return match($this->role) {
            'admin' => 'Administrator',
            'bendahara' => 'Bendahara',
            'tu' => 'Tata Usaha',
            'kepala_sekolah' => 'Kepala Sekolah',
            default => ucfirst($this->role),
        };
    }

    // Get route prefix (untuk routing)
    public function getRoutePrefixAttribute()
    {
        return str_replace('_', '-', $this->role);
    }

    // Get available roles
    public static function getRoles()
    {
        return [
            'admin' => 'Administrator',
            'bendahara' => 'Bendahara',
            'tu' => 'Tata Usaha',
            'kepala_sekolah' => 'Kepala Sekolah',
        ];
    }
}