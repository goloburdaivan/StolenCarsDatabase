<?php

namespace App\Http\Resources;

use App\Models\AutoMake;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin AutoMake
 */
class AutoMakeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'marks' => AutoModelResource::collection($this->whenLoaded('models')),
        ];
    }
}
