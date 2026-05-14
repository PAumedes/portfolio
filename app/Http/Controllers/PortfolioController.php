<?php

namespace App\Http\Controllers;

use App\Models\Work;
use Illuminate\Support\Facades\Cache;
use Inertia\Inertia;

class PortfolioController extends Controller
{
    public function index()
    {
        $works = Cache::remember('portfolio_works', 3600, function () {
            return Work::with('media')->latest()->get()->map(function ($work) {
                return [
                    'id' => $work->id,
                    'title' => $work->title,
                    'slug' => $work->slug,
                    'description' => $work->description,
                    'media' => $work->getMedia('default')->map(function ($media) {
                        return [
                            'id' => $media->id,
                            'thumb' => $media->getUrl('thumb'),
                            'preview' => $media->getUrl('preview'),
                            'preview_fallback' => $media->getUrl('preview_fallback'),
                            'name' => $media->name,
                        ];
                    }),
                ];
            });
        });

        return Inertia::render('PortfolioGrid', [
            'works' => $works,
        ]);
    }

    public function show(string $slug)
    {
        $work = Work::where('slug', $slug)->with('media')->firstOrFail();

        $workData = [
            'id' => $work->id,
            'title' => $work->title,
            'slug' => $work->slug,
            'description' => $work->description,
            'media' => $work->getMedia('default')->map(function ($media) {
                return [
                    'id' => $media->id,
                    'thumb' => $media->getUrl('thumb'),
                    'preview' => $media->getUrl('preview'),
                    'preview_fallback' => $media->getUrl('preview_fallback'),
                    'name' => $media->name,
                ];
            }),
        ];

        return Inertia::render('WorkDetail', [
            'work' => $workData,
        ]);
    }
}
