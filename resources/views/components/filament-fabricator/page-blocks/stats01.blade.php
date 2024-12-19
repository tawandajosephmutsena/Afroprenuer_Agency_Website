@aware(['page'])


<section class="bg-white dark:bg-gray-950">
    <div class="max-w-screen-xl px-4 py-8 mx-auto text-center lg:py-16 lg:px-6">
        <dl class="grid max-w-screen-md gap-8 mx-auto text-gray-900 sm:grid-cols-3 dark:text-white">
            <div class="flex flex-col items-center justify-center">
                <dt class="mb-2 text-3xl md:text-4xl font-extrabold">{{ $total }}</dt>
                <dd class="font-light text-gray-500 dark:text-gray-400">{{ $title }}</dd>
            </div>
            <div class="flex flex-col items-center justify-center">
                <dt class="mb-2 text-3xl md:text-4xl font-extrabold">{{ $total2 }}</dt>
                <dd class="font-light text-gray-500 dark:text-gray-400">{{ $title2 }}</dd>
            </div>
            <div class="flex flex-col items-center justify-center">
                <dt class="mb-2 text-3xl md:text-4xl font-extrabold">{{ $total3 }}</dt>
                <dd class="font-light text-gray-500 dark:text-gray-400">{{ $title3 }}</dd>
            </div>
        </dl>
    </div>
  </section>

