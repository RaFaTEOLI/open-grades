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
    protected $description = 'Command description';

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
        $response_times = $redis->get('API_RESPONSE_TIMES');
        $redis->set('API_RESPONSE_TIMES', json_encode([]));
        $response_times = json_decode($response_times);
        $response_times = array_filter($response_times);
        if (count($response_times) < 1) {
            $average = 0;
        } else {
            //convert from microseconds to ms
            $average = array_sum($response_times) / count($response_times);
        }
        ApiResponseTime::create([
            'time' => $average,
            'count' => count($response_times),
        ]);
    }
}
