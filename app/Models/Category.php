<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public function scopeTopLevel( $query )
    {
        $query->whereNull('parent_id');
    }

    public function subCategories()
    {
        return $this->hasMany( self::class, 'parent_id' );
    }

    public function designs()
    {
        return $this->belongsToMany(Design::class);
    }
}
