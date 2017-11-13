<?php

namespace App\Notifications;

use App\Act;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ActMail extends Notification
{
    use Queueable;

	protected $act;
	protected $time;
	protected $weekDay;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Act $act)
    {
        //
		$weekArray = ['周日','周一','周二','周三','周四','周五','周六'];
		$this->act = $act;
		$this->time = explode('T',$act->time);
		$this->weekDay = $weekArray[date('w',strtotime($this->time[0]))];
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
                    ->line(env('group_name').'成员:')
					->line('  你好,这里是'.env('group_name').',现有如下一项活动/会议安排需要你的参加出席。')
                    ->line("	主题:{$this->act->name}")
					->line("	时间:{$this->time[0]}({$this->weekDay}) {$this->time[1]}")
					->line("	地点:{$this->act->address}")
					->line("	内容:{$this->act->desc}")
					->line("  届时会进行签到,请按时到场参加,谢谢!");
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
