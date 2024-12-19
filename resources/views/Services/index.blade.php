@extends('layouts.base')

<body class="bg-violet-100 dark:bg-gray-900">
    <x-nav-menu />

    <div>

        <div class="relative isolate overflow-hidden bg-violet-100 dark:bg-gray-900 py-16 sm:py-24 lg:py-32 mx-auto">
            <div class="relative isolate overflow-hidden px-80 mx-auto">
              <div class="mx-auto flex justify-center items-center">
                <div class="max-w-xl lg:max-w-lg text-center">
                  <h2 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-gray-100 sm:text-4xl">Our Premium Offerings</h2>
                  <p class="mt-4 text-lg leading-8 text-gray-900 dark:text-gray-100">At Mhondoro Inc., we specialize in high-quality services that elevate your business to new heights:

</p>
                </div>
              </div>
            </div>
            <div class="absolute left-1/2 top-0 -z-10 -translate-x-1/2 blur-3xl xl:-top-6" aria-hidden="true">
              <div class="aspect-[1155/678] w-[72.1875rem] bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-30" style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"></div>
            </div>
          </div>





          <div class="container mx-auto py-12 ">

            <div class="grid grid-cols-1 gap-6">
                @forelse ($services as $service)
                    <div class="px-2 py-20 w-full flex justify-center">
                        <div class="bg-white lg:mx-8 lg:flex lg:max-w-5xl lg:shadow-lg rounded-lg">
                            <div class="lg:w-1/2">
                                @if ($service->image)
                                    <div class="lg:scale-110 h-80 bg-cover lg:h-full rounded-b-none border lg:rounded-lg"
                                         style="background-image:url('{{ Storage::url($service->image) }}')">
                                    </div>
                                @else
                                    <div class="lg:scale-110 h-80 bg-cover lg:h-full rounded-b-none border lg:rounded-lg"
                                         style="background-image:url('https://via.placeholder.com/400')">
                                    </div>
                                @endif
                            </div>
                            <div class="py-12 px-6 lg:px-12 max-w-xl lg:max-w-5xl lg:w-1/2  bg-white dark:bg-gray-800">
                                <h2 class="text-3xl text-gray-800 dark:text-gray-100 font-bold">
                                    {{ $service->name }}
                                </h2>
                                <h4>
                                    <span class="text-yellow-500 Dark:text-yellow-500 font-extrabold">{{ $service->service_type }}</span>
                                </h4>
                                <p class="mt-4 text-gray-600 dark:text-gray-100">
                                    {{ Str::limit($service->description, 150) }}
                                </p>
                                <div class="mt-8">
                                    <a href="{{ route('services.show', $service->id) }}" class="bg-gray-900 text-gray-100 px-5 py-3 font-semibold rounded">Learn More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <p>No services available.</p>
                @endforelse
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



 