<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jurnal extends Model
{
    protected $table = 'jurnals';

    protected $fillable = [
        'no_jurnal',
        'tanggal',
        'keterangan',
        'jenis',
        'ref_tipe',
        'ref_id',
        'user_id',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    // Relationships
    public function details()
    {
        return $this->hasMany(JurnalDetail::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Polymorphic relationship
    public function ref()
    {
        return $this->morphTo(__FUNCTION__, 'ref_tipe', 'ref_id');
    }

    // Scopes
    public function scopeByPeriode($query, $startDate, $endDate)
    {
        return $query->whereBetween('tanggal', [$startDate, $endDate]);
    }

    public function scopeByJenis($query, $jenis)
    {
        return $query->where('jenis', $jenis);
    }

    // Accessors
    public function getTotalDebitAttribute()
    {
        return $this->details()->sum('debit');
    }

    public function getTotalKreditAttribute()
    {
        return $this->details()->sum('kredit');
    }

    public function getIsBalancedAttribute()
    {
        return $this->total_debit == $this->total_kredit;
    }

    // Boot method
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->no_jurnal)) {
                $model->no_jurnal = 'JRN-' . date('Ymd') . '-' . str_pad(static::whereDate('created_at', today())->count() + 1, 4, '0', STR_PAD_LEFT);
            }
        });
    }
}