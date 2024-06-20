<?php

namespace App\Http\Controllers\Admin;

use App\Constant\GlobalConstant;
use App\Http\Controllers\Controller;
use App\Models\Link;
use App\Models\Member;
use App\Models\Setting;
use App\Models\User;
use App\Models\UserRole;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Throwable;
use Toastr;

class AccountController extends Controller
{
    public function create()
    {
        return view('admin.account.add', [
            'title' => 'Thêm tài khoản'
        ]);
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'name' => 'required|string',
                'password' => 'required|string',
                // 'role' => 'required|in:0,1',
            ]);
            $check = User::firstWhere('name', $data['name']);
            if ($check) {
                throw new Exception('Tài khoản đã có người đăng ký!');
            }
            DB::beginTransaction();
            User::create($data);

            Toastr::success('Tạo tài khoản thành công', 'Thành công');
            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
            Toastr::error($e->getMessage(), 'Lỗi');
        }

        return redirect()->back();
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
            DB::beginTransaction();

            User::firstWhere('id', $data['user_id'])
                ->update($dataUpdate);

            DB::commit();

            Toastr::success('Cập nhật thành công', 'Thành công');
        } catch (Throwable $e) {
            DB::rollBack();
            Toastr::error($e->getMessage(), 'Lỗi');
        }

        return redirect()->back();
    }

    public function index(Request $request)
    {
        return view('admin.account.list', [
            'title' => 'Danh sách tài khoản',
        ]);
    }

    public function show($id)
    {
        $user = User::firstWhere('id', $id);

        return view('admin.account.edit', [
            'title' => 'Chi tiết tài khoản',
            'user' => $user,
        ]);
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $user = User::firstWhere('id', $id);
            $user->delete();
            Member::where('user_id', $id)->delete();
            DB::commit();

            return response()->json([
                'status' => 0,
            ]);
        } catch (Throwable $e) {
            DB::rollBack();

            return response()->json([
                'status' => 1,
                'message' => $e->getMessage()
            ]);
        }
    }
}
