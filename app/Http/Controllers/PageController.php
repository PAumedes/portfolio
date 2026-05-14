<?php

namespace App\Http\Controllers;

use Inertia\Response;
use Inertia\Inertia;

class PageController extends Controller
{
    /**
     * Display the home page.
     */
    public function home(): Response
    {
        return Inertia::render('Home');
    }

    /**
     * Display the about page with biography and approach.
     */
    public function about(): Response
    {
        return Inertia::render('About');
    }
}
