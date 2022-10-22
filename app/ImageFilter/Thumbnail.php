<?php

namespace App\ImageFilter;

use Intervention\Image\Image;
use Intervention\Image\Filters\FilterInterface;

class Thumbnail implements FilterInterface
{
    public function applyFilter(Image $image)
    {
        return $image->resize(119, 168, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        })->encode(('webp'), 20);
    }
}
