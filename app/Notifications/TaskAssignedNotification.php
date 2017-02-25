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

    /**
     * Get the Discord representation of the notification.
     *
     * @param type $notifiable
     * @return type
     */
    public function toDiscord($notifiable) {
        $url = route('tasks.show', ['id' => $this->task->id]);
        $discord_channel = $this->task->user->discord_channel;
        $discord_user = $this->task->user->discord_user;
        $taskName = $this->task->name;
        $userFullName = $this->task->user->fullName();

        if (!empty($discord_channel) && !empty($discord_user)) {
            $msg = '<@' . $discord_user . '> has been assigned to the task : **' . $taskName . '** -> Link : ' . $url;
        } else if (!empty($discord_channel)) {
            $msg = $userFullName . ' has been assigned to the task : **' . $taskName . '** -> Link : ' . $url;
        }

        return DiscordMessage::create($msg);
    }

}
