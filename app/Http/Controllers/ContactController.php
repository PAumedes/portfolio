<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use Inertia\Inertia;

class ContactController extends Controller
{
    /**
     * Display the contact form page.
     */
    public function show()
    {
        return Inertia::render('Contact');
    }

    /**
     * Handle the incoming contact request.
     *
     * We use a dedicated FormRequest to ensure data integrity and clean controllers.
     */
    public function store(ContactRequest $request)
    {
        // Logic to dispatch an email or save to DB goes here.
        // Returning back with a flash message upon successful validation.
        
        return redirect()->back()->with('success', 'Thank you for your message. I will be in touch shortly.');
    }
}
