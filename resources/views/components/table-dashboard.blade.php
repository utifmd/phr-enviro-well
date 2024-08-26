<table class="w-full divide-y divide-gray-300">
    <thead>
    <tr>
        <th scope="col" rowspan="2"
            class="py-4 pl-4 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
            No
        </th>
        <th scope="col" rowspan="2"
            class="py-4 px-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
            Well Number
        </th>
        <th scope="col" colspan="{{ count($loads['days'] ?? []) }}"
            class="py-4 pl-4 text-center text-xs font-semibold uppercase tracking-wide text-gray-500">
            #Load VT in {{ ($selectedMonthName ?? 'N/A').' '.($year ?? 'N/A')}}
        </th>
        <th scope="col" rowspan="2"
            class="py-4 px-3 text-center text-xs font-semibold uppercase tracking-wide text-gray-500">
            AFE/ WBS Number
        </th>
        <th scope="col" rowspan="2"
            class="px-3 py-y text-center text-xs font-semibold uppercase tracking-wide text-gray-500">
            Total Load
        </th>
    </tr>
    <tr>
        @if(isset($loads['days']))
            @foreach($loads['days'] as $day)
                <th scope="col"
                    class="py-4 text-xs text-center font-semibold uppercase tracking-wide text-gray-500">{{ $day }}</th>
            @endforeach
        @endif
    </tr>
    </thead>
    <tbody class="divide-y divide-gray-200 bg-white">
    @if(isset($loads['data']))
        @foreach($loads['data'] as $load)
            <tr class="even:bg-gray-50" wire:key="{{ $load['wbs_number'] }}">
                <td class="whitespace-nowrap pl-4 py-4 text-sm font-semibold text-gray-900">{{ $load['num'].'. ' }}</td>
                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                    <a href="{{ route('posts.load-request',  $load['ids_wellname']) }}" class="hover:opacity-50">
                        {{ $load['well_number'] }}
                    </a>
                </td>
                @foreach($load['days'] as $day => $v)
                    <td class="whitespace-nowrap py-4 text-center text-xs text-gray-500">{{ $v }}</td>
                @endforeach
                <td class="whitespace-nowrap px-3 py-4 text-center text-sm text-gray-500">{{ $load['wbs_number'] }}</td>
                <td class="whitespace-nowrap px-3 py-4 text-center text-sm text-gray-500">{{ $load['total'] }}</td>
            </tr>
        @endforeach
    @endif
    </tbody>
</table>
