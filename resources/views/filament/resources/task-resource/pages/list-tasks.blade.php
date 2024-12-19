<x-filament::page>
    <div class="space-y-6">
        @foreach($tasks as $task)
            <div>
                {{ $task->title }} <!-- Display only task title for now -->
            </div>
        @endforeach
    </div>
</x-filament::page>
