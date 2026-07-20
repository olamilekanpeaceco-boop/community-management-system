<?php

namespace App\Notifications;

use App\Features\Memos\Models\Memo;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\DatabaseMessage;
use Illuminate\Notifications\Notification;

class MemoNotification extends Notification
{
    use Queueable;

    protected Memo $memo;

    public function __construct(Memo $memo)
    {
        $this->memo = $memo;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        $url = route('memos.show', $this->memo);

        return (new MailMessage)
            ->subject('New Memo: ' . $this->memo->title)
            ->greeting('Hello ' . ($notifiable->name ?? ''))
            ->line('A new memo has been sent to you.')
            ->line($this->memo->title)
            ->action('View Memo', $url)
            ->line('Thank you for using our application!');
    }

    public function toDatabase($notifiable)
    {
        return [
            'memo_id' => $this->memo->id,
            'title' => $this->memo->title,
            'snippet' => 
                strlen($this->memo->body) > 200 ? substr($this->memo->body, 0, 197) . '...' : $this->memo->body,
        ];
    }
}
