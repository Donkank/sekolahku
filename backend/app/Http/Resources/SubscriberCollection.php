<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class SubscriberCollection extends ResourceCollection
{
    private $pagination;

    public function __construct($resource)
    {
        $page = $resource->perPage();
        $total = $resource->total();
        $count = $resource->count();
        $last = $resource->lastPage();
        $current = $resource->currentPage();
        $from = 1 + ($current - 1) * $page;
        $limit = $last > 10 ? 10 : $last;
        $prev_page = $current <= 1 ? null : $current - 1;
        $next_page = $current == $last ? null : $current + 1;

        $this->pagination = [
            'total' => $total,
            'count' => $count,
            'current_page' => $current,
            'limit' => $limit,
            'prev_page' => $prev_page,
            'next_page' =>  $next_page,
            'from'  => $from,
            'to' => $from + $count - 1,
        ];

        $resource = $resource->getCollection();

        parent::__construct($resource);
    }

    public function toArray(Request $request): array
    {
        return [
            'subscribers'  => SubscriberResource::collection($this->collection),
            'meta'         => $this->pagination,
        ];
    }
}
