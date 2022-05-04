<?php

namespace App\Jobs\Driver;

use Doctrine\DBAL\Driver;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use App\Services\GcmService;
use App\Services\DriverReportService;
use App\Models\Transport\Transport;

class ProcessReportNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $transport_id;
    private $transport;
    private $driver;

	public $tries = 5;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($transport_id)
    {
        $this->transport_id = $transport_id;
        $this->transport = Transport::find($this->transport_id);
        $this->driver = $this->transport->drivers->first();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

	    $driver_report_service = new DriverReportService();

    	if($driver_report_service->checkReportIsConfirm($this->transport) === false){
    		$msg = GcmService::buildMessage('report', null, 'sendreport');
    		GcmService::sendNotification($this->driver->id, $msg);
	    }
    }
}
