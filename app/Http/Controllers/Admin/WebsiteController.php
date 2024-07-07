<?php

namespace App\Http\Controllers\Admin;

use App\Constant\GlobalConstant;
use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Request as ModelsRequest;
use App\Models\Website;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;
use Toastr;

class WebsiteController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.website.list', [
            'title' => 'Danh sách website',
            'websites' => Website::all(),
        ]);
    }
    public function create()
    {
        return view('admin.website.add', [
            'title' => 'Thêm website'
        ]);
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'code' => 'required|string',
                'status' => 'required|in:' . GlobalConstant::STATUS_ACTIVE . ',' . GlobalConstant::STATUS_INACTIVE,
                'name' => 'required|string',
                'image' => 'nullable|string',
                'sample_link' => 'required|string',
                'website_link' => 'required|string',
                'is_download_by_retail' => 'required|in:'
                    . GlobalConstant::IS_DOWNLOAD_BY_RETAIL . ',' . GlobalConstant::IS_NOT_DOWNLOAD_BY_RETAIL,
            ]);

            $checkCode = Website::firstWhere('code', $data['code']);
            if ($checkCode) {
                throw new Exception('Website đã tồn tại!');
            }

            Website::create($data);
            Toastr::success('Tạo website thành công', 'Thành công');
        } catch (Throwable $e) {
            Toastr::error($e->getMessage(), 'Lỗi');
        }

        return redirect()->back();
    }

    public function update(Request $request)
    {
        try {
            $data = $request->validate([
                'id' => 'required|string',
                'code' => 'required|string',
                'status' => 'required|in:' . GlobalConstant::STATUS_ACTIVE . ',' . GlobalConstant::STATUS_INACTIVE,
                'name' => 'required|string',
                'image' => 'nullable|string',
                'sample_link' => 'required|string',
                'website_link' => 'required|string',
                'is_download_by_retail' => 'required|in:'
                    . GlobalConstant::IS_DOWNLOAD_BY_RETAIL . ',' . GlobalConstant::IS_NOT_DOWNLOAD_BY_RETAIL,
            ]);

            unset($data['id']);
            $website = Website::firstWhere('id', $request->id);

            DB::beginTransaction();
            if (strlen($data['code']) && $data['code'] !== $website->code) {
                ModelsRequest::where('website_id', $website->code)
                    ->update([
                        'website_id' => $data['code']
                    ]);
                Member::where('website_id', $website->code)
                    ->update([
                        'website_id' => $data['code']
                    ]);
            }
            $website->update([
                'code' => $data['code']
            ]);
            DB::commit();

            Toastr::success('Cập nhật thành công', 'Thành công');
        } catch (Throwable $e) {
            DB::rollBack();
            Toastr::error($e->getMessage(), 'Lỗi');
        }

        return redirect()->back();
    }

    public function show($id)
    {
        return view('admin.website.edit', [
            'title' => 'Chi tiết website',
            'websites' => Website::all(),
            'website' => Website::firstWhere('id', $id),
        ]);
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
}
