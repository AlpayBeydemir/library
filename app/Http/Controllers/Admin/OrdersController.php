<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Categories;
use App\Models\Product;
use App\Models\BorrowProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrdersController extends Controller
{
    public function GetOrders()
    {
        $user = Auth::user();

        $products = Product::with('author')->get();
        $orders = BorrowProduct::all();
        $authors = Author::all();
        $categories = Categories::where('is_active', 1)->get();

        $data = [
            'products'      => $products,
            'orders'        => $orders,
            'authors'       => $authors,
            'categories'    => $categories,
        ];
//        dd($data);

        return view("admin.orders.orders_list", $data);
    }

    public function AdminExtendTime(Request $request, $id)
    {
        $id = $request->id;

        $findProduct = BorrowProduct::find($id);

        $findProduct->delivered_date = $request->delivered_date;
        $findProduct->save();

        $notification = array(
            'message'    => 'Delivered Time Extended Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('GetOrders')->with($notification);
    }

    public function AdminReceiveProduct(Request $request, $id)
    {
        $id = $request->id;

        $findProduct = BorrowProduct::find($id);

        $findProduct->delivered = 1;

        if ($findProduct->delivered_date >= date('Y-m-d'))
        {
            $findProduct->on_time = 1;
            $message = "The Customer Gave Back Product On Time.";
        }
        else
        {
            $findProduct->on_time = 0;
            $message = "The Customer Gave Back Product Delay.";
        }

        $findProduct->save();

        if ($findProduct->save())
        {
            $notification = array(
                'message'    => $message,
                'alert-type' => 'success'
            );

            return redirect()->route('GetOrders')->with($notification);
        }
    }

}
