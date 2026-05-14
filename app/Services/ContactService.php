<?php

namespace App\Services;

use App\Models\User;
use App\Notifications\ContactFormNotification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class ContactService
{
    /**
     * Process the contact request.
     *
     * Sends notification email to admin and stores in database.
     * Privacy: Never logs email, name, or message content.
     */
    public function handleMessage(array $data): void
    {
        Log::info('Processing contact request', ['timestamp' => now()->toIso8601String()]);

        $adminEmail = config('mail.from.address');
        $notification = new ContactFormNotification($data);

        Notification::route('mail', $adminEmail)->notify($notification);

        $adminUser = User::whereIsAdmin(true)->first();

        if ($adminUser) {
            $adminUser->notify($notification);
        } else {
            Log::warning('Contact notification not stored in database: No admin user configured.');
        }
    }
}
