<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\TaskChemistry;
use App\Models\TaskDetail;
use App\Models\TaskItem;
use App\Models\TaskMap;
use App\Models\TaskSolution;
use App\Models\TaskStaff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
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
            Toastr::error($e->getMessage(), __('title.toastr.fail'));
        }
        Toastr::success(__('message.success.update'), __('title.toastr.success'));

        return redirect()->back();
    }

    public function index()
    {
        return view('admin.setting', [
            'title' => 'Cài đặt',
            'settings' => Setting::orderBy('key')->get()
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'settings' => 'required|array',
            'settings.*.key' => 'required|string',
            'settings.*.value' => 'required|string',
            'settings.*.name' => 'nullable|string',
        ]);
        foreach ($data['settings'] as $value) {
            Setting::updateOrCreate([
                'key' => $value['key']
            ], [
                'value' => $value['value'],
                'name' => $value['name'],
            ]);
        }

        return response()->json([
            'status' => 0,
        ]);
    }

    public function getAll()
    {
        return response()->json([
            'status' => 0,
            'settings' => Setting::orderBy('key')->get()
        ]);
    }

    public function delete(Request $request)
    {
        $data = $request->validate([
            'key' => 'required|array',
            'key.*' => 'nullable|string',
        ]);

        try {
            if (!in_array('*', $data['key'])) {
                Setting::whereIn('key', $data['key'] ?? [])->delete();
            } else {
                Setting::truncate();;
            }
        } catch (Throwable $e) {
            return response()->json([
                'status' => 1,
                'message' => $e->getMessage()
            ]);
        }
        return response()->json([
            'status' => 0,
        ]);
    }
}
