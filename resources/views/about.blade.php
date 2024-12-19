@extends('layouts.base')
 <x-nav-menu />
<body class="bg-violet-100 dark:bg-gray-900">


    <div class="relative isolate overflow-hidden bg-gray-900 py-24 sm:py-32">
        <img src="{{ asset('storage/media/mhondoro-inc-hero1.jpg') }}" alt="social-cover" class="absolute inset-0 -z-10 h-full w-full object-cover object-right md:object-center">
 <!-- Top Background Animation -->
    <div class="absolute inset-x-0 -top-40 -z-10 transform-gpu overflow-hidden blur-3xl sm:-top-80 animate-gradient-move" aria-hidden="true">
        <div class="relative left-[calc(50%-11rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 rotate-[30deg] bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-30 sm:left-[calc(50%-30rem)] sm:w-[72.1875rem]" style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"></div>
    </div>

   
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="mx-auto max-w-2xl lg:mx-0">
                <h2 class="text-4xl font-bold tracking-tight text-white sm:text-6xl">Partner with Innovation.</h2>
                <h2 class="text-4xl font-bold tracking-tight text-white sm:text-6xl">Collaborate with Excellence.</h2>

                <p class="mt-6 text-lg leading-8 text-gray-300">At Mhondoro Inc., we are more than a digital agency – we are a hub for transformative partnerships and creative collaborations. Whether you are a client seeking exceptional solutions or a creative professional ready to push boundaries, let us build extraordinary together.</p>
            </div>
            <div class="mx-auto mt-10 max-w-2xl lg:mx-0 lg:max-w-none">
                <div class="grid grid-cols-1 gap-x-8 gap-y-6 text-base font-semibold leading-7 text-white sm:grid-cols-2 md:flex lg:gap-x-10">
                    <a href="#">Start Your Project Today <span aria-hidden="true">&rarr;</span></a>
                    <a href="#">Join Our Creatives <span aria-hidden="true">&rarr;</span></a>
                    <a href="#">Learn more <span aria-hidden="true">&rarr;</span></a>
                    <a href="#">Meet our leadership <span aria-hidden="true">&rarr;</span></a>
                </div>
               
            </div>
        </div>
    </div>

    <!-- Bottom Background Animation -->
    <div class="absolute inset-x-0 top-[calc(100%-13rem)] -z-10 transform-gpu overflow-hidden blur-3xl sm:top-[calc(100%-30rem)] animate-gradient-move" aria-hidden="true">
        <div class="relative left-[calc(50%+3rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-30 sm:left-[calc(50%+36rem)] sm:w-[72.1875rem]" style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"></div>
    </div>
</div>





    <div class="relative isolate overflow-hidden bg-violet-100 dark:bg-gray-900 px-6 py-24 sm:py-32 lg:overflow-visible lg:px-0">
        <div class="absolute inset-0 -z-10 overflow-hidden">

        </div>
        <div class="mx-auto grid max-w-2xl grid-cols-1 gap-x-8 gap-y-16 lg:mx-0 lg:max-w-none lg:grid-cols-2 lg:items-start lg:gap-y-10">
            <div class="lg:col-span-2 lg:col-start-1 lg:row-start-1 lg:mx-auto lg:grid lg:w-full lg:max-w-7xl lg:grid-cols-2 lg:gap-x-8 lg:px-8">

            </div>
            <div class="-ml-12 -mt-12 p-12 lg:sticky lg:top-4 lg:col-start-2 lg:row-span-2 lg:row-start-1 lg:overflow-hidden">
                <img class="w-[48rem] max-w-none  sm:w-[57rem]" src="{{ asset('storage/media/flying-laptop-mhondoro-inc.png') }}" alt="Mhondoro Inc Logos">
            </div>
            <div class="lg:col-span-2 lg:col-start-1 lg:row-start-2 lg:mx-auto lg:grid lg:w-full lg:max-w-7xl lg:grid-cols-2 lg:gap-x-8 lg:px-8">
                <div class="lg:pr-4">
                    <h1 class="mt-2 text-pretty text-4xl font-semibold tracking-tight text-gray-100 sm:text-5xl">A better workflow</h1>

                    <div class="max-w-xl text-base/7 text-gray-700 dark:text-gray-100 lg:max-w-lg">

                        <p>Mhondoro Inc is built on a mission to empower businesses with cutting-edge technology solutions. Our belief in collaboration fuels our success – we’re not just a service provider but a trusted partner committed to understanding your unique needs and delivering beyond expectations.</p>

                        <p class="mt-8">Our team combines expertise, creativity, and dedication to ensure that every project drives growth, enhances visibility, and fosters customer engagement. With a client-first approach, we prioritize lasting relationships that make you feel supported every step of the way</p>
                        <h2 class="mt-16 text-2xl font-bold tracking-tight text-gray-900 dark:text-gray-100">Partner with us, and let’s achieve extraordinary together.

                        </h2>
                    </div>
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
                        <img class="absolute left-0 top-0 w-[57rem] max-w-none rounded-md bg-white/5 ring-1 ring-white/10" src="{{ asset('storage/media/tasks-mhondoro-inc.jpg') }}" alt="Mhondoro Screenshot"> width="1824" height="1080">
                    </div>
                </div>
            </div>
        </div>



       