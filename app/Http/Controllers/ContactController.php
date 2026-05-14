<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Services\ContactService;
use Inertia\Inertia;

class ContactController extends Controller
{
    public function __construct(
        protected ContactService $service
    ) {}

    /**
     * Display the contact form page.
     */
    public function show()
    {
        return Inertia::render('Contact');
    }

    /**
     * Handle the incoming contact request.
     */
    public function store(ContactRequest $request)
    {
        $this->service->handleMessage($request->validated());
        
        return redirect()->back()->with('success', 'Thank you for your message. I will be in touch shortly.');
    }
}

