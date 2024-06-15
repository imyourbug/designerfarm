<?php

namespace App\Http\Controllers\Admin;

use App\Constant\GlobalConstant;
use App\Events\AlertChargedSuccessfullyEvent;
use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Package;
use App\Models\Request as ModelsRequest;
use App\Models\User;
use App\Models\Website;
use Carbon\Carbon;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;
use Toastr;

class RequestController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.request.list', [
            'title' => 'Danh sách yêu cầu nạp',
            'packages' => Package::all(),
            'websites' => Website::all(),
        ]);
    }
    public function create()
    {
        return view('admin.request.add', [
            'title' => 'Thêm yêu cầu nạp'
        ]);
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'name' => 'required|string',
                'price' => 'required|numeric',
                'price_sale' => 'nullable|numeric',
                'number_file' => 'required|numeric',
                'expire' => 'required|numeric',
                'type' => 'required|in:' . GlobalConstant::TYPE_BY_NUMBER_FILE . ',' . GlobalConstant::TYPE_BY_TIME,
                'website_id' => 'nullable|in:' . implode(',', GlobalConstant::WEB_TYPE),
                'avatar' => 'nullable|string',
                'description' => 'nullable|string',
            ]);
            Package::create($data);
            Toastr::success('Tạo yêu cầu nạp thành công', 'Thành công');
        } catch (Throwable $e) {
            Toastr::error($e->getMessage(), 'Lỗi');
        }

        return redirect()->back();
    }

    function getNumberOfMonths($date1, $date2)
    {
        $date1 = new DateTime($date1);
        $date2 = new DateTime($date2);

        $interval = $date1->diff($date2);

        return ($interval->y * 12) + $interval->m + (int)($interval->d > 0);
    }

    public function update(Request $request)
    {
        try {
            $data = $request->validate([
                'id' => 'required|integer',
                'status' => 'required|in:' . implode(',', GlobalConstant::REQUEST_STATUS),
                'website_id' => 'nullable|in:' . implode(',', GlobalConstant::WEB_TYPE),
            ]);

            $requestModel = ModelsRequest::firstWhere('id', $data['id']);
            switch (true) {
                case  $data['status'] == GlobalConstant::STATUS_ACCEPTED:
                    // create or update memeber
                    $member = Member::where([
                        'packagedetail_id' => $requestModel->packagedetail_id,
                        'user_id' => $requestModel->user_id,
                    ])
                        // ->where(function ($query) {
                        //     $query->whereNull('website_id')
                        //         ->orWhere('website_id', '=', '');
                        // })
                        ->when(strlen($data['website_id']), function ($q) use ($data) {
                            return $q->where('website_id', $data['website_id']);
                        })
                        ->first();
                    if ($member) {
                        // type
                        $type = $member->packageDetail->package->type ?? '';
                        $expired_at = $member->expired_at ?? '';
                        $expire = $requestModel->expire ?? '';
                        switch (true) {
                            case $type == GlobalConstant::TYPE_BY_NUMBER_FILE:
                                $downloaded_number_file = 0;
                                if (
                                    strtotime($expired_at) < strtotime(now()->format('Y-m-d'))
                                    ||  $member->downloaded_number_file >= $member->packageDetail->number_file
                                ) {
                                    $expired_at = now()->addMonths($requestModel->expire);
                                } else {
                                    // reset package
                                    $downloaded_number_file = $member->downloaded_number_file - $member->packageDetail->number_file;
                                    $expired_at = Carbon::parse($expired_at)->addMonths($requestModel->expire);
                                    $expire = $this->getNumberOfMonths($expired_at, now());
                                }
                                // increase expire, expired_at
                                $member->update(
                                    [
                                        'expire' => $expire,
                                        'expired_at' => $expired_at,
                                        'downloaded_number_file' => $downloaded_number_file,
                                    ]
                                );
                                break;

                            case $type == GlobalConstant::TYPE_BY_TIME:
                                if (
                                    strtotime($expired_at) < strtotime(now()->format('Y-m-d'))
                                ) {
                                    $expired_at = now()->addMonths($requestModel->expire);
                                } else {
                                    // reset package
                                    $expired_at = Carbon::parse($expired_at)->addMonths($requestModel->expire);
                                    $expire = $this->getNumberOfMonths($expired_at, now());
                                }
                                // increase expire, expired_at
                                $member->update(
                                    [
                                        'expire' => $expire,
                                        'expired_at' => $expired_at,
                                        'downloaded_number_file' => 0,
                                    ]
                                );
                                break;

                            default:

                                break;
                        }
                    } else {
                        Member::create([
                            'user_id' => $requestModel->user_id,
                            'packagedetail_id' => $requestModel->packagedetail_id,
                            'expire' => $requestModel->expire,
                            'website_id' => $requestModel->website_id,
                            'expired_at' => now()->addMonths($requestModel->expire),
                            'number_file' => $requestModel->packageDetail->number_file ?? 0,
                        ]);
                    }
                    // push notification to user
                    event(new AlertChargedSuccessfullyEvent($data['id']));
                    break;
                default:
                    break;
            }
            $requestModel->update([
                'status' => $data['status'],
            ]);
            Toastr::success('Cập nhật thành công', 'Thông báo');
        } catch (Throwable $e) {
            Toastr::error($e->getMessage(), 'Thông báo');
        }

        return redirect()->back();
    }

    public function show($id)
    {
        return view('admin.request.edit', [
            'title' => 'Chi tiết yêu cầu nạp',
            'websites' => Website::all(),
            'package' => Package::firstWhere('id', $id),
        ]);
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            Package::firstWhere('id', $id)
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
