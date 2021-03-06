<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BranchResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'logo' => $this->logo,
            'restaurants' => RestaurantResource::collection($this->restaurants),
            'categories' => CategoryResource::collection($this->categories),
            'products' => ProductResource::collection($this->products),
        ];
    }
}
