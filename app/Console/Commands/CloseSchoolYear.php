<?php

namespace App\Console\Commands;

use App\Models\Year;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CloseSchoolYear extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:closeSchoolYear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Closes school years';

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
        Year::where('end_date', '<', Carbon::now()->isoFormat('YYYY-MM-DD'))->update(["closed" => 1]);
    }
}
