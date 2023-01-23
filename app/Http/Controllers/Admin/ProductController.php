<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Author_product;
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
        $data['products'] = Product::with('author')->get();
//        dd($data);

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

            $product->save();
//dd($product);

            // Insert Author_product Table

            foreach ($request->author_id as $key => $value)
            {
                $author_product_new = new Author_product();

                $author_product_new->author_id    = $value;
                $author_product_new->product_id   = $product->id;

                $author_product_new->save();
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
        $authors = Author::all();
        $data['categories'] = Categories::all();
        $products = Product::findOrFail($id);
        $selected = [];
        foreach ($products->author as $product){
            $selected[] = $product->id;
        }
        foreach ($authors as $author){
            if (in_array($author->id, $selected)){
                $author->selected = 1;
            }
            else{
                $author->selected = 0;
            }
        }

        $data['products'] = $products;
        $data['authors'] = $authors;
//        dd($authors);
        return view("admin.product.product_edit", $data);
    }

    public function UpdateProduct(Request $request, $id)
    {
        try {
            if (!isset($request->author_id) || empty($request->author_id)){
                throw new \Exception("Please Select Author");
            }

            if (!isset($request->category_id) || empty($request->category_id)){
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

            if ($request->file('image')) {
                // Image Upload
                $image_extension = $request->file('image')->getClientOriginalExtension();
                if ($image_extension == "jpg" || "jpeg" || "png")
                {
                    $image = $request->file('image');
                    $image_name = date('YmdHi'). '.' . $image->getClientOriginalName();
                    $image_upload = $image->storeAs('uploads', $image_name, 'public');

                    // Insert Author_product Table
//                    foreach ($request->author_id as $key => $value)
//                    {
////                        $author_product = Author_product::find($id);
////
////                        $author_product->author_id    = $value;
////                $author_product->product_id   = $product->id;
//
////                        $author_product->save();
//
//                        $update_author = Author_product::where('product_id', $id)->get();
//                        dd($update_author);
//                        if ($update_author){
//                            $update_author->author_id = $value;
//                            $update_author->update();
//                        }
//                    }
                }
                else {
                    throw new \Exception("Please Upload '.jpg', '.jpeg' or '.png' File");
                }
            }

            // Update Product Table
            $product = Product::find($id);

            $product->category_id      = $request->category_id;
            $product->name             = $request->name;
            $product->publisher        = $request->publisher;
            $product->publication_year = $request->publication_year;
            $product->language         = $request->language;
            $product->stock            = $request->stock;
            $product->isbn             = $request->isbn;
            if (isset($image_upload) && !empty($image_upload))
            {
                $product->image =  $image_upload;
            }
            $product->update();


            // Insert Author_product Table
            foreach ($request->author_id as $key => $value)
            {
                $author_product = Author_product::find($id);

                $author_product->author_id    = $value;
//                $author_product->product_id   = $product->id;

                $author_product->update();
            }

            $jsonData = [
                "error" => 0,
                "message" => "Product Updated Successfuly",
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
