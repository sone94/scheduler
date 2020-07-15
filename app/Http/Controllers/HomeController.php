<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JWTAuth;

class HomeController extends Controller
{

    public function __construct()
    {
        
    }

    public function index(){

        return view('home.dashboard');

    }
}
