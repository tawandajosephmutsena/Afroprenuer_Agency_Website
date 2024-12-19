@aware(['page'])

@props([
'title',
'content',

])

<section class="bg-white dark:bg-gradient-to-r from-gray-950 from-10% via-cyan-950 via-25%  to-gray-900 to-40% -z-550">
    <div class="py-8 px-4 mx-auto max-w-screen-xl text-center lg:py-16">
        <h2 class="mb-4 font-extrabold tracking-tight leading-none text-gray-900 md:text-3xl lg:text-4xl dark:text-white">{{ $title }}</h2>
        <p class="mb-8 text-lg font-normal text-gray-900 lg:text-xl sm:px-16 lg:px-48 dark:text-gray-400"> {{ $content }}</p>
        <div class="flex flex-col space-y-4 sm:flex-row sm:justify-center sm:space-y-0">
        </div>
    </div>

    </div>
</section>
