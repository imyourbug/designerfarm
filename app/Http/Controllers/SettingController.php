<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Throwable;

class SettingController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'settings' => 'required|array',
            'settings.*.key' => 'required|string',
            'settings.*.value' => 'nullable|string',
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
