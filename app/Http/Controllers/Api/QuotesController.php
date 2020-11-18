<?php


namespace App\Http\Controllers\Api;


use App\Http\Resources\QuoteResource;
use App\Http\Responses\Api\Response;
use App\Models\Quote;

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
}
