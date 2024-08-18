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
        'data' => 'array',
        'keywords' => 'array',
    ];

    protected $fillable = [
        'title',
        'data',
        'keywords',
    ];

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('preview')
            ->registerMediaConversions( function (Media $media) {
                $this
                    ->addMediaConversion('thumbnail')
                    ->optimize()
                    ->width(119 * 2)
                    ->height(168 * 2)
                    ->format('webp');
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
