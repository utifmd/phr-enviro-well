<div>
    <form wire:submit="register">

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input wire:model="form.email" id="email" class="block mt-1 w-full" type="email" name="email" required autocomplete="email" />
            <x-input-error :messages="$errors->get('form.email')" class="mt-2" />
            <x-input-error :messages="$errors->get('form.username')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input
                wire:model="form.password" id="password" class="block mt-1 w-full"
                type="password"
                name="password"
                required
                autocomplete="new-password" />

            <x-input-error :messages="$errors->get('form.password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input
                wire:model="form.password_confirmation" id="password_confirmation" class="block mt-1 w-full"
                type="password"
                name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('form.password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}" wire:navigate>
                {{ __('Already registered?') }}
            </a>

            <x-primary-button wire:loading.class="disabled opacity-50" wire:loading.attr="disabled" class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</div>
