<?php

namespace App\Http\Controllers;

use App\Constant\GlobalConstant;
use App\Models\Key;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Throwable;

class KeyController extends Controller
{
    public function changeKey(Request $request)
    {
        $key = Key::firstWhere('app_key', $request->key);
        if (!$key) {
            return response()->json([
                'status' => 1,
                'message' => 'Key không tồn tại'
            ]);
        }
        $key->update([
            'status' => 0,
        ]);
        $key = Key::firstWhere('status', GlobalConstant::STATUS_ACTIVE);
        if (!$key) {
            return response()->json([
                'status' => 1,
                'message' => 'Hết key'
            ]);
        }
        // config('broadcasting.connections.pusher.key', env('PUSHER_APP_KEY'));
        Config::set('broadcasting.connections.pusher.key', $key->app_key);
        Config::set('broadcasting.connections.pusher.secret', $key->app_secret);
        Config::set('broadcasting.connections.pusher.app_id', $key->app_id);

        return response()->json([
            'status' => 0,
            'key' => $key
        ]);
    }

    public function getKeyById(Request $request)
    {
        $key = Key::firstWhere('id', $request->id);

        if ($key) {
            return response()->json([
                'status' => 0,
                'key' => $key
            ]);
        }

        return response()->json([
            'status' => 1,
            'message' => 'Key không tồn tại'
        ]);
    }

    public function getAll(Request $request)
    {
        $to = $request->to;
        $from = $request->from;
        $limit = $request->limit;
        $keys = Key::with([])
            // to
            ->when($to, function ($q) use ($to) {
                return $q->where('created_at', '<=', $to . ' 23:59:59');
            })
            // from
            ->when($from, function ($q) use ($from) {
                return $q->where(
                    'created_at',
                    '>=',
                    $from
                );
            })
            // order
            ->orderByDesc('id');

        // limit
        if ($limit) {
            $keys = $keys->limit($limit);
        }
        $keys = $keys->get();

        return response()->json([
            'status' => 0,
            'keys' => $keys
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

    public function deleteAll(Request $request)
    {
        try {
            Key::whereIn('id', $request->ids)->delete();

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
