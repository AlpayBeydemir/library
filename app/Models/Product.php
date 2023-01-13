<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function author()
    {
        return $this->belongsTo(Author::class, "author_id", "id");
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
