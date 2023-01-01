<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use http\Exception;
use App\Models\Product;
use App\Models\Author;
use App\Models\Categories;
use App\Models\Product_isbn;
use Illuminate\Support\Carbon;

class ProductController extends Controller
{
    public function index()
    {
        $data['authors'] = Product::all();
        return view("admin.book.book", $data);
    }

    public function AddBook()
    {
        $data['authors'] = Author::all();
        $data['categories'] = Categories::all();
        return view("admin.book.book_add", $data);
    }
}
