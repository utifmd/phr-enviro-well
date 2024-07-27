<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Posts') }}
    </h2>
</x-slot>

<div class="flex-col py-12">
    <div class="w-full px-6">
        <a type="button" wire:navigate href="{{ route('posts.create') }}"
           class="bg-white shadow text-gray-800 hover:bg-gray-400 font-bold py-2 px-4 rounded inline-flex items-center">
            <span class="fill-current mr-2 material-symbols-outlined">add</span>
            <span>Add New</span>
        </a>
    </div>
    <div class="flex flex-wrap p-6 gap-3 grid-cols-3">
        @foreach($posts as $i => $post)
            <div class="p-4 sm:p-8 shadow sm:rounded-lg bg-white">
                <div class="flex flex-col">
                    <h1 class="font-semibold leading-6 text-gray-900">{{ $post->title }}</h1>
                    <p class="mt-2 text-sm text-gray-700">{{ ++$i }}. {{ $post->desc }}</p>
                    <dl class="divide-y mt-6 divide-gray-100">
                        <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                            <dt class="text-sm font-medium leading-6 text-gray-900">Well Number</dt>
                            <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{ $post->workOrders[0]['well_number'] ?? 'NA' }}</dd>
                        </div>
                        <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                            <dt class="text-sm font-medium leading-6 text-gray-900">WBS Number</dt>
                            <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{ $post->workOrders[0]['wbs_number'] ?? 'NA' }}</dd>
                        </div>
                    </dl>
                </div>
                <div class="w-fit text-right">
                    <a class="shadow p-6 py-2 rounded text-gray-600 font-bold hover:text-gray-900 mr-2" wire:navigate href="{{ route('posts.show', $post->id) }}">{{ __('Show') }}</a>
                </div>
            </div>
        @endforeach
        <div class="mt-4 px-4">
            {!! $posts->withQueryString()->links() !!}
        </div>
    </div>
</div>
