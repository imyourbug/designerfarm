<?php

namespace App\Console\Commands;

use App\Events\AlertChargedSuccessfullyEvent;
use App\Events\AlertDownloadedSuccessfullyEvent;
use App\Models\DownloadHistory;
use Illuminate\Console\Command;

class SendChatMessage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send-chat-message';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // event(new AlertChargedSuccessfullyEvent(26));
        event(new AlertDownloadedSuccessfullyEvent(26, "123", 0));
        // $data = [];
        // for ($i=0; $i < 15000; $i++) {
        //     $data[] = [
        //         'user_id' => random_int(34, 40),
        //         'url' => 'test',
        //         'input_url' => 'test',
        //         'id_url' => 'test',
        //     ];
        // }
        // DownloadHistory::insert($data);
        // return DownloadHistory::paginate(10);
    }
}
