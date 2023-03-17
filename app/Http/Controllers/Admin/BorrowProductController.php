<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use  App\Models\User;
use  App\Models\User_address;
use  App\Models\Product;
use  App\Models\BorrowProduct;
use  App\Models\Categories;
use Illuminate\Support\Facades\Auth;

class BorrowProductController extends Controller
{
    public function BorrowProduct(Request $request, $id)
    {
        try {

            if (!isset($request->borrow_time) || empty($request->borrow_time)){
                throw new \Exception("Please Select For Days");
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

            // issued date
            $issued_date = date('Y-m-d');

            // delivered dates
            $delivered_date = $request->delivered_date;

            if ($delivered_date == 0){
                date('Y-m-d', strtotime($issued_date . ' + 7 days'));
            }
            elseif ($delivered_date == 1)
            {
                date('Y-m-d', strtotime($issued_date . ' + 14 days'));
            }
            else
            {
                date('Y-m-d', strtotime($issued_date . ' + 21 days'));
            }

            // application number
            $app_number = rand(1000000,10000000);

        } catch (\Exception $e){

            $jsonData = [
                "error" => 1,
                "message" => $e->getMessage()
            ];

            echo json_encode($jsonData);
        }





    }
}
