<?php

namespace App\Console\Commands;

use App\Models\ApiResponseTime;
use Carbon\Carbon;
use Illuminate\Console\Command;

class DeleteOldApiResponseTimes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:deleteOldApiResponse';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deletes old api response times';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        ApiResponseTime::whereDay('created_at', '<', Carbon::today())->delete();
    }
}
