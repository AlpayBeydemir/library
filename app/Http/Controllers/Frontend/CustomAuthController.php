<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


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
            $user->password  = $request->password;

            $user->save();

            $jsonData = [
                "error"     => 0,
                "message"   => "You Have Registered Successfuly",
                "url"       => route("login")
            ];

            echo json_encode($jsonData);

        }catch (\Exception $e){

            $jsonData = [
                "error"    => 1,
                "message"  => $e->getMessage()
            ];

            echo json_encode($jsonData);
        }
    }

    public function customLogin(Request $request)
    {
        try {

            if (!isset($request->name) || empty($request->name)){
                throw new \Exception("Please Enter Name");
            }
            if (!isset($request->password) || empty($request->password)){
                throw new \Exception("Please Enter Password");
            }

            $credentials = [
                "name"     => $request->name,
                "password" => $request->password,
            ];

            if (!Auth::attempt($credentials)){
                throw new \Exception("The provided credentials do not match our records.");
            }

            $request->session()->regenerate();

            $jsonData = [
                "error"     => 0,
                "message"   => "You Have Log In Successfuly",
                "url"       => route("library")
            ];

            echo json_encode($jsonData);

        }catch (\Exception $e){

            $jsonData = [
                "error"    => 1,
                "message"  => $e->getMessage()
            ];

            echo json_encode($jsonData);
        }
    }

    public function Library()
    {
        if (!Auth::check()){
            return redirect('login');
        }
        else
        {
            return view('frontend.index');
        }
    }
}
