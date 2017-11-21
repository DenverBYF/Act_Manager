<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class tipMail extends Notification
{
    use Queueable;

	protected $workData;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($workData)
    {
        //
		$this->workData = $workData;
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
    	$message = new MailMessage();
		$message->line(env('group_name','Group')."成员:");
		$message->line("  你好,今天是".date("Y.m.d").",你在今天仍需要进行的工作如下:");
		for ($i = 0; $i < count($this->workData); $i++){
			$message->line("    工作".($i+1).":");
			$message->line("      名称:".$this->workData[$i]['name']);
			$message->line("      截止时间:".$this->workData[$i]['endTime']);
			$message->line("      负责人:".$this->workData[$i]['manager']);
		}
		$message->line("  请按照规定时间完成相关工作,如已完成请上报负责人,谢谢。");
        return $message;
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
