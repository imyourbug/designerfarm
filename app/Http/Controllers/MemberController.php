<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class MemberController extends Controller
{
    public function index()
    {
        return view('user.member.index', [
            'title' => 'Gói đã đăng ký',
        ]);
    }

    public function getAll(Request $request)
    {
        $user_id = $request->user_id;
        $to = $request->to;
        $from = $request->from;
        $limit = $request->limit;

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
            // user_id
            ->when(strlen($user_id), function ($q) use ($user_id) {
                $q->whereIn('user_id', $user_id);
            })
            // order
            ->orderByDesc('created_at');

        // limit
        if ($limit) {
            $members = $members->limit($limit);
        }
        $members = $members->get();

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
}
