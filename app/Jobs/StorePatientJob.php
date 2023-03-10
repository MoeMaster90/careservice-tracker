<?php

namespace App\Jobs;

use App\Models\Patient;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class StorePatientJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, SerializesModels;

    private string $patientName;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $patientName)
    {
        $this->patientName = $patientName;
    }

    /**
     * Execute the job.
     *
     * @return Patient $patient
     */
    public function handle(): Patient
    {
        return Patient::firstOrCreate([
            'name'=>$this->patientName,
        ]);
    }
}
