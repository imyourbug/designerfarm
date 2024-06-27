<?php

namespace App\Http\Controllers\Admin;

use App\Constant\GlobalConstant;
use App\Http\Controllers\Controller;
use App\Http\Requests\Users\LoginRequest;
use App\Http\Requests\Users\RecoverRequest;
use App\Http\Requests\Users\RegisterRequest;
use App\Mail\RecoverPasswordMail;
use App\Models\Discount;
use App\Models\Package;
use App\Models\Request as ModelsRequest;
use App\Models\Setting;
use App\Models\User;
use App\Models\Website;
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

        $total = 0;
        $requests = ModelsRequest::where('status', GlobalConstant::STATUS_ACCEPTED)
            ->get();
        foreach ($requests as $request) {
            if ($request->created_at->format('m-Y') == date('m-Y')) {
                $total += $request->total;
            }
        }

        return view('admin.home', [
            'title' => 'Trang người dùng',
            'users' => User::where('role', GlobalConstant::ROLE_USER)
                ->get(),
            'packages' => Package::all(),
            'websites' => Website::all(),
            'discounts' => Discount::all(),
            'requests' => ModelsRequest::where('status', GlobalConstant::STATUS_PENDING)
                ->get(),
            'total' => $total
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
