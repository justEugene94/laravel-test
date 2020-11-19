<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class ApiRequestHitsCount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'request-hits-count';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Count request hits';

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
     * @return bool
     */
    public function handle()
    {
        $count = 0;

        $arrayOfHitsCount = Cache::get('api-users');

        if (count($arrayOfHitsCount) != 0)
        {
            foreach ($arrayOfHitsCount as $userKey => $userHits)
            {
                $count += $userHits;
            }
        }

        $this->info("Count of user hits {$count}");

        return true;
    }
}
