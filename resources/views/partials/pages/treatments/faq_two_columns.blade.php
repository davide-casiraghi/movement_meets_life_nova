<div class="bg-gray-50" x-data="{ openPanel: null }">
    <div class="max-w-7xl mx-auto py-12 px-4 sm:py-16 sm:px-6 lg:px-8">

        <h2 class="text-center text-3xl font-extrabold text-gray-900 sm:text-4xl">
            Frequently asked questions
        </h2>

        <div class="md:grid md:grid-cols-6 md:gap-x-24">
            {{-- COL LEFT --}}
            <div class="md:col-span-3">
                <div class=" divide-y-2 divide-gray-200">
                    <dl class="mt-6 space-y-6 divide-y divide-gray-200">

                        {{-- question 1 --}}
                        <div class="pt-6">
                            <dt class="text-lg">
                                <button x-description="Expand/collapse question button" @click="openPanel = (openPanel === 0 ? null : 0)" x-bind:aria-expanded="openPanel === 0" class="text-left w-full flex justify-between items-start text-gray-400">
                                <span class="font-medium text-gray-900">
                                What's the best thing about Switzerland?
                                </span>
                                    <span class="ml-6 h-7 flex items-center">
                                    <svg class="h-6 w-6 transform rotate-0" x-description="Expand/collapse icon, toggle classes based on question open state.
                                        Heroicon name: outline/chevron-down" x-state:on="Open" x-state:off="Closed" x-bind:class="{ '-rotate-180': openPanel === 0, 'rotate-0': !(openPanel === 0) }" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </span>
                                </button>
                            </dt>
                            <dd class="mt-2 pr-12" x-show="openPanel === 0" style="display: none;">
                                <p class="text-base text-gray-500">
                                    I don't know, but the flag is a big plus. Lorem ipsum dolor sit amet consectetur adipisicing elit. Quas cupiditate laboriosam fugiat.
                                </p>
                            </dd>
                        </div>

                        {{-- question 2 --}}
                        <div class="pt-6">
                            <dt class="text-lg">
                                <button x-description="Expand/collapse question button" @click="openPanel = (openPanel === 1 ? null : 1)" x-bind:aria-expanded="openPanel === 1" class="text-left w-full flex justify-between items-start text-gray-400">
                                <span class="font-medium text-gray-900">
                                How do you make holy water?
                                </span>
                                    <span class="ml-6 h-7 flex items-center">
                                    <svg class="h-6 w-6 transform rotate-0" x-description="Expand/collapse icon, toggle classes based on question open state.
                                        Heroicon name: outline/chevron-down" x-state:on="Open" x-state:off="Closed" x-bind:class="{ '-rotate-180': openPanel === 1, 'rotate-0': !(openPanel === 1) }" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </span>
                                </button>
                            </dt>
                            <dd class="mt-2 pr-12" x-show="openPanel === 1" style="display: none;">
                                <p class="text-base text-gray-500">
                                    You boil the hell out of it. Lorem ipsum dolor sit amet consectetur adipisicing elit. Magnam aut tempora vitae odio inventore fuga aliquam nostrum quod porro. Delectus quia facere id sequi expedita natus.
                                </p>
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>

            {{-- COL RIGHT --}}
            <div class="md:col-span-3">
                <div class=" divide-y-2 divide-gray-200">
                    <dl class="mt-6 space-y-6 divide-y divide-gray-200">

                        {{-- question 3 --}}
                        <div class="pt-6">
                            <dt class="text-lg">
                                <button x-description="Expand/collapse question button" @click="openPanel = (openPanel === 2 ? null : 2)" x-bind:aria-expanded="openPanel === 2" class="text-left w-full flex justify-between items-start text-gray-400">
                                <span class="font-medium text-gray-900">
                                What's the best thing about Switzerland?
                                </span>
                                    <span class="ml-6 h-7 flex items-center">
                                    <svg class="h-6 w-6 transform rotate-0" x-description="Expand/collapse icon, toggle classes based on question open state.
                                        Heroicon name: outline/chevron-down" x-state:on="Open" x-state:off="Closed" x-bind:class="{ '-rotate-180': openPanel === 0, 'rotate-0': !(openPanel === 2) }" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </span>
                                </button>
                            </dt>
                            <dd class="mt-2 pr-12" x-show="openPanel === 2" style="display: none;">
                                <p class="text-base text-gray-500">
                                    I don't know, but the flag is a big plus. Lorem ipsum dolor sit amet consectetur adipisicing elit. Quas cupiditate laboriosam fugiat.
                                </p>
                            </dd>
                        </div>

                        {{-- question 4 --}}
                        <div class="pt-6">
                            <dt class="text-lg">
                                <button x-description="Expand/collapse question button" @click="openPanel = (openPanel === 3 ? null : 3)" x-bind:aria-expanded="openPanel === 3" class="text-left w-full flex justify-between items-start text-gray-400">
                                <span class="font-medium text-gray-900">
                                How do you make holy water?
                                </span>
                                    <span class="ml-6 h-7 flex items-center">
                                    <svg class="h-6 w-6 transform rotate-0" x-description="Expand/collapse icon, toggle classes based on question open state.
                                        Heroicon name: outline/chevron-down" x-state:on="Open" x-state:off="Closed" x-bind:class="{ '-rotate-180': openPanel === 1, 'rotate-0': !(openPanel === 3) }" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </span>
                                </button>
                            </dt>
                            <dd class="mt-2 pr-12" x-show="openPanel === 3" style="display: none;">
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