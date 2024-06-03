<?php

namespace App\Http\Controllers;
use Toastr;

class HomeController extends Controller
{
    public function index()
     {
        return view('home',[
            'title' => 'Trang chủ'
        ]);
    }
}
