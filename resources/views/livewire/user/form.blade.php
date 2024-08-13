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
    <div>
        <x-input-label for="role" :value="__('Role')"/>
        <select name="role" id="role" wire:model="form.role" name="role" class="mt-1 block w-full">
            <option value="">--- Choose a role ---</option>
            @foreach(\App\Utils\Enums\UserRoleEnum::cases() as $case)
                @if($case->value == \App\Utils\Enums\UserRoleEnum::USER_DEV_ROLE->value) @continue @endif
                <option value="{{$case->value}}" selected="{{$case == $form->role}}">{{$case->name}}</option>
            @endforeach
        </select>
        @error('form.role')
        <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    @if(!request()->routeIs('users.create'))
    <div>
        <x-input-label for="isNewPassword" :value="__('Reset Password')"/>
        <input type="checkbox" wire:change="toggleIsNewPassword" name="isNewPassword" id="isNewPassword"/>
    </div>
    @endif
    @if($form->isNewPassword || request()->routeIs('users.create'))
    <div>
        <x-input-label for="password" value="{{request()->routeIs('users.create') ? 'Password' : 'New Password'}}"/>
        <x-text-input wire:model="form.password" id="password" name="password" type="password" class="mt-1 block w-full" autocomplete="password" placeholder="Enter new password"/>
    </div>
    @endif
    <div>
        @error('form.password')
        <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div class="flex items-center gap-4">
        <x-primary-button wire:loading.attr="disabled">Submit</x-primary-button>
    </div>
</div>
