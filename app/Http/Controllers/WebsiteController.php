<?php

namespace App\Http\Controllers;

use App\Constant\GlobalConstant;
use App\Models\Website;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class WebsiteController extends Controller
{
    public function getAll(Request $request)
    {
        $to = $request->to;
        $from = $request->from;
        $limit = $request->limit;
        $websites = Website::when($to, function ($q) use ($to) {
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
            $websites = $websites->limit($limit);
        }
        $websites = $websites->get();

        return response()->json([
            'status' => 0,
            'websites' => $websites
        ]);
    }

    public function update(Request $request)
    {
        try {
            $data = $request->validate([
                'id' => 'required|string',
                'status' => 'required|in:' . GlobalConstant::STATUS_ACTIVE . ',' . GlobalConstant::STATUS_INACTIVE,
                'image' => 'nullable|string',
                'name' => 'nullable|string',
            ]);

            unset($data['id']);
            Website::firstWhere('id', $request->id)
                ->update($data);

            return response()->json([
                'status' => 0,
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'status' => 1,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            Website::firstWhere('id', $id)
                ->delete();
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

    public function deleteAll(Request $request)
    {
        try {
            DB::beginTransaction();
            Website::whereIn('id', $request->ids)->delete();
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
