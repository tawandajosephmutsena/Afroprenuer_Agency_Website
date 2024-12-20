@extends('layouts.base')
<body class="bg-violet-100 dark:bg-gray-900">
    <x-nav-menu />

    <!-- Hero Section  -->
    <div class="relative isolate overflow-hidden bg-violet-100 dark:bg-gray-900">
        <div class="absolute left-1/2 top-0 -z-10 -translate-x-1/2 blur-3xl xl:-top-6" aria-hidden="true">
            <div class="aspect-[1155/678] w-[72.1875rem] bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-30"
                 style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)">
            </div>
        </div>

        <div class="mx-auto max-w-7xl px-6 py-24 sm:py-32 lg:px-8">
            <div class="mx-auto max-w-2xl lg:max-w-4xl">
                <div class="text-center">
                    <h1 class="text-4xl font-bold tracking-tight text-gray-900 dark:text-gray-100 sm:text-6xl">{{ $service->name }}</h1>
                    <p class="mt-6 text-lg leading-8 text-gray-300">
                        <span class="text-violet-800 dark:text-yellow-600 font-semibold">{{ $service->service_type }}</span>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="mx-auto max-w-7xl px-6 py-16 sm:py-24 lg:px-8 bg-violet-100 py-24 sm:py-32 dark:bg-gray-900">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Left Column: Image and Quick Info -->
            <div class="space-y-8">
                <!-- Service Image -->
                <div class="rounded-2xl overflow-hidden shadow-xl">
                    @if ($service->image)
                        <img src="{{ Storage::url($service->image) }}" alt="{{ $service->name }}"
                             class="w-full h-96 object-cover">
                    @else
                        <img src="https://via.placeholder.com/800x600" alt="Placeholder"
                             class="w-full h-96 object-cover">
                    @endif
                </div>

                <!-- Quick Info Card -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-8">
                    <div class="grid grid-cols-2 gap-6">
                        <div class="text-center">
                            <div class="text-gray-500 dark:text-gray-200">Duration</div>
                            <div class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $service->duration }} Days</div>
                        </div>
                        <div class="text-center">
                            <div class="text-gray-800 dark:text-gray-100">Starting Price</div>
                            <div class="text-2xl font-bold text-gray-900 dark:text-gray-100">${{ number_format($service->price, 2) }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Details -->
            <div class="space-y-8">
                <!-- Description Card -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-8">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-4">About This Service</h2>
                    <p class="text-gray-600 dark:text-gray-200 leading-relaxed">{{ $service->description }}</p>
                </div>

                <!-- Target Audience Card -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-8">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-200 mb-4">Perfect For</h2>
                    <div class="flex items-center gap-2">
                        <svg class="h-6 w-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <span class="text-gray-600 dark:text-gray-200">{{ $service->target_audience }}</span>
                    </div>
                </div>

                <!-- Deliverables Card -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-8">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-4">What You'll Get</h2>
                    <div class="prose prose-yellow text-gray-600 dark:text-gray-200">
                        {!! nl2br(e($service->deliverables)) !!}
                    </div>
                </div>

                <!-- CTA Button -->
                <div class="text-center lg:text-left">
                    <a href="#" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-yellow-600 hover:bg-yellow-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                        Book This Service
                        <svg class="ml-2 -mr-1 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Services Section -->
    <div class="bg-gray-900">
        <div class="mx-auto max-w-7xl px-6 py-16 sm:py-24 lg:px-8">
            <div class="text-center">
                <h2 class="text-3xl font-bold tracking-tight text-white sm:text-4xl">Other Services You Might Like</h2>
                <p class="mt-4 text-lg leading-8 text-gray-300">Discover more ways we can help you achieve your goals.</p>
            </div>

            <!-- Related Services Grid (You'll need to pass these from your controller) -->
            <div class="mt-12 grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($relatedServices ?? [] as $relatedService)
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                        @if ($relatedService->image)
                            <img src="{{ Storage::url($relatedService->image) }}" alt="{{ $relatedService->name }}"
                                 class="w-full h-48 object-cover">
                        @else
                            <img src="https://via.placeholder.com/400x300" alt="Placeholder"
                                 class="w-full h-48 object-cover">
                        @endif
                        <div class="p-6">
                            <h3 class="text-xl font-semibold text-gray-900">{{ $relatedService->name }}</h3>
                            <p class="mt-2 text-gray-600 line-clamp-3">{{ $relatedService->description }}</p>
                            <div class="mt-4">
                                <a href="{{ route('services.show', $relatedService->id) }}"
                                   class="text-fuchsia-600 hover:text-fuchsia-700 font-semibold">
                                    Learn More →
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>



    <div class="bg-violet-100 dark:bg-gradient-to-br from-gray-950 from-70% to-fuchsia-950 to 30% py-24 sm:py-32">
        <div class="mx-auto max-w-7xl py-24 sm:px-6 sm:py-32 lg:px-8">
            <div class="relative isolate overflow-hidden bg-gray-900 px-6 pt-16 shadow-2xl sm:rounded-3xl sm:px-16 md:pt-24 lg:flex lg:gap-x-20 lg:px-24 lg:pt-0">
                <svg viewBox="0 0 1024 1024" class="absolute left-1/2 top-1/2 -z-10 h-[64rem] w-[64rem] -translate-y-1/2 [mask-image:radial-gradient(closest-side,white,transparent)] sm:left-full sm:-ml-80 lg:left-1/2 lg:ml-0 lg:-translate-x-1/2 lg:translate-y-0" aria-hidden="true">
                    <circle cx="512" cy="512" r="512" fill="url(#759c1415-0410-454c-8f7c-9a820de03641)" fill-opacity="0.7" />
                    <defs>
                        <radialGradient id="759c1415-0410-454c-8f7c-9a820de03641">
                            <stop stop-color="#7775D6" />
                            <stop offset="1" stop-color="#E935C1" />
                        </radialGradient>
                    </defs>
                </svg>
                <div class="mx-auto max-w-md text-center lg:mx-0 lg:flex-auto lg:py-32 lg:text-left">
                    <h2 class="text-3xl font-bold tracking-tight text-white sm:text-4xl">You can download & use<br>this website for FREE!</h2>
                    <p class="mt-6 text-lg leading-8 text-gray-300">At Mhondoro Inc, we run an open source project, Apfroprenuers Online, an Agency website built using the TALL stack and is available for free download</p>
                    <div class="mt-10 flex items-center justify-center gap-x-6 lg:justify-start">
                        <a href="#" class="rounded-md bg-white px-3.5 py-2.5 text-sm font-semibold text-gray-900 shadow-sm hover:bg-gray-100 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white">Get started</a>
                        <a href="#" class="text-sm font-semibold leading-6 text-white">Learn more <span aria-hidden="true">→</span></a>
                    </div>
                </div>
                <div class="relative mt-16 h-80 lg:mt-8">
                    <img class="absolute left-0 top-0 w-[57rem] max-w-none rounded-md bg-white/5 ring-1 ring-white/10" src="{{ asset('storage/media/web-apllication-mhondoro-inc.jpg') }}" alt="Mhondoro Screenshot"> width="1824" height="1080">
                </div>
            </div>
        </div>
    </div>


