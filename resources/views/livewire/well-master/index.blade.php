<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Well Masters') }}
    </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-full mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="w-full">
                <div class="sm:flex sm:items-center">
                    <div class="sm:flex-auto">
                        <h1 class="text-base font-semibold leading-6 text-gray-900">{{ __('Well Masters') }}</h1>
                        <p class="mt-2 text-sm text-gray-700">A list of all the {{ __('Well Masters') }}.</p>
                    </div>
                    <!-- Settings Dropdown -->
                    <div>
                        <form wire:submit="search" role="form" method="post">
                            <x-input-label for="querySearch" :value="__('Pencarian Well Master')"/>
                            <x-text-input wire:model="querySearch" id="querySearch" name="querySearch" type="text" class="mt-1 block w-full" autocomplete="querySearch" placeholder="Enter to search"/>
                            @error('querySearch')
                                <x-input-error class="mt-2" :messages="$message"/>
                            @enderror
                        </form>
                    </div>
                    @can(\App\Policies\UserPolicy::IS_PHR_ROLE)
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
                                    <x-dropdown-link href="{{ route('well-masters.create') }}" class="cursor-pointer text-blue-600">
                                        {{ __('Add New Well Master') }}
                                    </x-dropdown-link>
                                </x-slot>
                            </x-dropdown>
                        </div>
                    @endcan
                </div>
                <div class="flow-root">
                    <div class="mt-8 overflow-x-auto">
                        <div class="inline-block min-w-full py-2 align-middle">
                            <table class="w-full divide-y divide-gray-300">
                                <thead>
                                <tr>
                                    <th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">No</th>
									<th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Field Name</th>
									<th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Ids Wellname</th>
									<th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Well Number</th>
									<th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Legal Well</th>
									<th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Job Type</th>
									<th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Job Sub Type</th>
									<th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Rig Type</th>
									<th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Rig No</th>
									<th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Wbs Number</th>
									<th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Actual Drmi</th>
									<th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Actual Spud</th>
									<th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Actual Drmo</th>
									<th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Status</th>

                                    @can(\App\Policies\UserPolicy::IS_PHR_ROLE)
                                    <th scope="col" class="px-3 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500"></th>
                                    @endcan
                                </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 bg-white">
                                @foreach ($wellMasters as $wellMaster)
                                    <tr class="even:bg-gray-50" wire:key="{{ $wellMaster->id }}">
                                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-semibold text-gray-900">{{ ++$i }}</td>

										<td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                            @can(\App\Policies\UserPolicy::IS_PHR_ROLE)
                                                <a wire:navigate href="{{ route('well-masters.show', $wellMaster->id) }}" class="text-green-600 font-bold hover:text-green-900 mr-2">{{ $wellMaster->field_name }}</a>
                                            @else
                                                {{ $wellMaster->field_name }}
                                            @endcan
                                        </td>
										<td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                            <button wire:navigate wire:click="onWellNamePressed({{ $wellMaster }})" class="text-blue-600 font-bold hover:text-blue-900 mr-2">{{ $wellMaster->ids_wellname }}</button>
                                        </td>
										<td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $wellMaster->well_number }}</td>
										<td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $wellMaster->legal_well }}</td>
										<td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $wellMaster->job_type }}</td>
										<td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $wellMaster->job_sub_type }}</td>
										<td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $wellMaster->rig_type }}</td>
										<td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $wellMaster->rig_no }}</td>
										<td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $wellMaster->wbs_number }}</td>
										<td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $wellMaster->actual_drmi }}</td>
										<td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $wellMaster->actual_spud }}</td>
										<td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $wellMaster->actual_drmo }}</td>
										<td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $wellMaster->status }}</td>

                                        @can(\App\Policies\UserPolicy::IS_PHR_ROLE)
                                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900">
                                            <a wire:navigate href="{{ route('well-masters.edit', $wellMaster->id) }}" class="text-indigo-600 font-bold hover:text-indigo-900  mr-2">{{ __('Edit') }}</a>
                                            <button
                                                class="text-red-600 font-bold hover:text-red-900"
                                                type="button"
                                                wire:click="delete({{ $wellMaster->id }})"
                                                wire:confirm="Are you sure you want to delete?">
                                                {{ __('Delete') }}
                                            </button>
                                        </td>
                                        @endcan
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="mt-4 px-4">
                    {!! $wellMasters->withQueryString()->links() !!}
                </div>
            </div>
        </div>
    </div>
</div>
