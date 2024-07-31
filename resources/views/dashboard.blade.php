<div class="py-12">
    <div class="max-w-full mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="w-full">
                <div class="sm:flex sm:items-center">
                    <div class="sm:flex-auto">
                        <h1 class="text-base font-semibold leading-6 text-gray-900">{{ __('Loading Unloading Report') }}</h1>
                        <p class="mt-2 text-sm text-gray-700">Vacuum Truck Report View</p>
                    </div>
                    <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                        <a type="button" wire:navigate href="{{ __('#') }}" class="block rounded-md bg-green-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-green-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600">Export To Excel</a>
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
                                    <th scope="col" colspan="{{count($loads['days'])}}" class="py-4 pl-4 text-center border text-xs font-semibold uppercase tracking-wide text-gray-500">
                                        #Load VT in {{date('M').' '.date('Y')}}
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
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $load['well_number'] }}</td>
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
