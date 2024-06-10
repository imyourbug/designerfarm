<?php

namespace App\Http\Controllers;

use App\Constant\GlobalConstant;
use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\User;
use App\Models\Website;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;
use Toastr;

class MemberController extends Controller
{
    public function getAll(Request $request)
    {
        $user_id = $request->user_id;
        $member_id = $request->member_id;
        $to = $request->to;
        $from = $request->from;
        $uid = $request->uid;
        $limit = $request->limit;
        $ids = $request->ids ?? [];
        $members = Member::with(['user', 'package'])
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
            // uid
            ->when(strlen($uid), function ($q) use ($uid) {
                return $q->where('uid', 'like', "%$uid%");
            })
            // ids
            ->when(count($ids), function ($q) use ($ids) {
                $q->whereIn('id', $ids);
            })
            // order
            ->orderByDesc('created_at');

        // limit
        if ($limit) {
            $members = $members->limit($limit);
        }
        $members = $members->get()?->toArray() ?? [];;

        return response()->json([
            'status' => 0,
            'members' => $members
        ]);
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            Member::firstWhere('id', $id)
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

    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'user_id' => 'required|string',
                'package_id' => 'required|string',
                'total' => 'required|string',
                'expire' => 'required|numeric',
                // 'type' => 'required|in:' . GlobalConstant::TYPE_BY_NUMBER_FILE . ',' . GlobalConstant::TYPE_BY_TIME,
                'website_id' => 'nullable|in:' . implode(',', GlobalConstant::WEB_TYPE),
            ]);
            $data['status'] = GlobalConstant::STATUS_PENDING;
            $data['code'] = 'GD' . time() . $data['user_id'];
            Member::create($data);

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

    public function update(Request $request)
    {
        try {
            $data = $request->validate([
                'id' => 'required|integer',
                'status' => 'required|in:' . implode(',', GlobalConstant::REQUEST_STATUS),
            ]);

            $requestModel = Member::firstWhere('id', $data['id']);
            switch (true) {
                case  $data['status'] == GlobalConstant::STATUS_ACCEPTED:
                    # code...
                    $package = Member::firstWhere('id', $requestModel->package_id);

                    break;
                default:
                    break;
            }
            $requestModel->update([
                'status' => $data['status'],
            ]);

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
}