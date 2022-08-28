<?php

namespace App\ImageFilter;

use Intervention\Image\Image;
use Intervention\Image\Filters\FilterInterface;

class Thumbnail implements FilterInterface
{
    public function applyFilter(Image $image)
    {
        return $image->fit(119, 168);
    }
}
