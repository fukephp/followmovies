<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MovieResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'slug'          => $this->slug,
            'title'         => $this->title,
            'caption'       => $this->caption,
            'image_url'     => $this->image_url,
            'rating'        => $this->rating,
            'vote_count'    => $this->vote_count,
            'released_at'   => $this->released_at,
            'created_at'    => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at'    => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
