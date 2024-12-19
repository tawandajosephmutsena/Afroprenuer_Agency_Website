@php
    use App\Models\Project;

    $projects = Project::with(['tasks', 'notes', 'client'])->get();
@endphp

<x-filament::page>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($projects as $project)
            <div
                x-data="{}"
                x-init="() => {
                    mountReactComponent('ProjectCard', $el, { project: @json($project) })
                }"
            ></div>
        @endforeach
    </div>

    @if($projects->isEmpty())
        <div class="flex items-center justify-center p-8">
            <div class="text-center">
                <x-heroicon-o-document-text class="mx-auto h-12 w-12 text-gray-400" />
                <h3 class="mt-2 text-sm font-medium text-gray-900">No projects</h3>
                <p class="mt-1 text-sm text-gray-500">Get started by creating a new project.</p>
                <div class="mt-6">
                    {{ $this->createAction }}
                </div>
            </div>
        </div>
    @endif
</x-filament::page>
