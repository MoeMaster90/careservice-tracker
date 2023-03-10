<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class StoreDrivingStageJob extends StoreStageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected string $type = 'driving';

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->storeStage([
            'patient_id' => !empty($this->stage['patient_name']) ? StorePatientJob::dispatchSync($this->stage['patient_name'])->id : null,
        ]);
    }
}
