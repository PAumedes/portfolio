<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Work extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = ['title', 'slug', 'description'];

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumb')
             ->width(400)
             ->format('webp')
             ->nonQueued();

        $this->addMediaConversion('preview')
             ->width(1600)
             ->format('avif')
             ->nonQueued();
             
        $this->addMediaConversion('preview_fallback')
             ->width(1600)
             ->format('webp')
             ->nonQueued();
    }
}
