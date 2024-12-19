<x-dynamic-component
    :component="$getFieldWrapperView()"
    :id="$getId()"
    :label="$getLabel()"
    :label-sr-only="$isLabelHidden()"
    :helper-text="$getHelperText()"
    :hint="$getHint()"
    :hint-icon="$getHintIcon()"
    :required="$isRequired()"
    :state-path="$getStatePath()"
>
    <div
        x-data="{ progress: $wire.entangle('{{ $getStatePath() }}') }"
        class="flex items-center space-x-2"
    >
        <input
            type="range"
            x-model="progress"
            min="0"
            max="100"
            step="1"
            class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700"
        >
        <span x-text="progress + '%'" class="text-sm font-medium text-gray-700 dark:text-gray-300"></span>
    </div>
</x-dynamic-component>
