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
    public $originalUser;
    public $isNew;

    /**
     * Create a new notification instance.
     *
     * @param Task $task
     * @param type $originalUser
     */
    public function __construct(Task $task, $originalUser, $isNew) {
        $this->task = $task;
        $this->originalUser = $originalUser;
        $this->isNew = $isNew;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable) {
        if (!empty($this->task->user->discord_channel)) {
            return [DiscordChannel::class, 'mail'];
        } else
            return ['mail'];
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
                        ->subject('New Task Assignment')
                        ->greeting('Hello! Your team needs your help with the following task :')
                        ->line($this->task->name)
                        ->action('Show me', $url)
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

        if ($discord_user != null) {
            $user = '<@' . $discord_user . '>';
        } else {
            $user = $this->task->user->fullName();
        }

        if ($this->isNew) {
            $msg = $user . ' has been assigned to the task : **' . $this->task->name . '** ' . $url;
        } else {
            if ($this->originalUser != null) {
                $msg = '**' . $this->task->name . '** ' . $url . ' has been reassigned to ' . $user;
            }
        }

        return DiscordMessage::create($msg);
    }

}
