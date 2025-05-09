<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class TaskResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => $this->collection,
            'links' => $this->paginationLinks(),
            'meta' => $this->paginationMeta(),
        ];
    }

}
