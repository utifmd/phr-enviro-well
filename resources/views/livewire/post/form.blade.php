<div class="space-y-6">
    <div>
        <x-input-label for="title" :value="__('Well Number')"/>
        <x-text-input wire:model="form.title" disabled id="title" name="title" type="text" class="mt-1 block w-full text-gray-500" autocomplete="title" placeholder="Well number"/>
        @error('form.title')
            <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
        <x-input-label for="desc" :value="__('Related Name')"/>
        <x-text-input wire:model="form.desc" disabled id="desc" name="desc" type="text" class="mt-1 block w-full text-gray-500" autocomplete="desc" placeholder="Related Name"/>
        @error('form.desc')
            <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div class="flex space-x-9">
        <div>
            <x-input-label for="shift" :value="__('Shift')"/>
            <div id="shift" class="flex flex-wrap ms-2 space-x-6">
                <div class="flex items-center">
                    <input id="red-radio" type="radio" {{$form->shift == \App\Utils\Enums\WorkOrderShiftEnum::DAY->value ? 'checked' : ''}} value="{{\App\Utils\Enums\WorkOrderShiftEnum::DAY->value}}" name="shift-radio" class="w-4 h-4 text-yellow-400 bg-gray-100 border-gray-300 focus:ring-yellow-500 dark:focus:ring-yellow-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    <label for="red-radio" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Day</label>
                </div>
                <div class="flex items-center">
                    <input id="green-radio" type="radio" {{$form->shift == \App\Utils\Enums\WorkOrderShiftEnum::NIGHT->value ? 'checked' : ''}} value="{{\App\Utils\Enums\WorkOrderShiftEnum::NIGHT->value}}" name="shift-radio" class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 focus:ring-green-500 dark:focus:ring-green-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    <label for="green-radio" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Night</label>
                </div>
            </div>
            @error('form.shift')
                <x-input-error class="mt-2" :messages="$message"/>
            @enderror
        </div>
        <div>
            <x-input-label for="is_rig" :value="__('Rig or Non Rig')"/>
            <div id="shift" class="flex flex-wrap ms-2 space-x-6">
                <div class="flex items-center">
                    <input id="red-radio" type="radio" {{$form->is_rig ? 'checked' : ''}} value="true" name="rig-radio" class="w-4 h-4 text-red-600 bg-gray-100 border-gray-300 focus:ring-red-500 dark:focus:ring-red-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    <label for="red-radio" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Rig</label>
                </div>
                <div class="flex items-center">
                    <input id="green-radio" type="radio" {{!$form->is_rig ? 'checked' : ''}} value="false" name="rig-radio" class="w-4 h-4 text-orange-500 bg-gray-100 border-gray-300 focus:ring-orange-500 dark:focus:ring-orange-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    <label for="green-radio" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Non Rig</label>
                </div>
            </div>
            @error('form.is_rig')
                <x-input-error class="mt-2" :messages="$message"/>
            @enderror
        </div>
    </div>
    <div class="flex">
        <div>
            <x-input-label for="m_datetime" :value="__('Load at')"/>
            <div id="m_datetime" class="flex">
                <x-text-input wire:model="form.datetime" id="datetime" name="datetime" type="datetime-local" class="mt-1 me-2 block w-full" autocomplete="datetime" placeholder="Loaded datetime"/>

                <button type="button"  wire:click="onAddLoadTimePressed" class="whitespace-nowrap px-3 py-2 text-xs font-medium text-center inline-flex items-center rounded-full text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    <svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 21a9 9 0 1 1 0-18c1.052 0 2.062.18 3 .512M7 9.577l3.923 3.923 8.5-8.5M17 14v6m-3-3h6"/>
                    </svg>
                    {{ count($form->loaded_datetime) }} Load{{count($form->loaded_datetime) > 1 ? '\'s' : ''}}
                </button>
            </div>
            @error('form.loaded_datetime')
                <x-input-error class="mt-2" :messages="$message"/>
            @enderror
        </div>
    </div>
    <div>
        @error('form.datetime')
        <x-input-error class="mt-2" :messages="$message"/>
        @enderror
        @error('form.user_id')
        <x-input-error class="mt-2" :messages="$message"/>
        @enderror
        @error('form.type')
        <x-input-error class="mt-2" :messages="$message"/>
        @enderror
        @error('form.well_master_id')
        <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
        @foreach($form->loaded_datetime as $i => $loadTime)
            <span id="badge-dismiss-default" class="inline-flex items-center px-2 py-1 me-2 mb-3 text-sm font-medium text-blue-800 bg-blue-100 rounded dark:bg-blue-900 dark:text-blue-300">
                {{ str_replace('T', ' ', $loadTime) }}
                <button type="button" wire:click="onRemoveLoadTimePressed({{$i}})" class="inline-flex items-center p-1 ms-2 text-sm text-blue-400 bg-transparent rounded-sm hover:bg-blue-200 hover:text-blue-900 dark:hover:bg-blue-800 dark:hover:text-blue-300" data-dismiss-target="#badge-dismiss-default" aria-label="Remove">
                    <svg class="w-2 h-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Remove badge</span>
                </button>
            </span>
        @endforeach
    </div>
    <div class="flex items-center gap-4">
        <x-primary-button>Send</x-primary-button>
    </div>
</div>
