<?php

namespace App\Http\Controllers;

use App\Constant\GlobalConstant;
use App\Models\Website;

class HomeController extends Controller
{
    public function index()
    {
        return view('user.home', [
            'title' => 'Trang chủ',
            'websites' => Website::whereIn('code', GlobalConstant::WEB_TYPE)
                ->where('code', '!=', GlobalConstant::WEB_ALL)
                ->get(),
        ]);
    }
}
