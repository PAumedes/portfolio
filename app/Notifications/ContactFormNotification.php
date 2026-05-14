<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ContactFormNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        protected array $data
    ) {}

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New Portfolio Contact Request: ' . ($this->data['name'] ?? 'Inquiry'))
            ->greeting('Hello!')
            ->line('You have received a new message from your portfolio contact form.')
            ->line('**Name:** ' . ($this->data['name'] ?? 'N/A'))
            ->line('**Email:** ' . ($this->data['email'] ?? 'N/A'))
            ->line('**Message:**')
            ->line($this->data['message'] ?? 'No message content.')
            ->action('View Admin Dashboard', route('admin.works.index'))
            ->line('Thank you for using your portfolio!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'name' => $this->data['name'],
            'email' => $this->data['email'],
            'message' => $this->data['message'],
        ];
    }
}
