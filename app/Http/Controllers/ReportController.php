<?php

namespace App\Http\Controllers;

use App\Constant\GlobalConstant;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function getRevenue(Request $request)
    {
        $from = $request->from ?? '';
        $to = $request->to ?? '';

        $result = DB::table('requests')
            ->selectRaw('MONTH(created_at) as month, YEAR(created_at) as year, SUM(total) as all_total')
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
            ->where('status', GlobalConstant::STATUS_ACCEPTED)
            ->groupByRaw('month, year')
            ->orderByRaw('year,month')
            ->get();

        return response()->json([
            'status' => 0,
            'result' => $result
        ]);
    }
}
