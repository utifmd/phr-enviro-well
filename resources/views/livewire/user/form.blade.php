<div class="space-y-6">
    
    <div>
        <x-input-label for="username" :value="__('Username')"/>
        <x-text-input wire:model="form.username" id="username" name="username" type="text" class="mt-1 block w-full" autocomplete="username" placeholder="Username"/>
        @error('form.username')
            <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
        <x-input-label for="email" :value="__('Email')"/>
        <x-text-input wire:model="form.email" id="email" name="email" type="text" class="mt-1 block w-full" autocomplete="email" placeholder="Email"/>
        @error('form.email')
            <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>

    <div class="flex items-center gap-4">
        <x-primary-button>Submit</x-primary-button>
    </div>
</div>