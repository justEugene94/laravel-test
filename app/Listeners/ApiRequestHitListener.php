<?php

namespace App\Listeners;

use App\Events\ApiRequestHit;
use App\Services\RequestHitsService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Cache;

class ApiRequestHitListener implements ShouldQueue
{
    use InteractsWithQueue, Queueable;

    /**
     * @var RequestHitsService
     */
    protected $service;

    /**
     * ApiRequestHitListener constructor.
     *
     * @param RequestHitsService $service
     */
    public function __construct(RequestHitsService $service)
    {
        $this->service = $service;
    }

    /**
     * Handle the event.
     *
     * @param  ApiRequestHit  $event
     * @return void
     */
    public function handle(ApiRequestHit $event)
    {
        $userId = $event->user->id;

        $arrayOfHitsCount = Cache::get('api-users', []);

        $count = $this->service->checkAndGetCountFromArray($arrayOfHitsCount, $userId);

        $count++;

        $arrayOfHitsCount[$userId] = $count;

        Cache::put('api-users', $arrayOfHitsCount);
    }


}
