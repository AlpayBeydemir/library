<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BorrowProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BorrowProductController extends Controller
{
    public function BorrowProduct(Request $request, $id)
    {
        try {
//            dd($request);
            if (!isset($request->for_days) || empty($request->for_days)){
                throw new \Exception("Please Select Time");
            }

            if (!isset($request->receive_type) || empty($request->receive_type)){
                throw new \Exception("Please Select Receive Type");
            } else {
                if (!isset($request->address) || empty($request->address)){
                    throw new \Exception("Please Select Deliver Address");
                }
            }

            // find user
            $user = Auth::user();

            // find product
            $product = Product::findOrFail($id);

            // find category
            $category = $product->category_id;

            // type of delivery
            $type_of_delivery = $request->receive_type;
            if ($type_of_delivery == 1)
            {
                $user_address_id = $request->address;
            }
//            dd($user_address_id);

            // issued date
            $issued_date = date('Y-m-d');

            // delivered dates
            $for_days = $request->for_days;
            $delivered_date = '';
            if ($for_days == 7){
                $delivered_date = date('Y-m-d', strtotime($issued_date . ' + 7 days'));
            }
            elseif ($for_days == 14)
            {
                $delivered_date = date('Y-m-d', strtotime($issued_date . ' + 14 days'));
            }
            else
            {
                $delivered_date = date('Y-m-d', strtotime($issued_date . ' + 21 days'));
            }

            // application number
            $app_number = rand(1000000,10000000);

            $borrow_product = new BorrowProduct();

            $borrow_product->user_id            = $user->id;
            $borrow_product->product_id         = $product->id;
            $borrow_product->category_id        = $product->category_id;
            $borrow_product->type_of_delivery   = $type_of_delivery;
            $borrow_product->user_address_id    = $user_address_id;
            $borrow_product->issued_date        = $issued_date;
            $borrow_product->delivered_date     = $delivered_date;
            $borrow_product->application_number = $app_number;

            $borrow_product->save();

            $jsonData = [
                "error" => 0,
                "message" => "Product Borrowed Successfuly",
                "url" => route("profile")
            ];

            echo json_encode($jsonData);

        } catch (\Exception $e){

            $jsonData = [
                "error" => 1,
                "message" => $e->getMessage()
            ];

            echo json_encode($jsonData);
        }
    }
}
