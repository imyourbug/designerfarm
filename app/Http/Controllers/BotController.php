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
            ]);
            $dataSend = [
                'chat_id' => $this->groupTelegramId,
                'text' =>  $data['text'],
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
}
