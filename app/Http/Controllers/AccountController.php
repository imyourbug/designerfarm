<?php

namespace App\Http\Controllers;

use App\Constant\GlobalConstant;
use App\Http\Controllers\Controller;
use App\Models\Link;
use App\Models\Member;
use App\Models\Setting;
use App\Models\User;
use App\Models\UserRole;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Throwable;
use Toastr;

class AccountController extends Controller
{
    public function getAll(Request $request)
    {
        $to = $request->to;
        $from = $request->from;
        $limit = $request->limit;
        $accounts = User::with([])
            ->where('role', GlobalConstant::ROLE_USER)
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
            ->orderByDesc('created_at');

        // limit
        if ($limit) {
            $accounts = $accounts->limit($limit);
        }
        $accounts = $accounts->get();

        return response()->json([
            'status' => 0,
            'accounts' => $accounts
        ]);
    }

    public function destroy($id)
    {
        try {
            User::firstWhere('id', $id)->delete();

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
            User::whereIn('id', $request->ids)->delete();
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
