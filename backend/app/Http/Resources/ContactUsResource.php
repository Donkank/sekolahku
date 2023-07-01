<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContactUsResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'        => $this->id,
            'name'      => $this->name,
            'email'     => $this->email,
            'message'   => $this->message,
            'read'      => $this->read > 0 ? true : false,
            'date'      => $this->created_at->diffForHumans()
        ];
    }
}
