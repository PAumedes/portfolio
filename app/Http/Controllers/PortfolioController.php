<?php

namespace App\Http\Controllers;

use App\Repositories\WorkRepository;
use App\Transformers\MediaTransformer;
use Inertia\Inertia;
use Inertia\Response;

class PortfolioController extends Controller
{
    public function __construct(
        private WorkRepository $workRepository
    ) {}

    /**
     * Display the portfolio grid with all works.
     */
    public function index(): Response
    {
        $works = $this->workRepository->getAllActive()->map(
            fn($work) => $this->transformWork($work)
        );

        return Inertia::render('PortfolioGrid', [
            'works' => $works,
        ]);
    }

    /**
     * Display a single work with its details and image gallery.
     */
    public function show(string $slug): Response
    {
        $work = $this->workRepository->findBySlug($slug);

        if (!$work) {
            abort(404);
        }

        return Inertia::render('WorkDetail', [
            'work' => $this->transformWork($work),
        ]);
    }

    /**
     * Transform work model to array for Inertia response.
     *
     * @param  \App\Models\Work  $work
     * @return array{id: int, title: string, slug: string, description: string, media: array}
     */
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
