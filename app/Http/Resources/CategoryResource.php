<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'parent_id' => $this->parent_id,
            'icon' => $this->icon,
            // 'image' => $this->image,
            'image' => $this->medium_image_url,
            'slug' => $this->slug,
            'top' => $this->top,
            'is_active'=> $this->is_active,
            'name'=> $this->name,
        ];
    }
}
