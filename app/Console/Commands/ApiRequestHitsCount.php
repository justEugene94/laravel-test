<?php

namespace App\Console\Commands;

use App\Services\RequestHitsService;
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
     * @var RequestHitsService
     */
    protected $service;

    /**
     * Create a new command instance.
     *
     * @param RequestHitsService $service
     */
    public function __construct(RequestHitsService $service)
    {
        parent::__construct();

        $this->service = $service;
    }

    /**
     * Execute the console command.
     *
     * @return bool
     */
    public function handle()
    {
        $arrayOfHitsCount = Cache::get('api-users');

        $count = $this->service->sumAllUserHits($arrayOfHitsCount);

        $this->info("Count of user hits {$count}");

        return true;
    }
}
