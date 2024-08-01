<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Report Load') }}
    </h2>
</x-slot>

<div class="flex-col p-6 space-y-3">
    <label for="legendStatus">Legend Request Status</label>
    <div id="legendStatus" class="flex">
        <span class="flex items-center text-sm font-medium text-gray-900 dark:text-white me-3"><span
                class="flex w-2.5 h-2.5 bg-yellow-300 rounded-full me-1.5 flex-shrink-0"></span>
            {{ \App\Utils\Enums\WorkOrderStatusEnum::STATUS_PENDING->value }}
        </span>
        <span class="flex items-center text-sm font-medium text-gray-900 dark:text-white me-3"><span
                class="flex w-2.5 h-2.5 bg-red-500 rounded-full me-1.5 flex-shrink-0"></span>
            {{ \App\Utils\Enums\WorkOrderStatusEnum::STATUS_REJECTED->value }}
        </span>
        <span class="flex items-center text-sm font-medium text-gray-900 dark:text-white me-3"><span
                class="flex w-2.5 h-2.5 bg-green-500 rounded-full me-1.5 flex-shrink-0"></span>
            {{ \App\Utils\Enums\WorkOrderStatusEnum::STATUS_ACCEPTED->value }}
        </span>
    </div>
    <div class="h-3"></div>
    <div class="flex flex-wrap gap-3 grid-cols-3">
        @foreach($posts as $i => $post)
            <div class="p-4 sm:p-8 shadow sm:rounded-lg bg-white">
                <div class="flex flex-col">
                    <h1 class="font-semibold leading-6 text-gray-900">
                        <a wire:navigate href="{{ route('posts.show', $post->id) }}">{{ $post->title }}</a>
                    </h1>
                    <p class="mt-2 text-sm text-gray-700">{{ $post->desc }}</p>
                    <p class="mt-2 text-xs text-gray-700">{{ $post->timeAgo }}</p>
                    <dl class="divide-y mt-6 divide-gray-100">
                        <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                            <dt class="text-sm font-medium leading-6 text-gray-900">Evidence</dt>
                            <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                                <img class="w-[150] h-[150]" src="{{$post->uploadedUrls[0]->url ?? '#'}}"
                                     alt="evidence well">
                            </dd>
                        </div>
                        <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                            <dt class="text-sm font-medium leading-6 text-gray-900">Total load</dt>
                            <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{ count($post->workOrders) }}
                                x
                            </dd>
                        </div>
                        <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                            <dt class="text-sm font-medium leading-6 text-gray-900">Request Status</dt>
                            <dd class="space-y-3 items-center mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                                @foreach($post->workOrders as $i => $wo)
                                    <span
                                        class="flex items-center text-sm font-medium text-gray-900 dark:text-white me-3">
                                    @if($wo['status'] == \App\Utils\Enums\WorkOrderStatusEnum::STATUS_PENDING->value)
                                            <span
                                                class="flex w-2.5 h-2.5 bg-yellow-300 rounded-full me-1.5 flex-shrink-0"></span>
                                        @elseif($wo['status'] == \App\Utils\Enums\WorkOrderStatusEnum::STATUS_REJECTED->value)
                                            <span
                                                class="flex w-2.5 h-2.5 bg-red-600 rounded-full me-1.5 flex-shrink-0"></span>
                                        @else
                                            <span
                                                class="flex w-2.5 h-2.5 bg-green-600 rounded-full me-1.5 flex-shrink-0"></span>
                                        @endif
                                    Load {{$i +1}}
                                    </span>
                                    @if($i == 1)
                                        <a class="flex" href="{{ route('posts.show', $post->id) }}">More detail..</a>
                                        @break
                                    @endif
                                @endforeach
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
        @endforeach
        <div class="mt-4 px-4">
            {!! $posts->withQueryString()->links() !!}
        </div>
    </div>
</div>
