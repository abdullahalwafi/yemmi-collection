<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $fillable = [
        'tipe',
        'date',
        'product_id',
        'qty',
        'price',
        'ket',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
