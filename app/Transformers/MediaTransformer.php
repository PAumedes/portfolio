<?php

namespace App\Transformers;

use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MediaTransformer
{
    public static function transform(Media $media): array
    {
        return [
            'id' => $media->id,
            'thumb' => $media->getUrl('thumb'),
            'preview' => $media->getUrl('preview'),
            'preview_fallback' => $media->getUrl('preview_fallback'),
            'name' => $media->name,
        ];
    }

    public static function transformCollection($mediaCollection): array
    {
        return $mediaCollection->map(fn(Media $media) => self::transform($media))->toArray();
    }
}
