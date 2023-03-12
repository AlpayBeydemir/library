<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class ProductDetailController extends Controller
{
    public function ShowProduct($id)
    {
        // find user
        $user = Auth::user();
        $product = Product::findOrFail($id);

        $data = [
            "product" => $product,
            "user" => $user,
        ];

        return view('frontend.product.product_detail', $data);
    }
}
