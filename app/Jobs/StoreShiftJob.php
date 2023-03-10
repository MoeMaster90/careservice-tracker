<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class StoreShiftJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private array $stages;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $stages)
    {
        $this->stages = $stages;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->stages as $stage) {
            switch ($stage['type']) {
                case 'break':
                    StoreBreakStageJob::dispatchSync($stage);
                    break;
                case 'treatment':
                    StoreTreatmentStageJob::dispatchSync($stage);
                    break;
                case 'driving':
                default:
                    StoreDrivingStageJob::dispatchSync($stage);
                    break;
            }
        }
    }
}
