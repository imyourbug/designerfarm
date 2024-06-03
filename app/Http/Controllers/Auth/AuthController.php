<?php

namespace App\Http\Controllers\Auth;

use App\Constant\GlobalConstant;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Throwable;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        try {
            $data = $request->validate([
                'email' => 'required|string',
                'password' => 'required|string',
            ]);
            if (Auth::attempt([
                'email'  => $data['email'],
                'password'  => $data['password'],
            ])) {
            } else {
                throw new Exception('Tài khoản hoặc mật khẩu không chính xác');
            }
        } catch (Throwable $e) {
            return response()->json([
                'status' => GlobalConstant::STATUS_ERROR,
                'message' => $e->getMessage(),
            ]);
        }

        return response()->json([
            'status' => GlobalConstant::STATUS_OK,
            'message' => 'Đăng nhập thành công',
            'user' => Auth::user()
        ]);
    }
}
