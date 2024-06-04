<?php

namespace App\Http\Controllers;

use App\Constant\GlobalConstant;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
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
            $newText = $this->getIdFromText($data['text'], $data['typeDownload'] ?? '', $data['typeWeb']);

            $id = $data['id'];
            $dataSend = [
                'chat_id' => $this->groupTelegramId,
                'text' =>  "$id|$newText",
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
}
