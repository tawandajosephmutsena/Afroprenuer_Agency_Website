@extends('layouts.base')

<body class="bg-violet-100 dark:bg-gray-900">
    <x-nav-menu />

    <div class="container mx-auto px-4 py-8">
        <!-- Back Button -->
        <a href="{{ route('portfolio.index') }}" class="inline-flex items-center mb-6 text-yellow-600 hover:text-yellow-500">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="yellow-500" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Portfolio
        </a>

        <!-- Main Content -->
        <div class="bg-gray-200 dark:bg-gray-800 shadow-lg rounded-lg overflow-hidden">
            <!-- Gallery Section -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 p-6">
                @if($portfolio->gallery && count($portfolio->gallery) > 0)
                    @foreach($portfolio->gallery as $image)
                    <a href="{{ Storage::url($image) }}" data-fancybox="gallery" class="block relative h-64 rounded-lg overflow-hidden">
                        <img src="{{ Storage::url($image) }}" alt="{{ $portfolio->title }}" class="w-full h-full object-cover">
                    </a>
                    @endforeach
                @else
                    <div class="col-span-3 h-64 bg-gray-200 rounded-lg flex items-center justify-center">
                        <span class="text-gray-500 dark:text-gray-100">No images available</span>
                    </div>
                @endif
            </div>

            <!-- Project Details -->
           <div class="max-w-5xl mx-auto p-8 bg-violet-100 dark:bg-gray-900 shadow-md rounded-lg">
    <h1 class="text-4xl font-bold text-gray-900 dark:text-gray-100 mb-8">{{ $portfolio->title }}</h1>

    <div class="space-y-10">
        <!-- Project Details -->
        <section>
            <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-100 mb-6">Project Details</h2>
            <div class="space-y-4">
                @if($portfolio->client)
                <p class="text-gray-700 dark:text-gray-200">
                    <span class="font-medium text-gray-900 dark:text-gray-100">Client:</span> {{ $portfolio->client->name }}
                </p>
                @endif
                @if($portfolio->service)
                <p class="text-gray-700 dark:text-gray-200">
                    <span class="font-medium text-gray-900 dark:text-gray-100">Service:</span> {{ $portfolio->service->name }}
                </p>
                @endif
                @if($portfolio->completion_date)
                <p class="text-gray-700 dark:text-gray-200">
                    <span class="font-medium text-gray-900 dark:text-gray-100">Completion Date:</span> {{ $portfolio->completion_date->format('M d, Y') }}
                </p>
                @endif
                @if($portfolio->url)
                <p class="text-gray-700">
                    <span class="font-medium text-yellow-600 dark:text-yellow-500">Project URL:</span>
                    <a href="{{ $portfolio->url }}" target="_blank" class="text-yellow-600 hover:text-yellow-500 underline">
                        Visit Project
                    </a>
                </p>
                @endif
            </div>
        </section>

        <!-- Project Description -->
        <section>
            <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-6">Project Description</h2>
            <p class="text-gray-700 dark:text-gray-200 leading-relaxed">{{ $portfolio->description }}</p>
        </section>
    </div>
</div>

        <!-- Related Projects -->
        @if($relatedPortfolios->count() > 0)
        <div class="mt-16 bg-violet-100 dark:bg-gray-900 p-16">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-8">Related Projects</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($relatedPortfolios as $relatedProject)
                <a href="{{ route('portfolio.show', $relatedProject) }}" class="block group">
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
                        <div class="relative h-48">
                            @if($relatedProject->gallery && count($relatedProject->gallery) > 0)
                            <img src="{{ Storage::url($relatedProject->gallery[0]) }}" alt="{{ $relatedProject->title }}" class="w-full h-full object-cover group-hover:opacity-75 transition-opacity">
                            @else
                            <div class="w-full h-full bg-violet-200 dark:bg-gray-700 flex items-center justify-center">
                                <span class="text-gray-500 dark:text-gray-200">No image</span>
                            </div>
                            @endif
                        </div>
                        <div class="p-4">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 group-hover:text-yellow-600">{{ $relatedProject->title }}</h3>
                            @if($relatedProject->service)
                            <p class="text-sm text-gray-600">{{ $relatedProject->service->name }}</p>
                            @endif
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endif
    </div>


