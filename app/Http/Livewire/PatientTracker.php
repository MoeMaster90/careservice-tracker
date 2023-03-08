<?php

namespace App\Http\Livewire;

use Livewire\Component;

class PatientTracker extends Component
{
    public bool $atPatient = false;

    public int $currentStageStart = 0;

    public string $lastPatientName = "";

    public bool $onBreak = false;

    public string $patientExtraInfo = "";

    public string $patientName = "";

    public bool $shiftStarted = false;

    public array $stages = [];

    public function mount()
    {

    }

    public function render()
    {
        return view('livewire.patient-tracker', [
            'treatments' => [
                'Strümpfe anziehen',
                'Verband wechseln',
                'Tabletten stellen',
                'Duschbad',
            ]
        ]);
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

        $this->patientExtraInfo = "";
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
        $stageData = [
            'type' => $type,
            'start' => date('H:i', !empty($start) ? $start : $this->currentStageStart),
            'end' => date('H:i', !empty($end) ? $end : time()),
        ];

        switch ($type) {
            case 'treatment':
                $stageData['patient_name'] = $this->patientName;
                $stageData['patient_extra_info'] = $this->patientExtraInfo;
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
}
