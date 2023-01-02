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
        return view("admin.product.product", $data);
    }

    public function AddProduct()
    {
        $data['authors'] = Author::all();
        $data['categories'] = Categories::all();
        return view("admin.product.product_add", $data);
    }

    public function StoreProduct(Request $request)
    {
        try {
            if (!isset($request->author_id) || empty($request->author_id) || trim($request->author_id  == "")){
                throw new \Exception("Please Select Author");
            }

            if (!isset($request->category_id) || empty($request->category_id) || trim($request->category_id  == "")){
                throw new \Exception("Please Select Category");
            }

            if (!isset($request->name) || empty($request->name || trim($request->name == ""))) {
                throw new \Exception("Please Enter Book Name");
            }

            if (!isset($request->image) || empty($request->image)) {
                throw new \Exception("Please Upload Image");
            } else {
                $image_extension = $request->file('image')->getClientOriginalExtension();
                if ($image_extension != ".jpg" || ".jpeg" || ".png"){
                    throw  new \Exception("Please Upload '.jpg', '.jpeg' or '.png' File");
                } else {
                    $image_name = $request->image . "." . $image_extension;
                    $image_upload = $request->file('image')->move(public_path('images'), $image_name);
                }
            }

            // Insert Product Table
            $product = new Product();

            $product->author_id   = $request->author_id;
            $product->category_id = $request->category_id;
            $product->name        = $request->name;
            $product->image       = $image_upload;
            $product->is_active   = 1;
            $product->created_at  = Carbon::now();

            $product->save();

            // Insert Product Isbn Table
            $product_isbn = new Product_isbn();

            for ($i = 0; $i < count($request->isbn); $i++){
                $product_isbn->product_id   = $product["isbn"]["id"]; // HATA
                $product_isbn->product_isbn = $request->isbn;
                $product_isbn->created_at   = Carbon::now();

                $product_isbn->save();
            }

            if ($product->save() && $product_isbn->save()){

                $notification = array(
                    'message'    => 'Product Inserted Successfully',
                    'alert-type' => 'success'
                );

                return redirect()->route('product')->with($notification);
            }

        }
        catch (\Exception $e){
            $notification = array(
                "message"    => $e->getMessage(),
                "alert-type" => "error",
            );

            return back()->with($notification);
        }
    }
}
