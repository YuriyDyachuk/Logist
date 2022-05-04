<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;

use App\Services\MobileIdService;
use Carbon\Carbon;


use Exception;

class ProcessSignatureStatus implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

	public $signature_id;
	public $time;
	public $attempt;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($signature_id, $attempt = 1)
    {
    	$this->signature_id = $signature_id;
    	$this->time = Carbon::now();
    	$this->attempt = $attempt;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

	    innlogger_sign('checkStatus Job:');
	    innlogger_sign($this->signature_id);
	    innlogger_sign($this->attempt);

	    (new MobileIdService)->checkStatus($this->signature_id, $this->attempt, $this->time);
    }
}
