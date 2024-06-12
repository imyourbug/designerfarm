<?php

namespace App\Http\Controllers;

use App\Models\PackageDetail;
use Illuminate\Http\Request;

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
            'websites' => Website::all()
        ]);
    }

    public function getAll(Request $request)
    {
        $user_id = $request->user_id;
        $package_id = $request->package_id;
        $to = $request->to;
        $from = $request->from;
        $content = $request->content;
        $user = $request->user;
        $uid = $request->uid;
        $note = $request->note;
        $phone = $request->phone;
        $title = $request->title;
        $name_facebook = $request->name_facebook;
        $today = $request->today;
        $limit = $request->limit;
        $ids = $request->ids ?? [];
        $packages = PackageDetail::with([])
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
            $packages = $packages->limit($limit);
        }
        $packages = $packages->get()?->toArray() ?? [];;

        return response()->json([
            'status' => 0,
            'packages' => $packages
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
            $link = PackageDetail::firstWhere('id', $id);
            $link->delete();

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
