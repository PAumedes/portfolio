<?php

namespace App\Http\Resources;

use App\Transformers\MediaTransformer;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WorkResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'media' => MediaTransformer::transformCollection($this->getMedia('default')),
        ];
    }
}
