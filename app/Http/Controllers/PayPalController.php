<?php

namespace App\Http\Controllers;

use App\Constant\GlobalConstant;
use App\Models\Website;
use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PayPalController extends Controller
{
    public function index()
    {
        return view('user.paypal', [
            'title' => 'paypal',
        ]);
    }
    public function createTransaction(Request $request)
    {
        $provider = new PayPalClient;

        // Through facade. No need to import namespaces
        $provider = \PayPal::setProvider();
    }
    public function processTransaction(Request $request)
    {
    }
    public function successTransaction(Request $request)
    {
    }
    public function cancelTransaction(Request $request)
    {
    }
}
