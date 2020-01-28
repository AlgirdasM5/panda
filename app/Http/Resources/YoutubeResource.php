<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class YoutubeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->resource->id,
            'title' => $this->resource->title,
            'tags' => $this->resource->tags,
            'aggregated_views' => $this->resource->aggregated_views,
        ];
    }
}
