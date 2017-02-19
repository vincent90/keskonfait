<?php

namespace App\Notifications;

use App\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use NotificationChannels\Discord\DiscordChannel;
use NotificationChannels\Discord\DiscordMessage;

class TaskAssignedNotification extends Notification implements ShouldQueue {

    use Queueable;

    public $task;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Task $task) {
        $this->task = $task;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable) {
        return [DiscordChannel::class, 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable) {
        $url = route('tasks.show', ['id' => $this->task->id]);

        return (new MailMessage)
                        ->line('You been assigned to the task : ' . $this->task->name)
                        ->action('Show me!', $url)
                        ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable) {
        return [
                //
        ];
    }

    public function toDiscord($notifiable) {
        $url = route('tasks.show', ['id' => $this->task->id]);

        if ($this->task->user->discord_user != null) {
            $msg = '<@' . $this->task->user->discord_user . '> has been assigned to the task : **' . $this->task->name . '** -> Link : ' . $url;
        } else {
            $msg = $this->task->user->fullName() . ' has been assigned to the task : **' . $this->task->name . '** -> Link : ' . $url;
        }
        return DiscordMessage::create($msg);
    }

}
