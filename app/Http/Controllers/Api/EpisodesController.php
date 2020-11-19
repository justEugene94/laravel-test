<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Resources\EpisodeResource;
use App\Http\Responses\Api\Response;
use App\Models\Episode;
use Illuminate\Auth\Access\AuthorizationException;

class EpisodesController extends Controller
{
    /**
     * @return Response
     *
     * @throws AuthorizationException
     */
    public function index()
    {
        /** @var Episode $episodes */
        $episodes = Episode::query()->paginate(10);

        $this->authorize([Episode::class]);

        $resource = EpisodeResource::collection($episodes);

        return Response::make($resource, 200);
    }

    /**
     * @param int $episode_id
     *
     * @return Response
     *
     * @throws AuthorizationException
     */
    public function show(int $episode_id)
    {
        /** @var Episode $episode */
        $episode = Episode::query()->with('characters')->findOrFail($episode_id);

        $this->authorize($episode);

        $resource = EpisodeResource::make($episode);

        return Response::make($resource, 200);
    }
}
