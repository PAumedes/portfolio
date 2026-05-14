<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Services\ContactService;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class ContactController extends Controller
{
    public function __construct(
        protected ContactService $service
    ) {}

    /**
     * Display the contact form page.
     */
    public function show(): Response
    {
        return Inertia::render('Contact');
    }

    /**
     * Handle the incoming contact request.
     *
     * Processes validated contact form data and dispatches notifications.
     */
    public function store(ContactRequest $request): RedirectResponse
    {
        $this->service->handleMessage($request->validated());

        return redirect()->back()->with('success', 'Thank you for your message. I will be in touch shortly.');
    }
}

