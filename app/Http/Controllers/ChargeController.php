<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChargeController extends Controller
{
    public function index()
    {
        return view('charge.index', [
            'title' => 'Nạp tiền'
        ]);
    }
}
