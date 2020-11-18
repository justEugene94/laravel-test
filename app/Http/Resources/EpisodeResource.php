<?php

namespace App\Http\Resources;

use App\Models\Episode;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property Episode $resource
 */
class EpisodeResource extends JsonResource
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
            'title' => $this->resource->title,
            'air_date' => $this->resource->air_date,
            'characters' => CharacterResource::collection($this->whenLoaded('characters')),
        ];
    }
}
