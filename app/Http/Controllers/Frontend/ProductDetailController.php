<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductDetailController extends Controller
{
    public function ShowProduct($id)
    {
        $product = Product::findOrFail($id);

        $data['product'] = $product;

        return view('frontend.product.product_detail', $data);
    }
}
