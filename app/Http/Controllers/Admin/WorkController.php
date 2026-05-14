<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Work;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Inertia\Inertia;

class WorkController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Work::class);

        $works = Work::with('media')->latest()->get();

        return Inertia::render('Admin/Works/Index', [
            'works' => $works,
        ]);
    }

    public function create()
    {
        $this->authorize('create', Work::class);

        return Inertia::render('Admin/Works/Create');
    }

    public function store(Request $request)
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

        Cache::forget('portfolio_works');

        return redirect()->route('admin.works.index')->with('success', 'Work created successfully.');
    }

    public function edit(Work $work)
    {
        $this->authorize('update', $work);

        return Inertia::render('Admin/Works/Edit', [
            'work' => $work->load('media'),
        ]);
    }

    public function update(Request $request, Work $work)
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

        Cache::forget('portfolio_works');

        return redirect()->route('admin.works.index')->with('success', 'Work updated successfully.');
    }

    public function destroy(Work $work)
    {
        $this->authorize('delete', $work);

        $work->clearMediaCollection('default');
        $work->delete();

        Cache::forget('portfolio_works');

        return redirect()->route('admin.works.index')->with('success', 'Work deleted successfully.');
    }
}
