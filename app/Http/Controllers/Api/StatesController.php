<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Responses\Api\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class StatesController extends Controller
{
    /**
     * @return Response
     */
    public function index()
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

        return Response::make([
            'states' => $count,
        ], 200);
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function show(Request $request)
    {
        $count = 0;

        $user = $request->user();

        $arrayOfHitsCount = Cache::get('api-users');

        if ($arrayOfHitsCount[$user->id])
        {
            $count = $arrayOfHitsCount[$user->id];
        }

        return Response::make([
            'states' => $count,
        ], 200);
    }
}
