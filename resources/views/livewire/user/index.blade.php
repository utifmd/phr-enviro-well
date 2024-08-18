<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Users') }}
    </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-full mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="w-full">
                <div class="sm:flex space-y-2 md:space-y-0">
                    <div class="sm:flex-auto">
                        <h1 class="text-base font-semibold leading-6 text-gray-900">{{ __('Loading Unloading Report') }}</h1>
                        <p class="mt-2 text-sm text-gray-700">Vacuum Truck Report View</p>
                    </div>
                    <!-- Settings Dropdown -->
                    <div class="min-w-md">
                        <x-input-label for="roles" :value="__('Roles')"/>
                        <div class="relative">
                            <select
                                wire:model="role"
                                wire:change="onRoleChange"
                                class="block w-full px-4 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 hover:opacity-50"
                                name="roles" id="roles" required>
                                <option value="">-- Please choose --</option>
                                @foreach(\App\Utils\Enums\UserRoleEnum::cases() as $case)
                                    <option value="{{ $case->value }}">{{ $case->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('role')
                        <x-input-error class="mt-2" :messages="$message"/>
                        @enderror
                    </div>
                    <div class="min-w-md md:mx-2">
                        <x-input-label for="options" :value="__('Options')"/>
                        <x-dropdown id="options" align="right" width="48">
                            <x-slot name="trigger">
                                <button
                                    class="px-2.5 bg-gray-50 text-gray-900 border border-gray-300 shadow-sm rounded focus:outline-none hover:opacity-50">
                                    <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                         width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-width="4"
                                              d="M6 12h.01m6 0h.01m5.99 0h.01"/>
                                    </svg>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link :href="route('users.create')" class="text-green-600 cursor-pointer">
                                    {{ __('Add New User') }}
                                </x-dropdown-link>
                            </x-slot>
                        </x-dropdown>
                    </div>
                </div>

                <div class="flow-root">
                    <div class="mt-8 overflow-x-auto">
                        <div class="inline-block min-w-full py-2 align-middle">
                            <table class="w-full divide-y divide-gray-300">
                                <thead>
                                <tr>
                                    <th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">No</th>

									<th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Username</th>
									<th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Email</th>

                                    <th scope="col" class="px-3 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500"></th>
                                </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 bg-white">
                                @foreach ($users as $user)
                                    <tr class="even:bg-gray-50" wire:key="{{ $user->id }}">
                                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-semibold text-gray-900">{{ ++$i }}</td>

										<td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $user->username }}</td>
										<td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $user->email }}</td>

                                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900">
                                            <a wire:navigate href="{{ route('users.show', $user->id) }}" class="text-gray-600 font-bold hover:text-gray-900 mr-2">{{ __('Show') }}</a>
                                            <a wire:navigate href="{{ route('users.edit', $user->id) }}" class="text-indigo-600 font-bold hover:text-indigo-900  mr-2">{{ __('Edit') }}</a>
                                            <button
                                                class="text-red-600 font-bold hover:text-red-900"
                                                type="button"
                                                wire:click="delete('{{ $user->id }}')"
                                                wire:confirm="Are you sure you want to delete?">
                                                {{ __('Delete') }}
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4 px-4">
                            {!! $users->withQueryString()->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
