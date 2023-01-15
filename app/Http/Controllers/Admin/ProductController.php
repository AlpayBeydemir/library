<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product_author;
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
        $data['products'] = Product::all();
//        $data['author'] = Product::with('author')->get();
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
            if (!isset($request->author_id) || empty($request->author_id)){
                throw new \Exception("Please Select Author");
            }

            if (!isset($request->category_id) || empty($request->category_id) || trim($request->category_id) == ""){
                throw new \Exception("Please Select Category");
            }

            if (!isset($request->name) || empty($request->name || trim($request->name) == "")) {
                throw new \Exception("Please Enter Book Name");
            }

            if (!isset($request->publisher) || empty($request->publisher || trim($request->publisher) == "")) {
                throw new \Exception("Please Enter Publisher Name");
            }

            if (!isset($request->publication_year) || empty($request->publication_year || trim($request->publication_year) == "")) {
                throw new \Exception("Please Enter Publisher Year");
            }

            if (!isset($request->language) || empty($request->language || trim($request->language) == "")) {
                throw new \Exception("Please Enter Publisher Year");
            }

            if (!isset($request->stock) || empty($request->stock)) {
                throw new \Exception("Please Enter Stock Number");
            }

            if (!isset($request->isbn) || empty($request->isbn)) {
                throw new \Exception("Please Enter Stock Number");
            }

            if (!$request->file('image')) {
                throw new \Exception("Please Upload Image");
            }
            else {
                // Image Upload
                $image_extension = $request->file('image')->getClientOriginalExtension();
                if ($image_extension == "jpg" || "jpeg" || "png")
                {
                    $image = $request->file('image');
                    $image_name = date('YmdHi'). '.' . $image->getClientOriginalName();
                    $image_upload = $image->storeAs('uploads', $image_name, 'public');
//                    $image_upload = $request->file('image')->move(public_path('images'), $image_name);
                }
                else {
                    throw new \Exception("Please Upload '.jpg', '.jpeg' or '.png' File");
                }
            }
//            if (is_array($request->isbn))
//            {
//                foreach ($request->isbn as $key => $value)
//                {
//                    if (!isset($value) || empty($value))
//                    {
//                        throw new \Exception("Please Enter ISBN Number");
//                    }
//                }
//            }


//dd($request);

            // Insert Product Table
            $product = new Product();

            $product->category_id      = $request->category_id;
            $product->name             = $request->name;
            $product->publisher        = $request->publisher;
            $product->publication_year = $request->publication_year;
            $product->language         = $request->language;
            $product->stock            = $request->stock;
            $product->isbn             = $request->isbn;
            $product->image            = $image_upload;
//            $product->is_active   = 0;
//            $product->created_at  = Carbon::now();
            $product->save();
//dd($product);

            // Insert Product Isbn Table

            foreach ($request->author_id as $key => $value)
            {
                $product_author_new = new Product_author();

                $product_author_new->product_id   = $product->id;
                $product_author_new->author_id    = $value;

                $product_author_new->save();
             }


            $jsonData = [
              "error" => 0,
              "message" => "Product Inserted Successfuly",
              "url" => route("product")
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

    public function EditProduct($id)
    {
        $data['authors']    = Author::all();
        $data['categories'] = Categories::all();
        $data['products']   = Product::findOrFail($id);
        return view("admin.product.product_edit", $data);
    }

    public function UpdateProduct(Request $request, $id)
    {
        try {
            if (!isset($request->author_id) || empty($request->author_id) || trim($request->author_id  ) == ""){
                throw new \Exception("Please Select Author");
            }

            if (!isset($request->category_id) || empty($request->category_id) || trim($request->category_id) == ""){
                throw new \Exception("Please Select Category");
            }

            if (!isset($request->name) || empty($request->name || trim($request->name) == "")) {
                throw new \Exception("Please Enter Book Name");
            }

            if (!isset($request->stock) || empty($request->name)) {
                throw new \Exception("Please Enter Stock Number");
            }

            if (!$request->file('image')) {
                throw new \Exception("Please Upload Image");
            }
            else {
                // Image Upload
                $image_extension = $request->file('image')->getClientOriginalExtension();
                if ($image_extension == "jpg" || "jpeg" || "png")
                {
                    $image = $request->file('image');
                    $image_name = date('YmdHi'). '.' . $image->getClientOriginalName();
                    $image_upload = $image->storeAs('uploads', $image_name, 'public');
//                    $image_upload = $request->file('image')->move(public_path('images'), $image_name);
                }
                else {
                    throw new \Exception("Please Upload '.jpg', '.jpeg' or '.png' File");
                }
            }

//dd($request);

            // Insert Product Table
            $product = Product::find($id);

            $product->author_id   = $request->author_id;
            $product->category_id = $request->category_id;
            $product->name        = $request->name;
            $product->stock       = $request->stock;
            $product->image       = $image_upload;

            $product->update();


            // Insert Product Isbn Table
            create_isbn($request->stock, $product->id);

            $jsonData = [
                "error" => 0,
                "message" => "Product Inserted Successfuly",
                "url" => route("product")
            ];

            echo json_encode($jsonData);

        }
        catch (\Exception $e){

            $jsonData = [
                "error" => 1,
                "message" => $e->getMessage()
            ];

            echo json_encode($jsonData);
        }
    }
}
