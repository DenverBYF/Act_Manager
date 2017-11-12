<?php

namespace App\Jobs;

use App\Act;
use App\Notifications\ActMail;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class sendActMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

	protected $act;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Act $act)
    {
        //
		$this->act = $act;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
		foreach ($this->act->users as $eachUser){
			$eachUser->notify(new ActMail($this->act));			//向活动的用户列表内所有用户发送通知邮件
		}
    }
}
