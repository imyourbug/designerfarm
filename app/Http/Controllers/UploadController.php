<?php

namespace App\Http\Controllers;

use App\Constant\GlobalConstant;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class UploadController extends Controller
{
    //
    public function upload(Request $request)
    {
        $url = '';
        try {
            $request->validate([
                // 'file' =>  'max:500000|mimes:jpeg,png,pdf,docx,pptx,cad,xlsx,xls,csv',
                'file' =>  'max:500000',
            ]);
            $file_name = time() . $request->file('file')->getClientOriginalName();
            $pathFull = 'upload/';
            $request->file('file')->storeAs(
                'public/' . $pathFull,
                $file_name
            );
            $url = '/storage/' . $pathFull . '/' . $file_name;
        } catch (Throwable $e) {
            return response()->json([
                'status' => 1,
                'message' => $e->getMessage()
            ]);
        }

        return response()->json([
            'status' => 0,
            'url' => $url
        ]);
    }
}
