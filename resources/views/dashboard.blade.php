<div class="py-12">
    <div class="max-w-full mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            @can(\App\Policies\UserPolicy::IS_PHR_ROLE)
                <div class="w-full">
                    <div class="sm:flex space-y-2 md:space-y-0">
                        <div class="sm:flex-auto">
                            <h1 class="text-base font-semibold leading-6 text-gray-900">{{ __('Loading Unloading Report') }}</h1>
                            <p class="mt-2 text-sm text-gray-700">Vacuum Truck Report View</p>
                        </div>
                        <!-- Settings Dropdown -->
                        <form wire:submit="apply" role="form" method="post" class="min-w-md">
                            <x-input-label for="selectedYearMonth" :value="__('Historical Report')"/>
                            <div class="relative">
                                <x-text-input
                                    wire:model="selectedYearMonth" id="selectedYearMonth"
                                    wire:keydown.enter="apply" name="selectedYearMonth" type="month"
                                    min="2018-12" max="{{date('Y')}}-{{date('m')}}"
                                    autocomplete="selectedYearMonth" placeholder="Select to filter"
                                    class="block w-full px-4 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 hover:opacity-50"
                                    required/>
                            </div>
                            @error('selectedYearMonth')
                            <x-input-error class="mt-2" :messages="$message"/>
                            @enderror
                        </form>
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
                                    <x-dropdown-link href="{{ route('dashboard.export', $selectedYearMonth) }}" class="text-green-600 cursor-pointer">
                                        {{ __('Export To Excel') }}
                                    </x-dropdown-link>
                                </x-slot>
                            </x-dropdown>
                        </div>
                    </div>

                    <div class="flow-root">
                        <div class="mt-8 overflow-x-auto">
                            <div class="inline-block min-w-full py-2 align-middle">
                                @include('components.table-dashboard')
                                <div class="mt-4 px-4">
                                    {{--{!! $users->withQueryString()->links() !!}--}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="w-full">
                    <div class="sm:flex sm:items-center">
                        <div class="sm:flex-auto">
                            <h1 class="text-base font-semibold leading-6 text-gray-900">{{ __('Hi, ').(auth()->user()->username ?? 'NA') }}</h1>
                            <p class="mt-2 text-sm text-gray-700">Welcome to O&M Environment Facilities Operations Well
                                Management</p>
                            @cannot(\App\Policies\UserPolicy::IS_NOT_GUEST_ROLE)
                                <p class="mt-2 text-sm text-red-600 font-bold">Please contact developer to access the
                                    {{env('APP_NAME')}} app.</p>
                            @endcannot
                        </div>
                    </div>
                </div>
            @endcan
        </div>
    </div>
</div>
