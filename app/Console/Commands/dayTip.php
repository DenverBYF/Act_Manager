<?php

namespace App\Console\Commands;

use App\Jobs\sendTipMail;
use App\Notifications\tipMail;
use App\User;
use App\work;
use Illuminate\Console\Command;

class dayTip extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tip:day {type}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
		$type = intval($this->argument('type'));
		$works = work::where('status', 0)->where('tip', $type)->get();		//找出需要通知的未完成工作
		$data = array();
		foreach ($works as $work) {
			$startTime = strtotime(explode('T', $work->start_time)[0]);
			if($startTime <= strtotime("next Monday")){					//判断工作是否已经开始
				$time = str_replace('T', ' ', $work->end_time);
				foreach ($work->users as $user){
					$data[$user->id][] = [
						'name' => $work->name,
						'endTime' => $time,
						'manager' => $work->manager->name
					];
				}
			}
		}
		foreach ($data as $eachUser => $userWork){
			$user = User::find($eachUser);
			$user->notify(new tipMail($userWork));						//发送通知邮件
		}
    }
}
