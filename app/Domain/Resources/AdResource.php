<?php

namespace App\Domain\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $created_at
 * @property mixed $photo
 * @property mixed $description
 * @property mixed $category
 * @property mixed $price
 * @property mixed $preview
 * @property mixed $name
 * @property mixed $id
 */
class AdResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        $extra = $request->get('fields') ?? [];

        return [
            'id' => $this->id,
            'name' => $this->name,
            'preview' => new PhotoResource($this->preview),
            'price' => $this->price,
            'category' => $this->category,
            'description' => $this->description,
           // 'photo' => $this->when(in_array('photo', $extra), PhotoResource::collection($this->photo)),
            'created_at' => $this->created_at->format('H:i d.m.Y'),
        ];
    }
}
