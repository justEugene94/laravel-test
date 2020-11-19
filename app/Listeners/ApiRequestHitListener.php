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
        $userKey = 'user_' . $event->user->id;

        $arrayOfHitsCount = Cache::get('api-users', []);

        $count = $this->checkAndGetCountFromArray($arrayOfHitsCount, $userKey);

        $count++;

        $arrayOfHitsCount[$userKey] = $count;

        Cache::put('api-users', $arrayOfHitsCount);
    }

    /**
     * @param array $countHits
     * @param string $userKey
     *
     * @return int
     */
    protected function checkAndGetCountFromArray(array $countHits, string $userKey): int
    {
        $count = 0;

        if (count($countHits) != 0)
        {
            $flippedArray = array_flip($countHits);

            if (isset($flippedArray) && in_array($userKey, $flippedArray))
            {
                $count = array_search($userKey, $flippedArray);
            }
        }

        return $count;
    }
}
