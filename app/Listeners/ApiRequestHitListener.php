<?php

namespace App\Listeners;

use App\Events\ApiRequestHit;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Cache;

class ApiRequestHitListener implements ShouldQueue
{
    use InteractsWithQueue, Queueable;
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

        $count = $this->checkAndGetCountFromArray($arrayOfHitsCount, $userId);

        $count++;

        $arrayOfHitsCount[$userId] = $count;

        Cache::put('api-users', $arrayOfHitsCount);
    }

    /**
     * @param array $countHits
     * @param int $userId
     *
     * @return int
     */
    protected function checkAndGetCountFromArray(array $countHits, int $userId): int
    {
        $count = 0;

        if (count($countHits) != 0)
        {
            $flippedArray = array_flip($countHits);

            if (isset($flippedArray) && in_array($userId, $flippedArray))
            {
                $count = array_search($userId, $flippedArray);
            }
        }

        return $count;
    }
}
