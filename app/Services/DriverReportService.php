<?php

namespace App\Services;

use Carbon\Carbon;

use App\Models\Analytics\DriverReport;

class DriverReportService {

	private $date_start_report;
	private $date_end_report;
	private $date_now;

	public function __construct() {
		$this->date_now = Carbon::now();
		$this->date_start_report = Carbon::createFromDate(null, null, $this->getReportStartPeriodConfig())->startOfDay();

		$period = $this->getReportPeriodConfig();

		if($this->date_now->lessThan($this->date_start_report)){
			$this->date_start_report->subMonth();

		}

		$this->date_end_report = (clone $this->date_start_report);

		if($period === 'month'){
			$this->date_end_report->addMonth()->endOfDay();
		}
	}

	public function checkreport($driver, $transport){

		$date_now = Carbon::now();

		$report = DriverReport::where('start', '<' , $date_now)->where('end', '>', $date_now)->where('transport_id', $transport->id)->first();

		if(!$report){

			$report = DriverReport::create([
				'company_id'    => $driver->company->id,
				'driver_id'     => $driver->id,
				'transport_id'  => $transport->id,
				'start'         => $this->date_start_report,
				'end'           => $this->date_end_report
			]);
		}

		return $report;
	}

	public function checkReportIsConfirm($transport){
		$date_now = Carbon::now();
		$report = DriverReport::where('start', '<' , $date_now)->where('end', '>', $date_now)->where('transport_id', $transport->id)->first();

		if(!$report || $report->status == 0){
			return false;
		}

		return true;
	}

	public function getReportPeriodStart(){
		return $this->date_start_report;
	}

	public function getReportPeriodEnd(){
		return $this->date_end_report;
	}

	public function getReportStartPeriodConfig(){
		return config('innlogist.driver_report_start_period');
	}

	public function getReportPeriodConfig(){
		return config('innlogist.driver_report_period');
	}

}