<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Resources\EpisodeResource;
use App\Http\Responses\Api\Response;
use App\Models\Episode;

class EpisodesController extends Controller
{
    /**
     * @return Response
     */
    public function index()
    {
        $episodes = Episode::query()->paginate(10);

        $resource = EpisodeResource::collection($episodes);

        return Response::make($resource, 200);
    }
}
