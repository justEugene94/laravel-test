<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Resources\CharacterResource;
use App\Http\Responses\Api\Response;
use App\Models\Character;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CharactersController extends Controller
{
    /**
     * @param Request $request
     *
     * @return Response
     * @throws AuthorizationException
     */
    public function index(Request $request)
    {
        $name = $request->input('name');

        $this->authorize('viewAny', [Character::class]);

        $charactersQuery = Character::query()->with('quotes', 'episodes');

        if ($name) {
            $charactersQuery->where(DB::raw('lower(name)'), 'LIKE', '%' . strtolower($name) . '%');
        }

        $characters = $charactersQuery->paginate(10);

        $resource = CharacterResource::collection($characters);

        return Response::make($resource);
    }

    /**
     * @return Response
     * @throws AuthorizationException
     */
    public function random()
    {
        /** @var Character $character */
        $character = Character::query()->with('quotes', 'episodes')->inRandomOrder()->firstOrFail();

        $this->authorize('view', $character);

        $resource = CharacterResource::make($character);

        return Response::make($resource);
    }
}
