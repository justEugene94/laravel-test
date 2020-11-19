<?php


namespace App\Services;


class RequestHitsService
{
    /**
     * @param array $arrayOfHitsCount
     *
     * @return int
     */
    public function sumAllUserHits(array $arrayOfHitsCount): int
    {
        $count = 0;

        if (count($arrayOfHitsCount) != 0)
        {
            foreach ($arrayOfHitsCount as $userId => $userHits)
            {
                $count += $userHits;
            }
        }

        return $count;
    }

    /**
     * @param array $countHits
     * @param int $userId
     *
     * @return int
     */
    public function checkAndGetCountFromArray(array $countHits, int $userId): int
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
