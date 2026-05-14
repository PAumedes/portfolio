<?php

namespace App\Services;

use App\Notifications\ContactFormNotification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class ContactService
{
    /**
     * Process the contact request.
     * 
     * This abstracts the logic for sending emails, storing in the DB, 
     * or notifying Slack/Discord.
     */
    public function handleMessage(array $data): void
    {
        // Log non-sensitive metadata only (never log email, name, or message content for privacy)
        Log::info('Processing contact request', ['timestamp' => now()->toIso8601String()]);

        $adminEmail = config('mail.from.address');
        $user = \App\Models\User::first();
        
        $notification = new ContactFormNotification($data);

        // Always send email via on-demand routing
        Notification::route('mail', $adminEmail)->notify($notification);

        // Also store in DB if we have a real user to attach it to
        if ($user) {
            $user->notify($notification);
        } else {
            Log::warning('Contact notification not stored in database: No admin user found.');
        }
    }


}
