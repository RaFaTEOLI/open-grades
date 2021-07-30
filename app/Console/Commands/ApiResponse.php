<?php

namespace App\Console\Commands;

use App\Models\ApiResponseTime;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class ApiResponse extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:apiresponse';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to save new api response times';

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
        $redis = Redis::connection();
        $responseTimes = $redis->get('API_RESPONSE_TIMES');
        $redis->set('API_RESPONSE_TIMES', json_encode([]));
        $responseTimes = json_decode($responseTimes);
        $responseTimes = array_filter($responseTimes);

        if (count($responseTimes) < 1) {
            $average = 0;
        } else {
            //convert from microseconds to ms
            $average = array_sum($responseTimes) / count($responseTimes);
        }

        if (count($responseTimes)) {
            ApiResponseTime::create([
                'time' => $average,
                'count' => count($responseTimes),
            ]);
        }
    }
}
