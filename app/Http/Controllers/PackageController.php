<?php

namespace App\Http\Controllers;

use App\Constant\GlobalConstant;
use App\Models\Member;
use App\Models\Package;
use App\Models\Request as ModelsRequest;
use App\Models\Website;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class PackageController extends Controller
{
    public function getPackageById(Request $request)
    {
        $package = Package::firstWhere('id', $request->id);

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
                GlobalConstant::TYPE_BY_NUMBER_FILE => Package::with(['members', 'details'])
                    ->where('type', GlobalConstant::TYPE_BY_NUMBER_FILE)
                    ->get(),
                GlobalConstant::TYPE_BY_TIME => Package::with(['members', 'details'])
                    ->where('type', GlobalConstant::TYPE_BY_TIME)
                    ->get(),
            ],
            'websites' => Website::all()
        ]);
    }

    public function getAll(Request $request)
    {
        $to = $request->to;
        $from = $request->from;
        $limit = $request->limit;
        $packages = Package::with([])
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
            $packages = $packages->limit($limit);
        }
        $packages = $packages->get();

        return response()->json([
            'status' => 0,
            'packages' => $packages
        ]);
    }

    public function show($id)
    {
        $package = Package::with('details')->firstWhere('id', $id);
        $quantities = [];
        $times = [];
        $prices = [];
        foreach ($package->details as $detail) {
            $quantities[$detail->number_file] = $detail->number_file;
            $times[$detail->expire] = $detail->expire;
            $prices[$detail->price] = $detail->price;
            if ($detail->price_sale) {
                $prices[$detail->price_sale] = $detail->price_sale;
            }
        }
        sort($prices);

        return view('user.package.detail', [
            'title' => 'Chi tiết gói',
            'package' => $package,
            'quantities' => $quantities,
            'times' => $times,
            'prices' => $prices,
        ]);
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $package = Package::firstWhere('id', $id);
            $details = $package->details();
            $listPackagedetailId = $details->pluck('id');
            Member::whereIn('packagedetail_id', $listPackagedetailId)
                ->delete();
            ModelsRequest::whereIn('packagedetail_id', $listPackagedetailId)
                ->delete();
            $package->delete();
            $details->delete();
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
            Package::whereIn('id', $request->ids)->delete();
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
