@extends('layouts.base')

<body class="bg-violet-100 dark:bg-gray-900">

    <x-nav-menu />

    <div>



<div class="bg-violet-100 dark:bg-gray-900 py-6 sm:py-8 lg:py-12">
    <div class="mx-auto max-w-screen-2xl px-4 md:px-8">
        <!-- header section -->
        <div class="mb-10 md:mb-16">
            <h2 class="mb-4 text-center text-2xl font-bold text-gray-800 dark:text-gray-200 md:mb-6 lg:text-3xl">Our Work Speaks for Itself

</h2>
            <p class="mx-auto max-w-screen-lg text-center text-gray-700 dark:text-gray-200 md:text-lg">
Discover how we transform visionary ideas into extraordinary realities. Our portfolio showcases diverse projects across industries, reflecting innovation, quality, and our relentless commitment to excellence.

From captivating websites to dynamic mobile apps and impactful advertising campaigns, our work is a testament to our ability to deliver premium solutions tailored to unique client needs.

Explore our portfolio and imagine what we can achieve together.            </p>
        </div>






<div class="container mx-auto py-12 px-4 max-w-screen-xl">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        @foreach($portfolios as $portfolio)
            <div class="group flex flex-col rounded-xl bg-violet-100 dark:bg-gray-800 shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden transform hover:-translate-y-2">
                <!-- Main portfolio image -->
                <div class="relative h-64 overflow-hidden">
                    @if(count($portfolio->gallery) > 0)
                        <img
                            src="{{ Storage::url($portfolio->gallery[0]) }}"
                            alt="{{ $portfolio->title }}"
                            class="h-full w-full object-cover transition-all duration-500 transform group-hover:scale-110 group-hover:rotate-2"
                        >
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-transparent to-transparent opacity-60 group-hover:opacity-70 transition-opacity duration-300"></div>
                    <div class="absolute bottom-3 left-3">
                        @if($portfolio->service)
                            <span class="inline-block rounded-lg border border-gray-500 px-2 py-1 text-xs text-gray-200 backdrop-blur md:px-3 md:text-sm">
                                {{ $portfolio->service->name }}
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Portfolio details -->
                <div class="p-6 flex-grow">
                    <h2 class="text-xl font-bold text-gray-800 dark:text-gray-100 mb-2 group-hover:text-blue-600 transition-colors duration-300">{{ $portfolio->title }}</h2>
                    <p class="text-gray-600 dark:text-gray-100 mb-4 line-clamp-2">{{ $portfolio->description }}</p>

                    <div class="mb-4">
                        @if($portfolio->client)
                            <span class="text-sm text-gray-500 dark:text-gray-100">Client: {{ $portfolio->client->name }}</span>
                        @endif
                        @if($portfolio->completion_date)
                            <span class="text-sm text-gray-500 dark:text-yellow-600 ml-4">
                                Completed: {{ $portfolio->completion_date->format('M Y') }}
                            </span>
                        @endif
                    </div>

                    <!-- Gallery thumbnails -->
                    @if(count($portfolio->gallery) > 1)
                        <div class="grid grid-cols-4 gap-2 mb-4">
                            @foreach(array_slice($portfolio->gallery, 1, 4) as $image)
                                <div class="aspect-square rounded-lg overflow-hidden">
                                    <img
                                        src="{{ Storage::url($image) }}"
                                        alt="Gallery image for {{ $portfolio->title }}"
                                        class="h-full w-full object-cover transition-transform duration-300 hover:scale-110"
                                    >
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <!-- Action buttons -->
                    <div class="flex justify-between items-center mt-auto">
                        <a
                            href="{{ route('portfolio.show', $portfolio) }}"
                            class="inline-block px-4 py-2 bg-yellow-600 text-white hover:text-gray-900 rounded-md hover:bg-yellow-500 transform hover:scale-105 transition-all duration-300 text-sm font-medium"
                        >
                            View Details →
                        </a>
                        <span class="text-sm {{ $portfolio->status ? 'text-green-600' : 'text-gray-500' }}">
                            {{ $portfolio->status ? 'Active' : 'Archived' }}
                        </span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

    </div>
</div>



