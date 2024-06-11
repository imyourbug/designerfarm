<?php

namespace App\Http\Controllers;

use App\Constant\GlobalConstant;
use App\Models\Member;
use App\Models\Package;
use App\Models\Request as ModelsRequest;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class RequestController extends Controller
{
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
                'content' => 'nullable|string',
            ]);
            $data['status'] = GlobalConstant::STATUS_PENDING;
            // $data['code'] = 'GD' . time() . $data['user_id'];
            ModelsRequest::create($data);

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
                    $member = Member::with(['package'])
                        ->where([
                            'package_id' => $requestModel->package_id,
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
                        $type = $member->package->type ?? '';
                        $expired_at = $member->expired_at ?? '';
                        $expire = $requestModel->expire ?? '';
                        switch (true) {
                            case $type == GlobalConstant::TYPE_BY_NUMBER_FILE:
                                $downloaded_number_file = 0;
                                if (
                                    strtotime($expired_at) < strtotime(now()->format('Y-m-d'))
                                    ||  $member->downloaded_number_file >= $member->package->number_file
                                ) {
                                    $expired_at = now()->addMonths($requestModel->expire);
                                } else {
                                    // reset package
                                    $downloaded_number_file = $member->downloaded_number_file - $member->package->number_file;
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
                            'package_id' => $requestModel->package_id,
                            'expire' => $requestModel->expire,
                            'website_id' => $requestModel->website_id,
                            'expired_at' => now()->addMonths($requestModel->expire),
                            'number_file' => $requestModel->package->number_file ?? 0,
                        ]);
                    }
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

    public function getAll(Request $request)
    {
        $user_id = $request->user_id;
        $package_id = $request->package_id;
        $to = $request->to;
        $from = $request->from;
        $uid = $request->uid;
        $today = $request->today;
        $limit = $request->limit;
        $ids = $request->ids ?? [];
        $requests = ModelsRequest::with(['user', 'package'])
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
            $requests = $requests->limit($limit);
        }
        $requests = $requests->get()?->toArray() ?? [];;

        return response()->json([
            'status' => 0,
            'requests' => $requests
        ]);
    }

    public function deleteAll(Request $request)
    {
        try {
            DB::beginTransaction();
            ModelsRequest::whereIn('id', $request->ids)->delete();
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

    public function destroy($id)
    {
        try {
            ModelsRequest::firstWhere('id', $id)
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
}
