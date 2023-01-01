<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product_isbn extends Model
{
    use HasFactory;

    protected $guarded = [];

    // A product_isbn model belongs to a product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
