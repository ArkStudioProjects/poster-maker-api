<?php

namespace App\Http\Resources;

use App\Models\Design;
use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class DesignResource extends JsonResource
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
            'data' => $this->transformedData(),
            'thumbnail' => $this->getFirstMediaUrl('preview'),
            'created_at' => $this->created_at,
        ];
    }

    private function transformedData()
    {
        return collect($this->data)->map(function ($item) {
            switch ($item['type']) {
                case Design::TYPE_IMAGE:
                    $item['media'] = Media::findOrFail($item['media'])->getFullUrl();
                    break;
            }

            return $item;
        });
    }
}
