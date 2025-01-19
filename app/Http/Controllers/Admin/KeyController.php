<?php

namespace App\Http\Controllers\Admin;

use App\Constant\GlobalConstant;
use App\Http\Controllers\Controller;
use App\Models\Key;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;
use Toastr;

class KeyController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.key.list', [
            'title' => 'Danh sách key',
            'keys' => Key::all(),
        ]);
    }
    public function create()
    {
        return view('admin.key.add', [
            'title' => 'Thêm key'
        ]);
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'type' => 'nullable|string',
                'app_id' => 'required|string',
                'app_key' => 'required|string',
                'app_secret' => 'required|string',
                'status' => 'required|in:' . GlobalConstant::STATUS_ACTIVE . ',' . GlobalConstant::STATUS_INACTIVE,
            ]);
            if (Key::firstWhere('app_key', $data['app_key'])) {
                throw new Exception('Key đã tồn tại!');
            }
            Key::create($data);
            Toastr::success('Tạo key thành công', 'Thành công');
        } catch (Throwable $e) {
            Toastr::error($e->getMessage(), 'Lỗi');
        }

        return redirect()->back();
    }

    public function update(Request $request)
    {
        try {
            $data = $request->validate([
                'id' => 'required|string',
                'type' => 'nullable|string',
                'app_id' => 'required|string',
                'app_key' => 'required|string',
                'app_secret' => 'required|string',
                'status' => 'required|in:' . GlobalConstant::STATUS_ACTIVE . ',' . GlobalConstant::STATUS_INACTIVE,
            ]);
            DB::beginTransaction();

            unset($data['id']);
            Key::firstWhere('id', $request->id)
                ->update($data);

            DB::commit();

            Toastr::success('Cập nhật thành công', 'Thành công');
        } catch (Throwable $e) {
            DB::rollBack();
            Toastr::error($e->getMessage(), 'Lỗi');
        }

        return redirect()->back();
    }

    public function show($id)
    {
        return view('admin.key.edit', [
            'title' => 'Chi tiết key',
            'key' => Key::firstWhere('id', $id),
        ]);
    }

    public function destroy($id)
    {
        try {
            Key::firstWhere('id', $id)->delete();

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
