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
        <p id="desc">
            @foreach(explode(';', $form->desc) as $relatedName)
                <span class="bg-blue-100 text-grey-800 text-xs font-semibold me-1.5 px-2.5 py-0.5 rounded border border-grey-400 inline-flex items-center justify-center">{{$relatedName}}</span>
            @endforeach
        </p> {{--<x-text-input wire:model="form.desc" disabled id="desc" name="desc" type="text" class="mt-1 block w-full text-gray-500" autocomplete="desc" placeholder="Related Name"/>--}}
        @error('form.desc')
            <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div class="flex space-x-9">
        <div>
            <x-input-label for="shift" :value="__('Shift')"/>
            <div id="shift" class="flex flex-wrap ms-2 space-x-6">
                <div class="flex items-center">
                    <input wire:model="form.shift" id="shift" name="shift" type="radio" {{$form->shift == \App\Utils\Enums\WorkOrderShiftEnum::DAY->value ? 'checked' : ''}} value="{{\App\Utils\Enums\WorkOrderShiftEnum::DAY->value}}" class="w-4 h-4 text-yellow-400 bg-gray-100 border-gray-300 focus:ring-yellow-500 dark:focus:ring-yellow-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    <label for="red-radio" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Day</label>
                </div>
                <div class="flex items-center">
                    <input wire:model="form.shift" id="shift" name="shift" type="radio" {{$form->shift == \App\Utils\Enums\WorkOrderShiftEnum::NIGHT->value ? 'checked' : ''}} value="{{\App\Utils\Enums\WorkOrderShiftEnum::NIGHT->value}}" class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 focus:ring-green-500 dark:focus:ring-green-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
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
                    <input wire:model="form.is_rig" id="is_rig" name="is_rig" type="radio" {{$form->is_rig ? 'checked' : ''}} value="1" class="w-4 h-4 text-red-600 bg-gray-100 border-gray-300 focus:ring-red-500 dark:focus:ring-red-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    <label for="red-radio" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Rig</label>
                </div>
                <div class="flex items-center">
                    <input wire:model="form.is_rig" id="is_rig" name="is_rig" type="radio" {{!$form->is_rig ? 'checked' : ''}} value="0" class="w-4 h-4 text-orange-500 bg-gray-100 border-gray-300 focus:ring-orange-500 dark:focus:ring-orange-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
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
                <x-text-input wire:model="form.datetime" wire:keydown.tab="onAddLoadTimePressed" min="2021-06-07T00:00:00" max="{{date('Y-m-d')}}T{{date('h:m:s')}}" id="datetime" name="datetime" type="datetime-local" class="mt-1 me-2 block w-full" autocomplete="datetime" placeholder="Loaded datetime"/>

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
    <div>
        <x-input-label for="evidence" :value="__('Evidence')"/>
        <div id="evidence" class="flex items-center justify-center w-full">
            <label for="imageFile" class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-gray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                <div wire:loading role="status">
                    <svg aria-hidden="true"
                         class="w-8 h-8 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600"
                         viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                            fill="currentColor"/>
                        <path
                            d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                            fill="currentFill"/>
                    </svg>
                    <span class="sr-only">Loading...</span>
                </div>
                @if(isset($imageFile))
                    <img src="{{$imageFile->temporaryUrl()}}" alt="Snapshot image" class="min-w-10 min-h-10">
                @elseif(count($form->postModel->uploadedUrls) > 0)
                    <img src="{{$form->postModel->uploadedUrls[0]['url']}}" alt="Snapshot image" class="min-w-10 min-h-10">
                @else
                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                        <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                        </svg>
                        <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span>{{-- or drag and drop--}}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPG or GIF (max 2MB)</p>
                    </div>
                @endif
                <input wire:model="imageFile" id="imageFile" name="imageFile" accept="image/*" type="file" class="mt-1 w-full hidden"/>
            </label>
        </div>
    </div>
    <div>
        @error('imageFile')
            <x-input-error class="mt-2" :messages="$message"/>
        @enderror
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
    <div class="flex items-center gap-4">
        <x-primary-button wire:loading.class="disabled opacity-50" >Submit</x-primary-button>
    </div>
</div>
