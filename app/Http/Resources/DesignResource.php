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
            'categories' => $this->categories()->pluck('id'),
            'data' => $this->transformedData(),
            'thumbnail' => $this->getFirstMediaUrl('preview'),
            'created_at' => $this->created_at,
        ];
    }

    private function transformedData()
    {
        $data = [
            'items' => collect($this->data['items'])->map(function ($item) {
                if ( isset($item['image_data'] ) ) {
                    $item['image_data']['img'] = Media::findOrFail($item['image_data']['media'])->getFullUrl();
                    unset($item['image_data']['media']);
                }

                return $item;
            }),
            'bg_image' => $this->getFirstMediaUrl('background')
        ];
        array_walk_recursive( $data, [ $this, 'int_to_float' ] );

        return $data;
    }

    public function int_to_float( $data ) {
        if( is_int( $data ) ) {
            return floatval( $data );
        }

        return $data;
    }
}
