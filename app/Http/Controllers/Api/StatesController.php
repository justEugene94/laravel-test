<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Responses\Api\Response;
use App\Services\RequestHitsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class StatesController extends Controller
{
    /** @var RequestHitsService */
    protected $service;

    /**
     * StatesController constructor.
     *
     * @param RequestHitsService $service
     */
    public function __construct(RequestHitsService $service)
    {
        $this->service = $service;
    }

    /**
     * @return Response
     */
    public function index()
    {
        $arrayOfHitsCount = Cache::get('api-users');

        $count = $this->service->sumAllUserHits($arrayOfHitsCount);

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
