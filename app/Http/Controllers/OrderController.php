<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function create()
    {
        return response()->json([
            'order' => [
                'id' => 1
            ],
        ]);
    }

    public function capture($orderId, Request $request)
    {
        return response()->json([
            'order' => [
                'id' => 1
            ],
        ]);
    }
}
