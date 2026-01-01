<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $table = 'pembayarans';

    protected $fillable = [
        'no_transaksi',
        'siswa_id',
        'jenis_pembayaran_id',
        'tanggal',
        'jumlah',
        'metode_pembayaran',
        'keterangan',
        'user_id',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jumlah' => 'decimal:2',
    ];

    // Relationships
    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function jenisPembayaran()
    {
        return $this->belongsTo(JenisPembayaran::class);
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

    public function scopeByMetode($query, $metode)
    {
        return $query->where('metode_pembayaran', $metode);
    }

    // Accessors
    public function getJumlahFormatAttribute()
    {
        return 'Rp ' . number_format($this->jumlah, 0, ',', '.');
    }

    // Boot method untuk auto generate no_transaksi
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->no_transaksi)) {
                $model->no_transaksi = 'PAY-' . date('Ymd') . '-' . str_pad(static::whereDate('created_at', today())->count() + 1, 4, '0', STR_PAD_LEFT);
            }
        });
    }
}