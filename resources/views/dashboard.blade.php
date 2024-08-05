<div class="py-12">
    <div class="max-w-full mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="w-full">
                <div class="sm:flex sm:items-center">
                    <div class="sm:flex-auto">
                        <h1 class="text-base font-semibold leading-6 text-gray-900">{{ __('Loading Unloading Report') }}</h1>
                        <p class="mt-2 text-sm text-gray-700">Vacuum Truck Report View</p>
                    </div>
                    <!-- Settings Dropdown -->
                    <form wire:submit="apply" role="form" method="post" class="min-w-md m-0">
                        <x-input-label for="selectedYearMonth" :value="__('Historical Report')"/>
                        <div class="relative">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-2">
                                <button type="submit" class="text-white font-medium rounded-lg text-sm p-2">
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                    </svg>
                                </button>
                            </div>
                            <x-text-input wire:model="selectedYearMonth" id="selectedYearMonth" wire:keydown.enter="apply" name="selectedYearMonth" type="month" min="2018-12" max="{{date('Y')}}-{{date('m')}}" autocomplete="selectedYearMonth" placeholder="Select to filter" class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required />
                        </div>
                        @error('selectedYearMonth')
                        <x-input-error class="mt-2" :messages="$message"/>
                        @enderror
                    </form>
                    <div class="hidden sm:flex sm:items-center sm:ms-6">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button
                                    class="inline-flex items-center rounded-md text-gray-500 focus:outline-none hover:text-gray-700 transition ease-in-out duration-150">
                                    <div class="ms-1">
                                        <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                             width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-width="4"
                                                  d="M6 12h.01m6 0h.01m5.99 0h.01"/>
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link class="text-green-600 cursor-pointer">
                                    {{ __('Export To Excel') }}
                                </x-dropdown-link>
                            </x-slot>
                        </x-dropdown>
                    </div>
                </div>

                <div class="flow-root">
                    <div class="mt-8 overflow-x-auto">
                        <div class="inline-block min-w-full py-2 align-middle">
                            <table class="w-full divide-y divide-gray-300 border">
                                <thead>
                                <tr>
                                    <th scope="col" rowspan="2" class="py-4 pl-4 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">No</th>
                                    <th scope="col" rowspan="2" class="py-4 px-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Well Number</th>
                                    <th scope="col" colspan="{{ count($loads['days']) }}" class="py-4 pl-4 text-center border text-xs font-semibold uppercase tracking-wide text-gray-500">
                                        #Load VT in {{$selectedMonthName.' '.$selectedYear}}
                                    </th>
                                    <th scope="col" rowspan="2" class="py-4 px-3 text-center text-xs font-semibold uppercase tracking-wide text-gray-500">AFE Number</th>
                                    <th scope="col" rowspan="2" class="px-3 py-y text-center text-xs font-semibold uppercase tracking-wide text-gray-500">Total Load</th>
                                </tr>
                                <tr>
                                    @foreach($loads['days'] as $day)
                                        <th scope="col" class="py-4 text-xs text-center border font-semibold uppercase tracking-wide text-gray-500">{{ $day }}</th>
                                    @endforeach
                                </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 bg-white">
                                @foreach($loads['data'] as $load)
                                    <tr class="even:bg-gray-50" wire:key="{{ $load['wbs_number'] }}">
                                        <td class="whitespace-nowrap pl-4 py-4 text-sm font-semibold text-gray-900">{{ $load['num'].'. ' }}</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                            <a href="{{ route('posts.load-request',  $load['ids_wellname']) }}">
                                                {{ $load['well_number'] }}
                                            </a>
                                        </td>
                                        @foreach($load['days'] as $day => $v)
                                            <td class="whitespace-nowrap py-4 text-center border text-xs text-gray-500">{{ $v }}</td>
                                        @endforeach
                                        <td class="whitespace-nowrap px-3 py-4 text-center text-sm text-gray-500">{{ $load['wbs_number'] }}</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-center text-sm text-gray-500">{{ $load['total'] }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                            <div class="mt-4 px-4">
                                {{--{!! $users->withQueryString()->links() !!}--}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
