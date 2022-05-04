<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use App\Services\PDFService;

class ProcessPdf implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;
    private $order_id;
    private $user_id;
    private $template_id;
    private $document_id_rewrite;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($order_id, $user_id, $template_id, $document_id_rewrite = null)
    {
        $this->order_id = $order_id;
        $this->user_id = $user_id;
        $this->template_id = $template_id;
        $this->document_id_rewrite = $document_id_rewrite;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        PDFService::storeDocumentToFile($this->order_id, $this->template_id, $this->user_id, $this->document_id_rewrite);
    }
}
