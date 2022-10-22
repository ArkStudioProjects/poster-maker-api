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
            'thumbnail' => str_replace( '/storage/', '/manipulation/thumbnail/', $this->getFirstMediaUrl('preview') ),
            'created_at' => $this->created_at,
        ];
    }

    private function transformedData()
    {
        return [
            'items' => collect($this->data['items'])->map(function ($item) {

                if ( isset($item['text_data'] ) ) {
                    $item['text_data']['text_stroke_color'] = null;
                }

                if ( isset($item['image_data'] ) ) {
                    $item['image_data']['img'] = Media::findOrFail($item['image_data']['media'])->getFullUrl();
                    unset($item['image_data']['media']);
                }

                array_walk_recursive( $item, [ $this, 'int_to_float' ] );

                return $item;
            }),
            'bg_image' => $this->getFirstMediaUrl('background'),
        ];
    }

    public function int_to_float( &$data ) {
        if( is_int( $data ) ) {
            $data = floatval( $data );
        }
    }
}
