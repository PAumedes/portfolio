<?php

namespace App\Http\Controllers;

use App\Repositories\WorkRepository;
use App\Transformers\MediaTransformer;
use Inertia\Inertia;

class PortfolioController extends Controller
{
    public function __construct(
        private WorkRepository $workRepository
    ) {}

    public function index()
    {
        $works = $this->workRepository->getAllActive()->map(
            fn($work) => $this->transformWork($work)
        );

        return Inertia::render('PortfolioGrid', [
            'works' => $works,
        ]);
    }

    public function show(string $slug)
    {
        $work = $this->workRepository->findBySlug($slug);

        if (!$work) {
            abort(404);
        }

        return Inertia::render('WorkDetail', [
            'work' => $this->transformWork($work),
        ]);
    }

    private function transformWork($work): array
    {
        return [
            'id' => $work->id,
            'title' => $work->title,
            'slug' => $work->slug,
            'description' => $work->description,
            'media' => MediaTransformer::transformCollection($work->getMedia('default')),
        ];
    }
}
