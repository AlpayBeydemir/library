<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use http\Exception;
use App\Models\Product;
use App\Models\Author;
use App\Models\Categories;
use App\Models\Product_isbn;
use Intervention\Image\Facades\Image;
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

            if (!$request->file('image')) {
                throw new \Exception("Please Upload Image");
            } else {
                $image_extension = $request->file('image')->getClientOriginalExtension();
                if ($image_extension != ".jpg" || ".jpeg" || ".png"){
                    throw new \Exception("Please Upload '.jpg', '.jpeg' or '.png' File");
                } else {
                    $image_name = $request->file('image') . "." . $image_extension;
                    $image_upload = $request->file('image')->move(public_path('images'), $image_name);
                }
            }
//dd($request);

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
            if (!isset($request->isbn) || empty($request->isbn || trim($request->isbn == ""))) {
                throw new \Exception("Please Enter ISBN Number");
            } else {
                foreach ($request->isbn as $key => $value){

                    $product_isbn = new Product_isbn();
                    $product_isbn->product_id   = $product->id;
                    $product_isbn->product_isbn = $request->isbn;
                    $product_isbn->created_at   = Carbon::now();

                    $product_isbn->save();
                }
            }

            $jsonData = [
              "error" => 0,
              "message" => "Product Inserted Successfuly",
              'url' => route("product")
            ];

            echo json_encode($jsonData);

        }
        catch (\Exception $e){
//            $notification = array(
//                "message"    => $e->getMessage(),
//                "alert-type" => "error",
//            );

            $jsonData = [
                "error" => 1,
                "message" => $e->getMessage()
            ];

            echo json_encode($jsonData);
        }
    }
}
