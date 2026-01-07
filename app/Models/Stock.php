<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'date' => 'date',
    ];

    protected static function booted(): void
    {
        static::creating(function (Stock $stock) {
            // invoice wajib, jadi isi otomatis kalau kosong
            if (blank($stock->invoice ?? null)) {
                $stock->invoice = 'STK-' . now()->format('Ymd-His') . '-' . str_pad((string) random_int(0, 999), 3, '0', STR_PAD_LEFT);
            }
        });
    }

    public function items()
    {
        return $this->hasMany(StockItem::class);
    }
}
