<?php

namespace App\Http\Controllers\Admin;

use App\Constant\GlobalConstant;
use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Package;
use App\Models\Request as ModelsRequest;
use App\Models\User;
use App\Models\Website;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;
use Toastr;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.report.list', [
            'title' => 'Thống kê',
        ]);
    }
}
