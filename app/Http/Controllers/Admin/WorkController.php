<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Work;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;

class WorkController extends Controller
{
    public function index()
    {
        $works = Work::with('media')->latest()->get();
        return Inertia::render('Admin/Works/Index', [
            'works' => $works
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Works/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required|image|max:10240', // max 10MB
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
}
