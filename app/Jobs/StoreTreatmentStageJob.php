<?php

namespace App\Jobs;

use App\Models\Stage;
use App\Models\Treatment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Arr;

class StoreTreatmentStageJob extends StoreStageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected string $type = 'treatment';

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $stage = $this->storeStage([
            'patient_id' => StorePatientJob::dispatchSync($this->stage['patient_name'])->id,
            'extra_notes' => $this->stage['extra_notes'] ?? null,
        ]);

        $treatments = Treatment::whereIn('name',$this->stage['treatments']);

        $stage->treatments()->sync($treatments->pluck('id'));
    }
}
