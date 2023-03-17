<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_address extends Model
{
    use HasFactory;

    protected $table = "user_addresses";
    protected $guarded = [];

    public function borrow_product_deliver()
    {
        return $this->hasMany(BorrowProduct::class);
    }
}
