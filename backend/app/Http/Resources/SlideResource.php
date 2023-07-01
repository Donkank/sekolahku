<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SlideResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'        => $this->id,
            'url'       => asset('storage/slides/' . $this->url),
            'caption'   => $this->title,
            'alt'       => $this->alt ? $this->alt : 'foto',
            'desc'      => $this->desc ? $this->desc : 'Foto ' . $this->title
        ];
    }
}
