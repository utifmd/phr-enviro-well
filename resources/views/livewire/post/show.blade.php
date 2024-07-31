<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ $post->name ?? __('Load') . " " . __('Detail') }}
    </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-full mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="w-full">
                <div class="sm:flex sm:items-center">
                    <div class="sm:flex-auto">
                        <h1 class="text-base font-semibold leading-6 text-gray-900">{{ $post->title }}
                            ({{ $post->type }})</h1>
                        <p class="mt-2 text-sm text-gray-700">{{ $post->desc }}.</p>
                        <p class="mt-2 text-xs text-gray-800">Requester: {{ $post->user->email }}.</p>
                    </div>
                    <div class="flex mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                        @foreach($post->uploadedUrls as $i => $uploaded)
                            <a target="__blank" type="button" wire:navigate href="{{ $uploaded->url ?? '#' }}"
                               class="block rounded-md bg-indigo-600 px-3 py-2 ms-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Evidence {{$i+1}}</a>
                        @endforeach
                    </div>
                </div>

                <div class="flow-root">
                    <div class="overflow-x-auto">
                        <div class="inline-block min-w-full py-10 align-middle">
                            <table class="w-full divide-y divide-gray-300">
                                <thead>
                                <tr>
                                    <th scope="col"
                                        class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                                        No
                                    </th>
                                    <th scope="col"
                                        class="px-3 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                                        WBS Number
                                    </th>
                                    <th scope="col"
                                        class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                                        Shift
                                    </th>
                                    <th scope="col"
                                        class="px-3 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                                        Load At
                                    </th>
                                    <th scope="col"
                                        class="px-3 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                                        Request Status
                                    </th>
                                    <th scope="col"
                                        class="px-3 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                                        Action
                                    </th>
                                </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 bg-white">
                                @foreach($post->workOrders as $i => $wo)
                                    <tr class="even:bg-gray-50" wire:key="{{ $wo->id }}">
                                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-semibold text-gray-900">{{ ++$i }}.</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $wo['wbs_number'] }}</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ ucfirst(strtolower($wo['shift'])) }}
                                            Shift
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $wo['created_at'] }}</td>
                                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900">
                                            @if($wo['status'] == \App\Utils\Enums\WorkOrderStatusEnum::STATUS_SENT->value)
                                                <button class="text-red-600 font-bold hover:text-yellow-300" type="button">{{ $wo['status'] }}</button>
                                            @elseif($wo['status'] == \App\Utils\Enums\WorkOrderStatusEnum::STATUS_DENIED->value)
                                                <button class="text-red-600 font-bold hover:text-red-300" type="button">{{ $wo['status'] }}</button>
                                            @else
                                                <button class="text-red-600 font-bold hover:text-green-300" type="button">{{ $wo['status'] }}</button>
                                            @endif
                                        </td>
                                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900">
                                            <button wire:click="delete({{ $wo['id'] }})" wire:confirm="Are you sure you want to delete?" class="text-red-600 font-bold hover:text-red-600" type="button">DELETE</button>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
