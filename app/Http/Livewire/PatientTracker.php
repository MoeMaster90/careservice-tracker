<?php

namespace App\Http\Livewire;

use App\Jobs\StoreShiftJob;
use Livewire\Component;

class PatientTracker extends Component
{
    public bool $atPatient = false;

    public int $currentStageStart = 0;

    public string $lastPatientName = "";

    public bool $onBreak = false;

    public string $extraNotes = "";

    public string $patientName = "";

    public array $selectedTreatments = [];

    public bool $shiftStarted = false;

    public array $stages = [];

    protected $listeners = [
        'selectedTreatmentsUpdated',
    ];

    public function mount()
    {

    }

    public function render()
    {
        return view('livewire.patient-tracker');
    }

    public function startShiftAtPatient()
    {
        $this->startShift();

        $this->atPatient = true;
    }

    public function startShiftAtOffice()
    {
        $this->startShift();
    }

    public function endShift()
    {
        StoreShiftJob::dispatchSync($this->stages);
        $this->shiftStarted = false;
    }

    public function startTreatment()
    {
        $this->atPatient = true;

        $currentTime = time();

        $this->addDrivingStage(0, $currentTime);

        $this->currentStageStart = $currentTime;
    }

    public function startBreak()
    {
        $this->onBreak = true;

        $this->currentStageStart = time();
    }

    public function endBreak()
    {
        $this->onBreak = false;

        $this->addBreakStage(0, time());
    }

    public function endTreatment()
    {
        $currentTime = time();

        $this->addTreatmentStage(0, $currentTime);

        $this->atPatient = false;
        $this->lastPatientName = $this->patientName;
        $this->patientName = "";

        $this->extraNotes = "";
        $this->selectedTreatments = [];
    }

    private function startShift()
    {
        $this->shiftStarted = true;

        $this->currentStageStart = time();
    }

    private function addDrivingStage($start = 0, $end = 0)
    {
        $this->addStage('driving', $start, $end);
    }

    private function addTreatmentStage($start = 0, $end = 0)
    {
        $this->addStage('treatment', $start, $end);
    }

    private function addBreakStage($start = 0, $end = 0)
    {
        $this->addStage('break', $start, $end);
    }

    private function addStage($type, $start = 0, $end = 0)
    {
        $start = !empty($start) ? $start : $this->currentStageStart;
        $end = !empty($end) ? $end : time();

        $stageData = [
            'type' => $type,
            'start' => date('H:i', $start),
            'end' => date('H:i', $end),
            'start_date_time' => date('Y-m-d H:i:s', $start),
            'end_date_time' => date('Y-m-d H:i:s', $end),
        ];

        switch ($type) {
            case 'treatment':
                $stageData['patient_name'] = $this->patientName;
                $stageData['extra_notes'] = $this->extraNotes;
                $stageData['treatments'] = $this->selectedTreatments;
                break;
            case 'break':

                break;
            default:
            case 'driving':
                $stageData['start_location'] = !empty($this->lastPatientName) ? $this->lastPatientName : 'Office';
                break;
        }

        $this->stages[] = $stageData;
    }

    public function selectedTreatmentsUpdated($updatedTreatments)
    {
        $this->selectedTreatments = $updatedTreatments;
    }
}
