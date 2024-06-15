<?php

namespace App\Http\Controllers;

use App\Constant\GlobalConstant;
use App\Models\Discount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class DiscountController extends Controller
{
    public function getAll(Request $request)
    {
        $user_id = $request->user_id;
        $package_id = $request->package_id;
        $to = $request->to;
        $from = $request->from;
        $limit = $request->limit;

        $discounts = Discount::with([])
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
            $discounts = $discounts->limit($limit);
        }
        $discounts = $discounts->get();

        return response()->json([
            'status' => 0,
            'discounts' => $discounts
        ]);
    }



    public function destroy($id)
    {
        try {
            Discount::firstWhere('id', $id)
                ->delete();

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

    public function deleteAll(Request $request)
    {
        try {
            DB::beginTransaction();
            Discount::whereIn('id', $request->ids)->delete();
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

    public function getDiscountByCode(Request $request)
    {
        $code = $request->code;

        $discount = Discount::where('code', $code)
            ->first();

        if ($discount) {
            return response()->json([
                'status' => GlobalConstant::STATUS_OK,
                'discount' => $discount,
            ]);
        }

        return response()->json([
            'status' => GlobalConstant::STATUS_ERROR,
            'message' => 'Không tìm thấy mã giảm giá',
        ]);
    }
}
