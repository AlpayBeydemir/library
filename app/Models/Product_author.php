<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product_author extends Model
{
    use HasFactory;

    protected $table = "product_author";

    protected $guarded = [];
}
