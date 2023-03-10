<?php

namespace App\Jobs;

use App\Models\Stage;
use App\Models\StageType;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

/**
 *
 */
class StoreStageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, SerializesModels;

    /**
     * @var array
     */
    protected array $stage;

    /**
     * @var string
     */
    protected string $type = 'driving';

    /**
     * @var StageType
     */
    protected StageType $stageType;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $stage)
    {
        $this->stage = $stage;

        $this->stageType = StageType::firstOrCreate([
            'name' => $this->type,
        ]);
    }

    /**
     * @param array $data
     * @return Stage
     */
    protected function storeStage(array $data = []): Stage
    {
        $stageData = array_merge($data, [
            'stage_type_id' => $this->stageType->id,
            'start' => $this->stage['start_date_time'],
            'end' => $this->stage['end_date_time'],
        ]);

        return Stage::create($stageData);
    }
}
