<x-filament::widget>
    <x-filament::card>
        @if($activeTask)
            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-medium">{{ $activeTask->title }}</h3>
                    <button
                        wire:click="toggleFocusMode"
                        class="px-4 py-2 text-sm font-medium rounded-md {{ $focusModeActive ? 'bg-red-600 text-white' : 'bg-primary-600 text-white' }}"
                    >
                        {{ $focusModeActive ? 'Exit Focus Mode' : 'Start Focus Mode' }}
                    </button>
                </div>

                @if($focusModeActive)
                    <div class="space-y-4">
                        <div class="relative pt-1">
                            <div class="flex mb-2 items-center justify-between">
                                <div>
                                    <span class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full text-primary-600 bg-primary-200">
                                        Progress
                                    </span>
                                </div>
                                <div class="text-right">
                                    <span class="text-xs font-semibold inline-block text-primary-600">
                                        {{ $currentStep + 1 }}/{{ count($breakdownSteps) }}
                                    </span>
                                </div>
                            </div>
                            <div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-primary-200">
                                <div
                                    style="width: {{ $progress }}%"
                                    class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-primary-500 transition-all duration-500"
                                ></div>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <h4 class="font-medium">Current Step:</h4>
                            <p class="text-gray-700">{{ $breakdownSteps[$currentStep] }}</p>

                            <button
                                wire:click="completeStep"
                                class="w-full mt-4 px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500"
                            >
                                Complete Step
                            </button>
                        </div>
                    </div>
                @endif
            </div>
        @else
            <div class="text-center text-gray-500">
                Select a task to enter focus mode
            </div>
        @endif
    </x-filament::card>
</x-filament::widget>
