<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JurnalDetail extends Model
{
    protected $fillable = [
        'jurnal_id',
        'akun_id',
        'debit',
        'kredit',
    ];

    protected $casts = [
        'debit' => 'decimal:2',
        'kredit' => 'decimal:2',
    ];

    // Relationships
    public function jurnal()
    {
        return $this->belongsTo(Jurnal::class);
    }

    public function akun()
    {
        return $this->belongsTo(Akun::class);
    }

    // Accessors
    public function getDebitFormatAttribute()
    {
        return $this->debit > 0 ? 'Rp ' . number_format($this->debit, 0, ',', '.') : '-';
    }

    public function getKreditFormatAttribute()
    {
        return $this->kredit > 0 ? 'Rp ' . number_format($this->kredit, 0, ',', '.') : '-';
    }
}