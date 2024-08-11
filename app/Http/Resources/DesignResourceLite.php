<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DesignResourceLite extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'categories' => $this->categories()->pluck('id'),
            'thumbnail' => $this->getThumbnail(),
            'created_at' => $this->created_at,
        ];
    }

    private function getThumbnail()
    {
        return $this->getFirstMediaUrl('preview', 'thumbnail');
    }
}
