<div class="space-y-6">
    
    <div>
        <x-input-label for="type" :value="__('Type')"/>
        <x-text-input wire:model="form.type" id="type" name="type" type="text" class="mt-1 block w-full" autocomplete="type" placeholder="Type"/>
        @error('form.type')
            <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
        <x-input-label for="title" :value="__('Title')"/>
        <x-text-input wire:model="form.title" id="title" name="title" type="text" class="mt-1 block w-full" autocomplete="title" placeholder="Title"/>
        @error('form.title')
            <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
        <x-input-label for="desc" :value="__('Desc')"/>
        <x-text-input wire:model="form.desc" id="desc" name="desc" type="text" class="mt-1 block w-full" autocomplete="desc" placeholder="Desc"/>
        @error('form.desc')
            <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
        <x-input-label for="user_id" :value="__('User Id')"/>
        <x-text-input wire:model="form.user_id" id="user_id" name="user_id" type="text" class="mt-1 block w-full" autocomplete="user_id" placeholder="User Id"/>
        @error('form.user_id')
            <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>

    <div class="flex items-center gap-4">
        <x-primary-button>Submit</x-primary-button>
    </div>
</div>