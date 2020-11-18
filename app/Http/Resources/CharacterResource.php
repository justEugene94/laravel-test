<?php


namespace App\Http\Resources;


use App\Models\Character;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property Character $resource
 */
class CharacterResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'birthday' => $this->resource->birthday,
            'occupations' => $this->resource->occupations,
            'img' => $this->resource->img,
            'nickname' => $this->resource->nickname,
            'portrayed' => $this->resource->portrayed,
            'episodes' => EpisodeResource::collection($this->whenLoaded('episodes')),
            'quotes' => QuoteResource::collection($this->whenLoaded('quotes')),
        ];
    }
}
