<?php

namespace App\Console\Commands;

use App\Constant\GlobalConstant;
use App\Models\Member;
use Illuminate\Console\Command;

class ResetNumberFileEveryDayCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reset-number-file';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset Number File Every Day Command';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Member::whereIn('website_id', GlobalConstant::WEB_TYPE)
            ->where('expired_at', '>=', now()->format('Y-m-d 00:00:00'))
            ->update([
                'downloaded_number_file' => 0,
            ]);
    }
}
