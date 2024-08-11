<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Design extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $casts = [
        'data' => 'array'
    ];

    protected $fillable = [
        'title',
        'data',
    ];

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('preview')
            ->registerMediaConversions( function (Media $media) {
                $this
                    ->addMediaConversion('thumbnail')
                    ->width(119)
                    ->height(168);
            } );
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function categories()
    {
        return $this->belongsToMany( Category::class );
    }
}
