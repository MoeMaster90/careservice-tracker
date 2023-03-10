<div x-data="{
        selected_treatments: $persist(@entangle('selectedTreatments')),
    }">
    <ul class="font-medium text-gray-900 bg-white border-t border-l border-r border-gray-200 ">

        @foreach($treatments as $key => $treatment)
            <li class="w-full border-b border-gray-200 rounded-t-lg">
                <div class="flex items-center pl-3">
                    <input id="bordered-checkbox-{{ $key }}" type="checkbox" value="{{ $treatment['name'] }}" name="bordered-checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500" wire:model="selectedTreatments" x-model="selected_treatments">
                    <label for="bordered-checkbox-{{ $key }}" class="w-full py-4 ml-2 text-sm font-medium">{{ $treatment['name'] }}</label>
                </div>
            </li>
        @endforeach
    </ul>
    <div class="w-full flex">
        <div class="flex-1">
            <input type="text" id="name" class="h-full bg-white border-gray-200 rounded-bl-md w-full px-3 py-2 h-10" placeholder="Treatment Name" wire:model="newTreatmentName"/>
        </div>
        <div class="flex-none w-16 ">
            <button class="h-full bg-green-600 text-white rounded-br-md px-3 py-2 w-full mb-4" wire:click="addNewTreatment"><i class="fa-solid fa-plus"></i></button>
        </div>
    </div>
</div>
