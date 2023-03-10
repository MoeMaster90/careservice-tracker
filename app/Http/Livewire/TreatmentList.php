<?php

namespace App\Http\Livewire;

use App\Models\Treatment;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

/**
 *
 */
class TreatmentList extends Component
{

    /**
     * @var array
     */
    public array $selectedTreatments = [];

    /**
     * @var string
     */
    public string $newTreatmentName = '';

    /**
     * @var string[]
     */
    protected $listeners = [
        'updatedSelectedTreatments',
    ];

    /**
     * @param array $selectedTreatments
     */
    public function mount(array $selectedTreatments)
    {
        $this->selectedTreatments = $selectedTreatments;
    }

    /**
     * @return Application|Factory|View
     */
    public function render(): View|Factory|Application
    {
        return view('livewire.treatment-list', [
            'treatments' => Treatment::all()->toArray(),
        ]);
    }

    /**
     * @noinspection PhpUnused
     */
    public function addNewTreatment()
    {
        $treatment = Treatment::firstOrCreate([
            'name' => trim($this->newTreatmentName),
        ]);

        $this->selectedTreatments[] = $treatment->name;

        $this->newTreatmentName = '';

        $this->updatedSelectedTreatments();
    }

    /**
     *
     */
    public function updatedSelectedTreatments()
    {
        $this->emitUp('selectedTreatmentsUpdated', $this->selectedTreatments);
    }
}
