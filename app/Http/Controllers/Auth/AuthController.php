<?php

namespace App\Http\Controllers\Auth;

use App\Constant\GlobalConstant;
use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Throwable;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        try {
            $data = $request->validate([
                'name' => 'required|string',
                'password' => 'required|string',
            ]);
            if (Auth::attempt([
                'name'  => $data['name'],
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

    public function register(Request $request)
    {
        try {
            $data = $request->validate([
                'name' => 'required|string',
                'password' => 'required|string',
                're_password' => 'required|string|same:password',
            ]);
            $check = User::firstWhere('name', $data['name']);
            if ($check) {
                throw new Exception('Tài khoản đã có người đăng ký!');
            }
            unset($data['re_password']);
            User::create($data);
        } catch (Throwable $e) {
            return response()->json([
                'status' => GlobalConstant::STATUS_ERROR,
                'message' => $e->getMessage(),
            ]);
        }

        return response()->json([
            'status' => GlobalConstant::STATUS_OK,
            'message' => 'Tạo tài khoản thành công',
        ]);
    }

    public function changePassword(Request $request)
    {
        try {
            $data = $request->validate([
                'name' => 'required|string',
                'password' => 'required|string',
                'new_password' => 'required|string',
            ]);
            $check = User::firstWhere('name', $data['name']);
            if (!$check) {
                throw new Exception('Tài khoản không tồn tại!');
            }
            if (Auth::attempt([
                'name'  => $data['name'],
                'password'  => $data['password'],
            ])) {
            } else {
                throw new Exception('Mật khẩu cũ không chính xác');
            }
            User::firstWhere('name', $data['name'])
                ->update([
                    'password' => Hash::make($data['new_password']),
                ]);
        } catch (Throwable $e) {
            return response()->json([
                'status' => GlobalConstant::STATUS_ERROR,
                'message' => $e->getMessage(),
            ]);
        }

        return response()->json([
            'status' => GlobalConstant::STATUS_OK,
            'message' => 'Đổi mật khẩu thành công',
        ]);
    }

    public function update(Request $request)
    {
        try {
            $data = $request->validate([
                'user_id' => 'required|string',
                'password' => 'nullable|string',
                // 'balance' => 'required|string',
            ]);
            $dataUpdate = [];
            if (strlen($data['password'])) {
                $dataUpdate = array_merge($dataUpdate, [
                    'password' => Hash::make($data['password']),
                ]);
            }

            User::firstWhere('id', $data['user_id'])
                ->update($dataUpdate);
        } catch (Throwable $e) {
            return response()->json([
                'status' => GlobalConstant::STATUS_ERROR,
                'message' => $e->getMessage(),
            ]);
        }

        return response()->json([
            'status' => GlobalConstant::STATUS_OK,
            'message' => 'Cập nhật tài khoản thành công',
        ]);
    }
}
