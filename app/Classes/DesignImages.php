<?php

namespace App\Classes;

use App\Models\Design;

class DesignImages {
    public static function extract(Design $design) {
        $data = $design->data;

        foreach ($data['items'] as &$node) {
            if( !isset( $node['image_data'] ) ) {
                continue;
            }
            $media = self::setDesignMedia($design, $node['image_data']['img'], 'node-images');

            unset( $node['image_data']['img'] );
            $node['image_data']['media'] = $media->id;
        }

        $data['bg_image'] = self::setDesignMedia($design, $data['bg_image'], 'background');

        $design->data = $data;
        $design->save();
    }

    public static function setDesignMedia($design, $base64Data, $collection) {
        return $design->addMediaFromBase64($base64Data)
            ->usingFileName(md5($base64Data) . '.png')
            ->toMediaCollection($collection);
    }
}
