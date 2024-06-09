<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Constant\GlobalConstant;
use App\Http\Requests\Users\LoginRequest;
use App\Http\Requests\Users\RecoverRequest;
use App\Http\Requests\Users\RegisterRequest;
use App\Mail\RecoverPasswordMail;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Throwable;
use Toastr;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.home', [
            'title' => 'Trang người dùng',
        ]);
    }

    public function login()
    {
        return view('admin.login.index', [
            'title' => 'Đăng nhập'
        ]);
    }

    public function forgot()
    {
        return view('admin.forgot.index', [
            'title' => 'Quên mật khẩu'
        ]);
    }

    public function recover(RecoverRequest $request)
    {
        if (!$user = User::firstWhere('email', $request->input('email'))) {
            Toastr::error('Email không tồn tại!', 'Lỗi');

            return redirect()->back();
        }
        $source = [
            'a', 'b', 'c', 'd', 'e', 'g', 1, 2, 3, 4, 5, 6
        ];
        $new_password = '';
        foreach ($source as $s) {
            $new_password .= $source[rand(0, count($source) - 1)];
        }
        $reset_password = $user->update([
            'password' => Hash::make($new_password)
        ]);
        if ($reset_password) {
            Mail::to($request->input('email'))->send(new RecoverPasswordMail($new_password));
        }
        Toastr::success('Lấy mật khẩu thành công! Hãy kiểm tra email của bạn', 'Thành công');

        return redirect()->back();
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->route('admin.login');
    }

    public function checkLogin(Request $request)
    {
        try {
            $data = $request->validate([
                'email' => 'required|string',
                'password' => 'required|string',
            ]);
            if (Auth::attempt([
                'email'  => $data['email'],
                'password' => $request->input('password')
            ])) {
                $user = Auth::user();
                Toastr::success('Đăng nhập thành công', 'Thành công');

                return redirect()->route('admin.index');
            } else {
                throw new Exception('Tài khoản hoặc mật khẩu không chính xác');
            }
        } catch (Throwable $e) {
            Toastr::error($e->getMessage(), 'Lỗi');
        }

        return redirect()->back();
    }

    public function changePassword(Request $request)
    {
        try {
            $tel_or_email = $request->input('tel_or_email');
            $rules = [
                'tel_or_email' => 'required|email:dns,rfc',
                'old_password' => 'required|string',
                'password' => 'required|string',
            ];
            if (is_numeric($tel_or_email)) {
                $rules['tel_or_email'] = 'required|string|regex:/^0\d{9,10}$/';
            }
            $request->validate($rules);
            $type = is_numeric($tel_or_email) ? 'name' : 'email';
            $user = Auth::attempt([
                $type => $tel_or_email,
                'password' => $request->input('old_password')
            ]);
            if (!$user) {
                return response()->json([
                    'status' => 1,
                    'message' => 'Mật khẩu cũ không chính xác'
                ]);
            }

            User::firstWhere($type, $tel_or_email)->update([
                'password' => Hash::make($request->input('password'))
            ]);

            return response()->json([
                'status' => 0,
                'message' => 'Đổi mật khẩu thành công'
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'status' => 1,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function register()
    {
        return view('admin.register.index', [
            'title' => 'Đăng ký',
        ]);
    }

    public function checkRegister(Request $request)
    {
        try {
            $data = $request->validate([
                'name' => 'required|string',
                'password' => 'required|string',
            ]);
            $check = User::firstWhere('name', $data['name']);
            if ($check) {
                throw new Exception('Tài khoản đã có người đăng ký!');
            }
            User::create([
                'name' =>  $data['name'],
                'password' => Hash::make($data['password']),
                'role' => GlobalConstant::ROLE_USER,
            ]);
            Toastr::success('Tạo tài khoản thành công', 'Thành công');
        } catch (Throwable $e) {
            Toastr::error($e->getMessage(), 'Lỗi');
        }

        return redirect()->back();
    }

    public function me(Request $request)
    {
        return view('admin.me', [
            'title' => 'Thông tin cá nhân',
            'staff' => User::with(['staff'])
                ->firstWhere('id', Auth::id())
                ->staff
        ]);
    }
}
