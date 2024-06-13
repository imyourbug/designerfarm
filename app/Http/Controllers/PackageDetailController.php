<?php

namespace App\Http\Controllers;

use App\Constant\GlobalConstant;
use App\Models\Package;
use App\Models\PackageDetail;
use App\Models\Website;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class PackageDetailController extends Controller
{
    public function getPackageById(Request $request)
    {
        $package = PackageDetail::firstWhere('id', $request->id);

        if ($package) {
            return response()->json([
                'status' => 0,
                'package' => $package
            ]);
        }

        return response()->json([
            'status' => 1,
            'message' => 'Gói không tồn tại'
        ]);
    }

    public function index()
    {
        return view('user.package.index', [
            'title' => 'Gói tải',
            'packageTypes' => [
                GlobalConstant::TYPE_BY_NUMBER_FILE => PackageDetail::with(['members'])
                    ->where('type', GlobalConstant::TYPE_BY_NUMBER_FILE)
                    ->get(),
                GlobalConstant::TYPE_BY_TIME => PackageDetail::with(['members'])
                    ->where('type', GlobalConstant::TYPE_BY_TIME)
                    ->get(),
            ],
            'websites' => Website::all(),
            'packages' => Package::all(),
        ]);
    }

    public function searchOne(Request $request)
    {
        $user_id = $request->user_id;
        $package_id = $request->package_id;
        $quantity = $request->quantity;
        $time = $request->time;
        $id = $request->id;
        $to = $request->to;
        $from = $request->from;
        $today = $request->today;

        $detail = PackageDetail::with(['package'])
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
            // id
            ->when(strlen($id), function ($q) use ($id) {
                $q->where('id', $id);
            })
            // package_id
            ->when(strlen($package_id), function ($q) use ($package_id) {
                $q->where('package_id', $package_id);
            })
            // quantity
            ->when(strlen($quantity), function ($q) use ($quantity) {
                $q->where('number_file', $quantity);
            })
            // time
            ->when(strlen($time), function ($q) use ($time) {
                $q->where('expire', $time);
            })
            ->first();

        return response()->json([
            'status' => $detail ? GlobalConstant::STATUS_OK : GlobalConstant::STATUS_ERROR,
            'detail' => $detail
        ]);
    }

    public function getAll(Request $request)
    {
        $user_id = $request->user_id;
        $package_id = $request->package_id;
        $quantity = $request->quantity;
        $time = $request->time;
        $id = $request->id;
        $to = $request->to;
        $from = $request->from;
        $today = $request->today;
        $limit = $request->limit;

        $packageDetails = PackageDetail::with(['package'])
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
            // id
            ->when(strlen($id), function ($q) use ($id) {
                $q->where('id', $id);
            })
            // package_id
            ->when(strlen($package_id), function ($q) use ($package_id) {
                $q->where('package_id', $package_id);
            })
            // quantity
            ->when(strlen($quantity), function ($q) use ($quantity) {
                $q->where('number_file', $quantity);
            })
            // time
            ->when(strlen($time), function ($q) use ($time) {
                $q->where('expire', $time);
            })
            // order
            ->orderByDesc('created_at');

        // limit
        if ($limit) {
            $packageDetails = $packageDetails->limit($limit);
        }
        $packageDetails = $packageDetails->get()?->toArray() ?? [];;

        return response()->json([
            'status' => 0,
            'packageDetails' => $packageDetails
        ]);
    }

    public function show($id)
    {
        // return view('admin.package.edit', [
        //     'title' => 'Chi tiết bình luận',
        //     'package' => PackageDetail::firstWhere('id', $id)
        // ]);
    }

    public function destroy($id)
    {
        try {
            $detail = PackageDetail::firstWhere('id', $id);
            $detail->delete();

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
            PackageDetail::whereIn('id', $request->ids)->delete();
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
