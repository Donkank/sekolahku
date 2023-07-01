<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostShowResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'title'         => $this->title,
            'author'        => new UserResource($this->user),
            'category'      => new CategoryResource($this->category),
            'tags'          => TagResource::collection($this->tags),
            'body'          => $this->body,
            'created_at'    => $this->created_at->diffForHumans(),
            'updated_at'    => $this->updated_at->diffForHumans(),
            'comments'      => CommentReplyResource::collection($this->comments->where('parent_id', 0)),
        ];
    }
}
