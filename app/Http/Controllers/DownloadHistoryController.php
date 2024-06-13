<?php

namespace App\Http\Controllers;

use App\Models\DownloadHistory;
use Illuminate\Http\Request;

class DownloadHistoryController extends Controller
{
    public function index()
    {
        return view('user.downloadhistory.index', [
            'title' => 'Lịch sử download',
        ]);
    }

    public function getAll(Request $request)
    {
        $user_id = $request->user_id;
        $to = $request->to;
        $from = $request->from;
        $today = $request->today;
        $limit = $request->limit;
        $ids = $request->ids ?? [];
        $downloadHistories = DownloadHistory::with(['user'])
            // user_id
            ->when(strlen($user_id), function ($q) use ($user_id) {
                $q->where('user_id', $user_id);
            })
            // // to
            // ->when($to, function ($q) use ($to) {
            //     return $q->where('created_at', '<=', $to . ' 23:59:59');
            // })
            // // from
            // ->when($from, function ($q) use ($from) {
            //     return $q->where(
            //         'created_at',
            //         '>=',
            //         $from
            //     );
            // })
            // order
            ->orderByDesc('created_at');

        // limit
        if ($limit) {
            $downloadHistories = $downloadHistories->limit($limit);
        }
        $downloadHistories = $downloadHistories->get()?->toArray() ?? [];

        return response()->json([
            'status' => 0,
            'downloadHistories' => $downloadHistories
        ]);
    }

}
