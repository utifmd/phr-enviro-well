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
        @if($form->role == \App\Utils\Enums\UserRoleEnum::USER_DEV_ROLE->value)
            <x-text-input wire:model="form.role" id="role" name="role" type="text" class="mt-1 block w-full opacity-50" autocomplete="role" placeholder="Role" disabled/>
        @else
            <select name="role" id="role" wire:model="form.role" name="role" class="mt-1 block w-full">
                <option value="">--- Choose a role ---</option>
                @foreach(\App\Utils\Enums\UserRoleEnum::cases() as $case)
                    @if($case->value == \App\Utils\Enums\UserRoleEnum::USER_DEV_ROLE->value) @continue @endif
                    <option value="{{$case->value}}" selected="{{$case == $form->role}}">{{$case->name}}</option>
                @endforeach
            </select>
        @endif
        @error('form.role')
        <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    @if($form->isUpdating)
    <div>
        <x-input-label for="isNewPassword" :value="__('Reset Password')"/>
        <input type="checkbox" wire:change="toggleIsNewPassword" name="isNewPassword" id="isNewPassword"/>
    </div>
    @endif
    @if($form->isNewPassword)
    <div>
        <x-input-label for="password" value="{{$form->isUpdating ? 'Password' : 'New Password'}}"/>
        <x-text-input wire:model="form.password" id="password" name="password" type="password" class="mt-1 block w-full" autocomplete="password" placeholder="Enter new password"/>
    </div>
    @endif
    <div>
        @error('form.password')
        <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div class="flex items-center gap-4">
        <x-primary-button wire:loading.attr="disabled" class="disabled:pointer-events-none">
            <div wire:loading role="status">
                <svg aria-hidden="true"
                     class="w-4 h-4 me-2.5 text-gray-200 animate-spin dark:text-gray-600 fill-blue-200"
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
            Submit
        </x-primary-button>
    </div>
</div>
