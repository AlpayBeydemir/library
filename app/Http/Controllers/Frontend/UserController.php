<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\BorrowProduct;
use App\Models\User;
use App\Models\User_address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
//    public function __construct(Auth $user)
//    {
//        $this->user = $user;
//    }

    public function my_information()
    {
        $user = Auth::user();

        $data = [
            'profile' => $user,
        ];

        return view('frontend.user_profile.profile', $data);
    }

    public function AddAddress(Request $request)
    {
        try {

            if (!isset($request->address_name) || empty($request->address_name)){
                throw new \Exception("Please Enter Address Name");
            }

            if (!isset($request->address) || empty($request->address)){
                throw new \Exception("Please Enter Address");
            }

            // find user
            $user = Auth::user();

            $address = new User_address();

            $address->user_id      = $user->id;
            $address->address_name = $request->address_name;
            $address->address      = $request->address;

            $address->save();

            $jsonData = [
                "error" => 0,
                "msg" => "Address Saved Successfuly",
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

    public function DeleteAddress($id)
    {
        try {
            $address = User_address::find($id);
            if (!$address){
                throw new \Exception("The Address Could Not Found");
            }
            else {
                $deleted_address = User_address::find($id)->delete($address);
                if (!$deleted_address){
                    throw new \Exception("The Address Could Not Delete. Please Try Again Later.");
                }
                else {
                    $notification = array(
                        'message'    => 'Address Deleted Successfully',
                        'alert-type' => 'success'
                    );

                    return redirect()->back()->with($notification);
                }
            }
        }
        catch (\Exception $e){
            $notification = array(
                'message'    => $e->getMessage(),
                'alert-type' => 'error'
            );

            return redirect()->back()->with($notification);
        }
    }

    public function Orders()
    {
        $user = Auth::user();

        $userProducts = BorrowProduct::where('user_id', $user->id)->get();

        $data = [
            'profile' => $user,
            'userProducts' => $userProducts,
        ];

        return view('frontend.user_profile.orders', $data);
    }

    public function UpdateProfile(Request $request)
    {
        try {

            $id = $request->id;

            if (!$id){
                throw new \Exception("Kullanıcı id bilgisi bulunamadı");
            }

            $name = $request->name;
            $email = $request->email;

            $user = User::find($id);

            if (!$user){
                throw new \Exception("Kullanıcı Bulunamadı");
            }

            $user->name  = $name;
            $user->email = $email;

            $user->save();

            $jsonData = [
                "error" => 0,
                "msg" => "İşlem Başarılı"
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
}
