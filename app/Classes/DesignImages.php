<?php

namespace App\Classes;

use App\Models\Design;

class DesignImages {
    public static function extract(Design $design) {
        $data = $design->data;

        foreach ($data as &$node) {
            if( $node['type'] !== Design::TYPE_IMAGE ) {
                continue;
            }
            $media = self::setDesignMedia($design, $node['data'], 'node-images');

            unset( $node['data'] );
            $node['media'] = $media->id;
        }

        $design->data = $data;
        $design->save();
    }

    public static function setDesignMedia($design, $base64Data, $collection) {
        return $design->addMediaFromBase64($base64Data)
            ->usingFileName(md5($base64Data) . '.png')
            ->toMediaCollection($collection);
    }
}
