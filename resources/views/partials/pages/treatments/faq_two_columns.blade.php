<div class="bg-gray-50" x-data="{ openPanelLeft: 0, openPanelRight: 0 }">
    <div class="max-w-7xl mx-auto py-12 px-4 sm:py-16 sm:px-6 lg:px-8">

        <h2 class="text-center text-3xl font-extrabold text-gray-900 sm:text-4xl">
            Frequently asked questions
        </h2>

        <div class="md:grid md:grid-cols-6 md:gap-x-24">
            {{--col1--}}
            <div class="md:col-span-3">
                <div class=" divide-y-2 divide-gray-200"> {{--max-w-3xl mx-auto--}}
                    <dl class="mt-6 space-y-6 divide-y divide-gray-200">
                        <div class="pt-6">
                            <dt class="text-lg">
                                <button x-description="Expand/collapse question button" @click="openPanelLeft = (openPanelLeft === 0 ? null : 0)" class="text-left w-full flex justify-between items-start text-gray-400" x-bind:aria-expanded="openPanelLeft === 0">
                                <span class="font-medium text-gray-900">
                                What's the best thing about Switzerland?
                                </span>
                                    <span class="ml-6 h-7 flex items-center">
                                    <svg class="h-6 w-6 transform rotate-0" x-description="Expand/collapse icon, toggle classes based on question open state.
                                        Heroicon name: outline/chevron-down" x-state:on="Open" x-state:off="Closed" x-bind:class="{ '-rotate-180': openPanelLeft === 0, 'rotate-0': !(openPanelLeft === 0) }" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </span>
                                </button>
                            </dt>
                            <dd class="mt-2 pr-12" x-show="openPanelLeft === 0" style="display: none;">
                                <p class="text-base text-gray-500">
                                    I don't know, but the flag is a big plus. Lorem ipsum dolor sit amet consectetur adipisicing elit. Quas cupiditate laboriosam fugiat.
                                </p>
                            </dd>
                        </div>
                        <div class="pt-6">
                            <dt class="text-lg">
                                <button x-description="Expand/collapse question button" @click="openPanelLeft = (openPanelLeft === 1 ? null : 1)" class="text-left w-full flex justify-between items-start text-gray-400" x-bind:aria-expanded="openPanelLeft === 1">
                                <span class="font-medium text-gray-900">
                                How do you make holy water?
                                </span>
                                    <span class="ml-6 h-7 flex items-center">
                                    <svg class="h-6 w-6 transform rotate-0" x-description="Expand/collapse icon, toggle classes based on question open state.
                                        Heroicon name: outline/chevron-down" x-state:on="Open" x-state:off="Closed" x-bind:class="{ '-rotate-180': openPanelLeft === 1, 'rotate-0': !(openPanelLeft === 1) }" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </span>
                                </button>
                            </dt>
                            <dd class="mt-2 pr-12" x-show="openPanelLeft === 1" style="display: none;">
                                <p class="text-base text-gray-500">
                                    You boil the hell out of it. Lorem ipsum dolor sit amet consectetur adipisicing elit. Magnam aut tempora vitae odio inventore fuga aliquam nostrum quod porro. Delectus quia facere id sequi expedita natus.
                                </p>
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>

            {{--col2--}}
            <div class="md:col-span-3">
                <div class=" divide-y-2 divide-gray-200"> {{--max-w-3xl mx-auto--}}
                    <dl class="mt-6 space-y-6 divide-y divide-gray-200">
                        <div class="pt-6">
                            <dt class="text-lg">
                                <button x-description="Expand/collapse question button" @click="openPanelRight = (openPanelRight === 0 ? null : 0)" class="text-left w-full flex justify-between items-start text-gray-400" x-bind:aria-expanded="openPanelRight === 0">
                                <span class="font-medium text-gray-900">
                                What's the best thing about Switzerland?
                                </span>
                                    <span class="ml-6 h-7 flex items-center">
                                    <svg class="h-6 w-6 transform rotate-0" x-description="Expand/collapse icon, toggle classes based on question open state.
                                        Heroicon name: outline/chevron-down" x-state:on="Open" x-state:off="Closed" x-bind:class="{ '-rotate-180': openPanelRight === 0, 'rotate-0': !(openPanelRight === 0) }" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </span>
                                </button>
                            </dt>
                            <dd class="mt-2 pr-12" x-show="openPanelRight === 0" style="display: none;">
                                <p class="text-base text-gray-500">
                                    I don't know, but the flag is a big plus. Lorem ipsum dolor sit amet consectetur adipisicing elit. Quas cupiditate laboriosam fugiat.
                                </p>
                            </dd>
                        </div>
                        <div class="pt-6">
                            <dt class="text-lg">
                                <button x-description="Expand/collapse question button" @click="openPanelRight = (openPanelRight === 1 ? null : 1)" class="text-left w-full flex justify-between items-start text-gray-400" x-bind:aria-expanded="openPanelRight === 1">
                                <span class="font-medium text-gray-900">
                                How do you make holy water?
                                </span>
                                    <span class="ml-6 h-7 flex items-center">
                                    <svg class="h-6 w-6 transform rotate-0" x-description="Expand/collapse icon, toggle classes based on question open state.
                                        Heroicon name: outline/chevron-down" x-state:on="Open" x-state:off="Closed" x-bind:class="{ '-rotate-180': openPanelRight === 1, 'rotate-0': !(openPanelRight === 1) }" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </span>
                                </button>
                            </dt>
                            <dd class="mt-2 pr-12" x-show="openPanelRight === 1" style="display: none;">
                                <p class="text-base text-gray-500">
                                    You boil the hell out of it. Lorem ipsum dolor sit amet consectetur adipisicing elit. Magnam aut tempora vitae odio inventore fuga aliquam nostrum quod porro. Delectus quia facere id sequi expedita natus.
                                </p>
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>

        </div>






    </div>
</div>