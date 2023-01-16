<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = "products";
    protected $guarded = [];

    public function author()
    {
//        return $this->belongsToMany(Author::class, "author_product", "product_id", "author_id");
        return $this->belongsToMany(Author::class);
    }

    public function category()
    {
        return $this->belongsTo(Categories::class, "category_id", "id");
    }



//    public function isbn()
//    {
//        return $this->belongsTo(Product_isbn::class, "product_id", "id");
//    }

//    public function isbn()
//    {
//        return $this->hasMany(Product_isbn::class);
//    }
}
