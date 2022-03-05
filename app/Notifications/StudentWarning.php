<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class StudentWarning extends Notification implements ShouldQueue
{
    use Queueable;

    private $student;
    private $warning;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($student, $warning)
    {
        $this->student = $student;
        $this->warning = $warning;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line(__('warning.student') . " #{$this->student->id} {$this->student->name}")
            ->line(__('warning.issued'))
            ->action(__('warning_click_here'), url("/school/warning/{$this->warning->id}"))
            ->line(__('messages.thank_you'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
