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

            // bir kullanıcı elinde 3 ten fazla kitap bulunduramaz.
            $user_count_book = BorrowProduct::where('user_id', $user->id)->where('delivered', 0)->count();

            if ($user_count_book >= 3)
                throw new \Exception("You Can Not Borrow Books More Than 3 At The Same Time");


            // kullanıcı aldığı kitabı teslim etmeden aynı kitabı kiralayamaz.(buton disabled)
            // kullanıcnın alıp henüz teslim etmediği kitaplar!
            $user_has_book = BorrowProduct::where('user_id', $user->id)->where('product_id', $id)->where('delivered', 0)->get();

            foreach ($user_has_book as $user_book){
                if ($user_book->product_id == $id)
                    throw new \Exception("You Can Not Borrow This Book Again Until You Deliver The Book");
            }

            // find category
            $category = $product->category_id;

            // type of delivery
            $type_of_delivery = $request->receive_type;
            if ($type_of_delivery == 1)
            {
                $user_address_id = $request->address;
            }

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
            if (isset($borrow_product->user_address_id) && !empty($borrow_product->user_address_id))
            {
                $borrow_product->user_address_id = $user_address_id;
            }
            $borrow_product->issued_date        = $issued_date;
            $borrow_product->delivered_date     = $delivered_date;
            $borrow_product->application_number = $app_number;

            $borrow_product->save();

            $jsonData = [
                "error" => 0,
                "msg" => "Product Borrowed Successfuly",
            ];

            return response()->json($jsonData);

        } catch (\Exception $e){

            $jsonData = [
                "error" => 1,
                "msg" => $e->getMessage()
            ];
            return response()->json($jsonData);
        }
    }

    public function ExtendTime(Request $request, $id)
    {
        try {
            if (empty($request->delivered_date))
            {
                throw new \Exception("Please Select New Deliver Time");
            }

            $borrow_product = BorrowProduct::find($id);

            // delivered time from form
            $new_delivered_date = $request->delivered_date;

            $borrow_product->delivered_date = $new_delivered_date;
            $borrow_product->save();

            $jsonData = [
                "error"   => 0,
                "msg" => "Your Delivered Date Time Is Extended",
            ];

            return response()->json($jsonData);

        } catch (\Exception $e)
        {
            $jsonData = [
                "error" => 1,
                "msg" => $e->getMessage()
            ];

            return response()->json($jsonData);
        }
    }
}
