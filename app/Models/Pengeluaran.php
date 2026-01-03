<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Pengeluaran extends Model
{
    protected $table = 'pengeluarans';

    protected $fillable = [
        'no_transaksi',
        'tanggal',
        'kategori',
        'keterangan',
        'jumlah',
        'bukti_pembayaran',
        'akun_id',
        'user_id',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jumlah' => 'decimal:2',
    ];

    // Relationships
    public function akun()
    {
        return $this->belongsTo(Akun::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jurnal()
    {
        return $this->morphOne(Jurnal::class, 'ref', 'ref_tipe', 'ref_id');
    }

    // Scopes
    public function scopeByPeriode($query, $startDate, $endDate)
    {
        return $query->whereBetween('tanggal', [$startDate, $endDate]);
    }

    public function scopeByKategori($query, $kategori)
    {
        return $query->where('kategori', $kategori);
    }

    // Accessors
    public function getJumlahFormatAttribute()
    {
        return 'Rp ' . number_format($this->jumlah, 0, ',', '.');
    }

    public function getBuktiUrlAttribute()
    {
        return $this->bukti_pembayaran ? Storage::url($this->bukti_pembayaran) : null;
    }

    // Boot method
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->no_transaksi)) {
                $model->no_transaksi = 'OUT-' . date('Ymd') . '-' . str_pad(static::whereDate('created_at', today())->count() + 1, 4, '0', STR_PAD_LEFT);
            }
        });

        static::deleting(function ($model) {
            if ($model->bukti_pembayaran) {
                Storage::delete($model->bukti_pembayaran);
            }
        });
    }
}