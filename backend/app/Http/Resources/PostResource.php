<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'title'         => $this->title,
            'slug'          => $this->slug,
            'author'        => $this->user->name,
            'views'         => $this->views,
            'category'      => new CategoryResource($this->category),
            'tags'          => TagResource::collection($this->tags),
            'images'        => ImageResource::collection($this->images),
            'headline'      => $this->headline,
            'created_at'    => $this->created_at->diffForHumans(),
            'updated_at'    => $this->updated_at->diffForHumans(),
        ];
    }
}
