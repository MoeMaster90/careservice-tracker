<?php

namespace App\Http\Livewire;

use App\Models\Treatment;
use Livewire\Component;

class TreatmentList extends Component
{

    public array $selectedTreatments = [];

    public string $newTreatmentName = '';

    public function render()
    {
        return view('livewire.treatment-list', [
            'treatments' => Treatment::all()->toArray(),
        ]);
    }

    public function addNewTreatment()
    {
        $treatment = Treatment::firstOrCreate([
            'name' => trim($this->newTreatmentName),
        ]);

        $this->selectedTreatments[] = $treatment->name;

        $this->newTreatmentName = '';
    }

    public function updatedSelectedTreatments()
    {
        $this->emitUp('selectedTreatmentsUpdated', $this->selectedTreatments);
    }
}
