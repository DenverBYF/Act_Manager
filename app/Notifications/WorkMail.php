<?php

namespace App\Notifications;

use App\work;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class WorkMail extends Notification
{
    use Queueable;

	protected $work, $startTime, $startWeekDay, $endTime, $endWeekDay;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(work $work)
    {
        //
		$this->work = $work;
		$weekArray = ['周日','周一','周二','周三','周四','周五','周六'];
		$this->startTime = explode('T',$work->start_time);
		$this->startWeekDay = $weekArray[date('w',strtotime($this->startTime[0]))];
		$this->endTime = explode('T',$work->end_time);
		$this->endWeekDay = $weekArray[date('w',strtotime($this->endTime[0]))];
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
    	$timeRange = "{$this->startTime[0]}({$this->startWeekDay}){$this->startTime[1]} 至 {$this->endTime[0]}({$this->endWeekDay}){$this->endTime[1]}";
    	if(!empty($this->work->file_url)){
    		$file = storage_path('/app/work/'.$this->work->file_url);
			return (new MailMessage)
						->subject('工作邮件')
						->line('党支部成员你好:')
						->line('   现有一项工作('.$this->work->name.')安排给你,具体说明如下:')
						->line('       工作负责人:'.$this->work->manager->name."  (邮箱{$this->work->manager->email})")
						->line('       工作内容:'.$this->work->content)
						->line('       时间范围:'.$timeRange)
						->line('   请按照要求在规定时间内完成相关工作并向工作负责人汇报,谢谢。')
						->attach($file);
		}else{
			return (new MailMessage)
				->subject('工作邮件')
				->line('党支部成员你好:')
				->line('   现有一项工作('.$this->work->name.')安排给你,具体说明如下:')
				->line('       工作负责人:'.$this->work->manager->name."  (邮箱{$this->work->manager->email})")
				->line('       工作内容:'.$this->work->content)
				->line('       时间范围:'.$timeRange)
				->line('   请按照要求在规定时间内完成相关工作并向工作负责人汇报,谢谢。');

		}
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
