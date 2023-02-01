<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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

    public function customRegistration()
    {

    }
}
