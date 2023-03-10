<div class="p-2" x-data="{
        on_shift: $persist(@entangle('shiftStarted')),
        on_break: $persist(@entangle('onBreak')),
        at_patient: $persist(@entangle('atPatient')),
        current_stage_start: $persist(@entangle('currentStageStart')),
        patient_name: $persist(@entangle('patientName').defer),
        extra_notes: $persist(@entangle('extraNotes').defer),
        stages: $persist(@entangle('stages').defer),
        selected_treatments: $persist(@entangle('selectedTreatments')),
        show: false
    }" x-init="setTimeout(() => show = true, 500)">


    @if($shiftStarted)

        @if($atPatient)
            <div x-show="show" x-transition>
                <div>
                    <input type="text" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Name" wire:model.defer="patientName" x-model="patient_name">
                </div>

                <div class="my-8">
                    <livewire:treatment-list :selectedTreatments="$selectedTreatments"/>
                </div>

                <div class="my-8">
                    <textarea type="text" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Extra Notes" wire:model.defer="extraNotes" x-model="extra_notes"></textarea>
                </div>

                <button class="bg-red-600 text-white px-4 py-2 rounded-xl w-full text-2xl" wire:click="endTreatment"><i class="fa-solid fa-circle-check"></i> {{ __('End Treatment') }}</button>
            </div>
        @else
            @if(!$onBreak)
                <div x-show="show" x-transition>
                    <button class="bg-green-600 text-white px-4 py-2 rounded-xl w-full text-2xl mb-4" wire:click="startTreatment"><i class="fa-solid fa-person-cane"></i> {{ __('At Patient') }}</button>

                    <button class="bg-blue-600 text-white px-4 py-2 rounded-xl w-full text-2xl mb-4" wire:click="startBreak"><i class="fa-solid fa-mug-saucer"></i> {{ __('Have a Break') }}</button>

                    <button class="bg-red-600 text-white px-4 py-2 rounded-xl w-full text-2xl mb-4" wire:click="endShift"><i class="fa-solid fa-flag-checkered"></i> {{ __('End Shift') }}</button>

                    @foreach($stages as $stage)
                        <div class="border-gray-300 border-2 p-2 my-2">
                            <div class="grid grid-cols-2 gap-4 md:grid-cols-2 lg:grid-cols-4">
                                @switch($stage['type'])
                                    @case('driving')
                                    <div class="border-gray-300">
                                        <i class="fa-solid fa-car-side"></i>
                                    </div>
                                    <div class="border-gray-300">
                                        <span class="font-bold mr-2">{{ __('Start Location') }}:</span><span>{{ $stage['start_location'] }}</span>
                                    </div>
                                    <div class="border-gray-300">
                                        <span class="font-bold mr-2">{{ __('Departure') }}:</span><span>{{ $stage['start'] }}</span>
                                    </div>
                                    <div>
                                        <span class="font-bold mr-2">{{ __('Arrival') }}:</span><span>{{ $stage['end'] }}</span>
                                    </div>
                                    @break
                                    @case('treatment')
                                    <div class="border-gray-300">
                                        <i class="fa-solid fa-person-cane"></i>
                                    </div>
                                    <div class="border-gray-300">
                                        <span class="font-bold mr-2">{{ __('Name') }}:</span><span>{{ $stage['patient_name'] }}</span>
                                    </div>
                                    <div class="border-gray-300">
                                        <span class="font-bold mr-2">{{ __('Start') }}:</span><span>{{ $stage['start'] }}</span>
                                    </div>
                                    <div class="border-gray-300">
                                        <span class="font-bold mr-2">{{ __('End') }}:</span><span>{{ $stage['end'] }}</span>
                                    </div>

                                    <div class="col-span-2 md:col-span-2 lg:col-span-4 grid grid-cols-1 md:grid-cols-2 gap-4 border-gray-300 border-dashed border-t-2 pt-2">
                                        <div class="">
                                            <span class="font-bold">{{ __('Treatments') }}:</span>
                                            <ul>
                                                @foreach($stage['treatments'] as $treatment)
                                                    <li>{{ $treatment }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        <div class="">
                                            <span class="font-bold">{{ __('Extra Info') }}:</span>
                                            <p>{{ $stage['patient_extra_info'] }}</p>
                                        </div>
                                    </div>
                                    @break
                                    @case('break')
                                    <div class="border-gray-300">
                                        <i class="fa-solid fa-mug-saucer"></i>
                                    </div>
                                    <div class="border-gray-300">
                                        <span class="font-bold mr-2">{{ __('Break') }}</span>
                                    </div>
                                    <div class="border-gray-300">
                                        <span class="font-bold mr-2">{{ __('Start') }}:</span><span>{{ $stage['start'] }}</span>
                                    </div>
                                    <div class="border-gray-300">
                                        <span class="font-bold mr-2">{{ __('End') }}:</span><span>{{ $stage['end'] }}</span>
                                    </div>
                                    @break
                                @endswitch
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div x-show="show" x-transition>
                    <button class="bg-red-600 text-white px-4 py-2 rounded-xl w-full text-2xl" wire:click="endBreak">{{ __('End Break') }}</button>
                </div>
            @endif

        @endif
    @else
        <div x-show="show" x-transition>
            <div class="flex flex-col space-y-2">
                <button class="bg-green-600 text-white px-4 py-2 rounded-xl w-full text-2xl mb-4" wire:click="startShiftAtOffice"><i class="fa-solid fa-building-circle-arrow-right"></i> {{ __('Start Shift At Office') }}</button>
                <button class="bg-blue-600 text-white px-4 py-2 rounded-xl w-full text-2xl mb-4" wire:click="startShiftAtPatient"><i class="fa-solid fa-person-cane"></i> {{ __('Start Shift At Patient') }}</button>
            </div>
        </div>
    @endif


    <x-livewire-loading-indicator/>
</div>
