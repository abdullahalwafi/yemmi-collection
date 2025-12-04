<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;

class ProductsExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Product::select(
            'name',
            'category_id',
            'qty',
            'capital_price',
            'price'
        )->with('category')->get();
    }
}
