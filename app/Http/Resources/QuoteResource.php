<?php


namespace App\Http\Resources;


use App\Models\Quote;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property Quote $resource
 */
class QuoteResource extends JsonResource
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
            'name' => $this->resource->quote,
            'character' => CharacterResource::make($this->whenLoaded('character')),
        ];
    }
}
