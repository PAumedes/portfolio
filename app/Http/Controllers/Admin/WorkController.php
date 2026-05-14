<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Work;
use App\Repositories\WorkRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class WorkController extends Controller
{
    public function __construct(
        private WorkRepository $workRepository
    ) {}

    /**
     * Display paginated list of works.
     */
    public function index(): Response
    {
        $this->authorize('viewAny', Work::class);

        return Inertia::render('Admin/Works/Index', [
            'works' => $this->workRepository->getPaginated(12),
        ]);
    }

    /**
     * Display work creation form.
     */
    public function create(): Response
    {
        $this->authorize('create', Work::class);

        return Inertia::render('Admin/Works/Create');
    }

    /**
     * Store a newly created work.
     */
    public function store(Request $request): RedirectResponse
    {
        $this->authorize('create', Work::class);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required|image|max:10240',
        ]);

        $work = Work::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'description' => $request->description,
        ]);

        if ($request->hasFile('image')) {
            $work->addMediaFromRequest('image')->toMediaCollection('default');
        }

        return redirect()->route('admin.works.index')->with('success', 'Work created successfully.');
    }

    /**
     * Display work editing form.
     */
    public function edit(Work $work): Response
    {
        $this->authorize('update', $work);

        return Inertia::render('Admin/Works/Edit', [
            'work' => $work->load('media'),
        ]);
    }

    /**
     * Update an existing work.
     */
    public function update(Request $request, Work $work): RedirectResponse
    {
        $this->authorize('update', $work);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|max:10240',
        ]);

        $work->update([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'description' => $request->description,
        ]);

        if ($request->hasFile('image')) {
            $work->clearMediaCollection('default');
            $work->addMediaFromRequest('image')->toMediaCollection('default');
        }

        return redirect()->route('admin.works.index')->with('success', 'Work updated successfully.');
    }

    /**
     * Delete a work and its media.
     */
    public function destroy(Work $work): RedirectResponse
    {
        $this->authorize('delete', $work);

        $work->clearMediaCollection('default');
        $work->delete();

        return redirect()->route('admin.works.index')->with('success', 'Work deleted successfully.');
    }
}
