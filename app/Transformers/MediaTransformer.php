<?php

namespace App\Transformers;

use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * Transform Spatie media objects to arrays with processed URLs.
 *
 * Provides consistent media format across controllers and APIs.
 * Includes thumbnail, preview (AVIF), and preview fallback (WebP) URLs.
 */
class MediaTransformer
{
    /**
     * Transform a single media item to an array with processed URLs.
     *
     * @return array{id: int, thumb: string, preview: string, preview_fallback: string, name: string}
     */
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

    /**
     * Transform a media collection to an array of transformed items.
     *
     * @param iterable<Media> $mediaCollection
     * @return array<int, array{id: int, thumb: string, preview: string, preview_fallback: string, name: string}>
     */
    public static function transformCollection($mediaCollection): array
    {
        return $mediaCollection->map(fn(Media $media) => self::transform($media))->toArray();
    }
}
