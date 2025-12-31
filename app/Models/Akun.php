<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Akun extends Model
{
    protected $table = 'akuns';

    protected $fillable = [
        'kode_akun',
        'nama_akun',
        'tipe_akun',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Relationships
    public function pemasukans()
    {
        return $this->hasMany(Pemasukan::class);
    }

    public function pengeluarans()
    {
        return $this->hasMany(Pengeluaran::class);
    }

    public function jurnalDetails()
    {
        return $this->hasMany(JurnalDetail::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByTipe($query, $tipe)
    {
        return $query->where('tipe_akun', $tipe);
    }

    // Accessors
    public function getFullNameAttribute()
    {
        return "{$this->kode_akun} - {$this->nama_akun}";
    }
}