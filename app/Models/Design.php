<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Design extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    const TYPE_IMAGE = 'IMAGE';
    const TYPE_TEXT = 'TEXT';

    protected $casts = [
        'data' => 'array'
    ];

    protected $fillable = [
        'title',
        'data',
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
