<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author_product extends Model
{
    use HasFactory;

    protected $table = "author_product";

    protected $guarded = [];
}
