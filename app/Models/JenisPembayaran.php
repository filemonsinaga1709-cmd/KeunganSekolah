<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisPembayaran extends Model
{
    protected $table = 'jenis_pembayarans';

    protected $fillable = [
        'nama',
        'nominal',
    ];

    protected $casts = [
        'nominal' => 'decimal:2',
    ];

    // Relationships
    public function pembayarans()
    {
        return $this->hasMany(Pembayaran::class);
    }

    // Accessors
    public function getNominalFormatAttribute()
    {
        return 'Rp ' . number_format($this->nominal, 0, ',', '.');
    }
}