<div class="py-12">
    <div class="max-w-full mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="w-full p-5">
                <h1 class="mb-4 text-3xl font-extrabold text-gray-900 dark:text-white md:text-5xl lg:text-6xl">
                    Welcome To<br>O&M <span class="text-transparent bg-clip-text bg-gradient-to-r to-emerald-600 from-sky-400">Environment Facilities Operations</span></h1>
                <p class="text-lg font-normal text-gray-500 lg:text-xl dark:text-gray-400">Hi ({{ explode("_", auth()->user()->role)[1].'), '.(auth()->user()->username ?? 'NA') }}</p>
            </div>

            {{--<div class="w-full p-5">
                <h1 class="text-base font-semibold leading-6 text-gray-900">{{ __('Hi, ').(auth()->user()->username ?? 'NA') }}</h1>
                <p class="mt-2 text-sm text-gray-700">Welcome to O&M Environment Facilities Operations</p>
            </div>--}}
        </div>
        @can(\App\Policies\UserPolicy::IS_PHR_ROLE)
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="w-full">
                    <div class="my-6">
                        <h1 class="text-base font-semibold leading-6 text-gray-900">Daily Updates</h1>
                    </div>
                    @include('livewire.dashboard.daily-report')
                </div>
            </div>
            {{--<div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="w-full">
                    <div class="my-6">
                        <h1 class="text-base font-semibold leading-6 text-gray-900">Monthly Updates</h1>
                    </div>
                    @include('livewire.dashboard.monthly-report')
                </div>
            </div>--}}
        @endcan
        {{--<div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="w-full">
                <div class="my-6">
                    <h1 class="text-base font-semibold leading-6 text-gray-900">Chart Request Status</h1>
                </div>
                <div class="sm:flex sm:items-center">
                    <div class="sm:flex-auto mb-8">
                        @can(\App\Policies\UserPolicy::IS_PT_ROLE)
                            <div class="md:flex md:justify-around">
                                <div class="md:w-1/6 h-[23rem]">
                                    <livewire:livewire-column-chart
                                        key="{{ $columnChartModel->reactiveKey() }}"
                                        :column-chart-model="$columnChartModel"
                                    />
                                </div>
                                <div class="md:w-1/2 h-[23rem]">
                                    <livewire:livewire-pie-chart
                                        key="{{ $pieChartModel->reactiveKey() }}"
                                        :pie-chart-model="$pieChartModel"
                                    />
                                </div>
                            </div>
                        @endcan
                        @cannot(\App\Policies\UserPolicy::IS_NOT_GUEST_ROLE)
                            <p class="mt-2 text-sm text-red-600 font-bold">Please contact developer to access the{{env('APP_NAME')}} app.</p>
                        @endcannot
                    </div>
                </div>
            </div>
        </div>--}}
    </div>
</div>
