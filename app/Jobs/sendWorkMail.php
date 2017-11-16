<?php

namespace App\Jobs;

use App\Notifications\WorkMail;
use App\work;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class sendWorkMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

	protected $work;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(work $work)
    {
        //
		$this->work = $work;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
		foreach ($this->work->users as $eachUser){
			$eachUser->notify(new WorkMail($this->work));
		}
    }
}
