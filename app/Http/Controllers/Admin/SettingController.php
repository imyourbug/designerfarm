<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Throwable;
use Toastr;

class SettingController extends Controller
{
    public function update(Request $request)
    {
        try {
            foreach ($request->except('_token') as $key => $value) {
                Setting::where('key', $key)->update([
                    'value' => $value
                ]);
            }
        } catch (Throwable $e) {
            Toastr::error($e->getMessage(), 'Thông báo');
        }
        Toastr::success('Cập nhật thành công', 'Thông báo');

        return redirect()->back();
    }

    public function index()
    {
        return view('admin.setting', [
            'title' => 'Cài đặt',
            'settings' => Setting::orderBy('key')
                ->get()
        ]);
    }
}
