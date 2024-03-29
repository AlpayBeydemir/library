<?php

namespace App\Http\Controllers;

use App\Models\EventModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\Product;


class CustomAuthController extends Controller
{
    public function index()
    {
        return view('frontend.authentication.auth_login');
    }

    public function registration()
    {
        return view('frontend.authentication.auth_registration');
    }

    public function customRegistration(Request $request)
    {
        try {
            if (!isset($request->email) || empty($request->email)){
                throw new \Exception("Please Enter Email");
            }
            if (!isset($request->name) || empty($request->name)){
                throw new \Exception("Please Enter Name");
            }
            if (!isset($request->password) || empty($request->password)){
                throw new \Exception("Please Enter Password");
            }

            $user = new User();

            $user->email     = $request->email;
            $user->name      = $request->name;
            $user->password  = Hash::make($request->password);

            $user->save();

            $jsonData = [
                "error"     => 0,
                "message"   => "You Have Registered Successfuly",
                "url"       => route("login")
            ];

            return response()->json($jsonData);

        }catch (\Exception $e){

            $jsonData = [
                "error"    => 1,
                "message"  => $e->getMessage()
            ];

            return response()->json($jsonData);
        }
    }

    public function customLogin(Request $request)
    {
        $credentials = $request->validate([
            "email"     => ['required', 'email'],
            "password"  => ['required'],
        ]);

        if (Auth::attempt($credentials)){
            $request->session()->regenerate();

            if (Auth::user()->type == "admin" || Auth::user()->type == "manager" )
                return redirect()->intended('/admin');


            if (Auth::user()->type == "user")
                return redirect()->intended('/library');

        }

        return back()->withErrors([
            'email' => 'The email does not match.',
            'password' => 'The password does not match.',
        ]);

    }

    public function Library()
    {
        if (!Auth::check()){
            return redirect('login');
        }
        else
        {
            $products = Product::orderBy("id", "DESC")->take(10)->get();
            $events   = EventModel::where('deleted',0)->orderBy('selected_time', 'DESC')->limit(5)->get();

            $data = [
                'products' => $products,
                'events'   => $events
            ];

            return view('frontend.home',$data);
        }
    }

    public function Logout()
    {
        Session::flush();
        Auth::logout();

        return redirect('login');
    }
}
