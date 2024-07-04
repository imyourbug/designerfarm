<?php

namespace App\Http\Controllers;

use App\Constant\GlobalConstant;
use App\Events\AlertDownloadedSuccessfullyEvent;
use App\Models\DownloadHistory;
use App\Models\Member;
use App\Models\Package;
use App\Models\Setting;
use App\Models\Website;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class BotController extends Controller
{
    public $botKey;
    public $groupTelegramId;

    public function __construct()
    {
        $settings = Setting::orderByDesc('key')
            ->pluck('value', 'key')
            ->toArray();

        // $this->botKey = "7464014003:AAF9NYa010asmUdBl_0rgzRyMrsVnmX5BcU";
        // $this->groupTelegramId = "-1002226806991";
        $this->botKey = $settings['tele-bot-id'];
        $this->groupTelegramId = $settings['tele-group-id'];
    }

    public function setCacheById(Request $request)
    {
        try {
            $id = $request->id ?? '';
            $url = $request->url ?? '';
            $website_id = $request->website_id ?? '';
            $status = $request->status ?? GlobalConstant::STATUS_OK;
            $download_type = $request->download_type ?? '';

            Log::debug("REQUEST PARAMS setCacheById", $request->all());

            $dataUrl = json_decode(Cache::pull($id), true);
            $downloadHistory = DownloadHistory::where([
                ['user_id', '=', $id],
                ['id_url', '=', $dataUrl['idUrl'] ?? ''],
            ])
                ->whereBetween('created_at', [now()->format('Y-m-d 00:00:00'), now()->format('Y-m-d 23:59:59')])
                ->first();

            DB::beginTransaction();
            if (
                !$downloadHistory && $status == GlobalConstant::STATUS_OK
                && $download_type !== GlobalConstant::DOWNLOAD_LICENSE
            ) {
                // get priority package 1 - by website 2 - by web all 3 - by number file
                $members = Member::with('packageDetail')
                    ->where(
                        [
                            ['user_id', '=', $id],
                            ['expired_at', '>=', now()->format('Y-m-d 00:00:00')],
                        ]
                    )
                    ->whereColumn('downloaded_number_file', '<', 'number_file')
                    ->orderBy('number_file')
                    ->orderBy('expire');

                $packageSelected = null;
                $listMembers = $members->get();
                foreach ($listMembers as $member) {
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
                    $members->where(function ($q) {
                        $q->orWhere('website_id', '')
                            ->orWhereNull('website_id');
                    })
                    ->first();

                if ($packageSelected) {
                    $packageSelected->increment('downloaded_number_file');
                }
                // create download history
                DownloadHistory::create([
                    'user_id' => $id,
                    'url' => $url,
                    'input_url' => $dataUrl['inputUrl'] ?? '',
                    'id_url' => $dataUrl['idUrl'] ?? '',
                ]);
                Log::debug("DECREASED downloaded_number_file successfully");
            }
            DB::commit();

            // push notification about result from tool
            Log::debug("PARAMS alert downloaded successfully event", [$id, $url, $status]);
            event(new AlertDownloadedSuccessfullyEvent($id, $url, $status));

            return response()->json([
                'status' => 0,
            ]);
        } catch (Throwable $e) {
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
            // DB::enableQueryLog();
            $availablePackages = Member::where(
                [
                    ['user_id', '=', $data['id']],
                    ['expired_at', '>=', now()->format('Y-m-d 00:00:00')],
                ]
            )
                ->whereColumn('downloaded_number_file', '<', 'number_file')
                ->where(function ($q) use ($data) {
                    $q->orWhere('website_id', GlobalConstant::WEB_ALL)
                        ->orWhere('website_id', $data['typeWeb'])
                        ->orWhere('website_id', '')
                        ->orWhereNull('website_id');
                })
                ->get();
            // dd(DB::getRawQueryLog(), $availablePackage);

            if ($availablePackages->count() === 0) {
                throw new Exception('Đã hết số lượt tải file, mời bạn gia hạn hoặc đăng ký gói mới.');
            }

            // check there is only retail package and website is note
            $retailPackages = Member::where(
                [
                    ['user_id', '=', $data['id']],
                    ['expired_at', '>=', now()->format('Y-m-d 00:00:00')],
                ]
            )
                ->whereColumn('downloaded_number_file', '<', 'number_file')
                ->where(function ($q) {
                    $q->orWhere('website_id', '')
                        ->orWhereNull('website_id');
                })
                ->get();
            $website = Website::firstWhere('code', $data['typeWeb']);
            if (
                $availablePackages->count() === $retailPackages->count()
                && $website->is_download_by_retail == GlobalConstant::IS_NOT_DOWNLOAD_BY_RETAIL
            ) {
                throw new Exception('Gói bạn đang sở hữu không hỗ trợ website này, mời bạn đăng ký gói mới.');
            }

            [$newText, $idUrl] = $this->getIdFromText($data['text'], $data['typeDownload'] ?? '', $data['typeWeb']);

            $id = $data['id'];

            // store url to cache
            Cache::put($id, json_encode([
                'idUrl' => $idUrl,
                'inputUrl' => $data['text'],
            ]));

            $dataSend = [
                'chat_id' => $this->groupTelegramId,
                'text' => "$id|$newText",
            ];
            $client = new Client();
            $client->post("https://api.telegram.org/bot$this->botKey/sendMessage", [
                'json' => $dataSend
            ]);
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
                // artlist
            case $typeWeb == GlobalConstant::WEB_ARTLIST;
                // get id
                $id = preg_replace(['/#.*/', '/https:\/\/artlist.io\//'], '', $url);
                // set result
                switch (true) {
                    case $typeDownload === GlobalConstant::DOWNLOAD_LICENSE:
                        $result = "$id|getlicense|Artlist";
                        break;
                    default:
                        if (
                            str_contains($id, '/song/')
                            || str_contains($id, '/track/')
                            || str_contains($id, '/clip/')
                        ) {
                            $result = "$id|taifile|taiArtlist";
                        }
                        if (str_contains($id, 'video-templates/')) {
                            $typeDownload = $typeDownload === GlobalConstant::DOWNLOAD_MUSIC ? '' : $typeDownload;
                            $result = "$id|taifile|tai{$typeDownload}Artlist";
                        }
                        break;
                }
                break;
                // yayimages
            case $typeWeb == GlobalConstant::WEB_YAYIMAGE;
                // get id
                $id = preg_replace(['/#.*/', '/https:\/\/yayimages.com\//'], '', $url);
                // set result
                $typeDownload = $typeDownload == GlobalConstant::DOWNLOAD_VIDEO ? 'Video' : '';
                $result = "$id|taifile|tai{$typeDownload}Yayimage";
                break;
                // creativefabrica
            case $typeWeb == GlobalConstant::WEB_CREATIVEFABRICA;
                // get last element
                $url = explode('/', $url);
                $url = array_filter($url);
                // get id
                $id = preg_replace('/#.*/', '', end($url) ?? '');
                // set result
                $result = "$id|taifile|taiCreativefabrica";
                break;
                // slidesgo
            case $typeWeb == GlobalConstant::WEB_SLIDESGO;
                // get last element
                $url = explode('/', $url);
                $url = array_filter($url);
                // get id
                $id = preg_replace('/#.*/', '', end($url) ?? '');
                // set result
                $result = "$id|taifile|taiSlidesgo";
                break;
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
                // get id
                $id = preg_replace(['/#.*/', '/https:\/\/www.flaticon.com\//'], '', $url);
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
                // get id
                $id = preg_replace(['/#.*/', '/https:\/\/motionarray.com\//'], '', $url);
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

        return ["$result|$typeWeb", $id];
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
