<?php


namespace App\Http\Controllers\Api;


use App\Http\Resources\QuoteResource;
use App\Http\Responses\Api\Response;
use App\Models\Quote;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuotesController
{
    /**
     * @return Response
     */
    public function index()
    {
        /** @var Quote $quotes */
        $quotes = Quote::query()->with('character')->paginate(10);

        $resource = QuoteResource::collection($quotes);

        return Response::make($resource);
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function random(Request $request)
    {
        $name = $request->input('author');

        $quoteQuery = Quote::query()->with('character');

        if ($name)
        {
            $quoteQuery->whereHas('character', function (Builder $builder) use ($name) {
                $builder->where(DB::raw('lower(name)'), 'LIKE', '%' . strtolower($name) . '%');
            });
        }

        $quote = $quoteQuery->inRandomOrder()->firstOrFail();

        $resource = QuoteResource::make($quote);

        return Response::make($resource);
    }
}
