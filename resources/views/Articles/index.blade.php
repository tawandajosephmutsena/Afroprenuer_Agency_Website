@extends('layouts.base')

<body class="bg-violet-100 dark:bg-gray-900">
<x-nav-menu />



    <div>

        <div class="relative isolate overflow-hidden bg-violet-100 dark:bg-gray-900 py-16 sm:py-24 lg:py-32 mx-auto">
            <div class="relative isolate overflow-hidden px-80 mx-auto">
              <div class="mx-auto flex justify-center items-center">
                <div class="text-center">
                  <h2 class="text-3xl font-bold tracking-relaxed text-gray-800 dark:text-yellow-50 sm:text-4xl">Stay Ahead with Expert Insights</h2>
                  <p class="mt-4 text-lg leading-8 text-gray-800 dark:text-gray-300">Our articles page is your go-to resource for insights into web development, branding, marketing strategies, and automation trends. Designed to empower business leaders, our content helps you make informed decisions and stay at the forefront of the digital landscape.</p>
                </div>
              </div>
            </div>
            <div class="absolute left-1/2 top-0 -z-10 -translate-x-1/2 blur-3xl xl:-top-6" aria-hidden="true">
              <div class="aspect-[1155/678] w-[72.1875rem] bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-30" style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"></div>
            </div>
          </div>



    <main class="container mx-auto py-12 px-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse ($articles as $article)
                <a href="{{ route('articles.show', $article->slug) }}"
                   class="block bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden transition-transform transform hover:scale-105">
                    <div class="w-full h-56 bg-gray-100 overflow-hidden">
                        @if ($article->featuredImage)
                            <img src="{{ $article->featuredImage->url }}"
                                 alt="{{ $article->title }}"
                                 class="w-full h-full object-cover">
                        @endif
                    </div>
                    <div class="p-6">
                        <h3 class="text-2xl font-semibold text-gray-900 dark:text-gray-100 mb-2">{{ $article->title }}</h3>
                        <p class="text-gray-600 dark:text-gray-200 text-sm mb-4">{{ Str::limit($article->excerpt, 100) }}</p>
                        <div class="flex justify-between items-center text-gray-500 dark:text-yellow-600 text-xs">
                            <span>{{ $article->published_at->format('M d, Y') }}</span>
                            <span>{{ $article->category?->name ?? 'Uncategorized' }}</span>
                        </div>
                    </div>
                </a>
            @empty
                <div class="col-span-1 sm:col-span-2 lg:col-span-3 text-center py-12 bg-white dark:bg-gray-800 rounded-lg shadow-md">
                    <p class="text-xl text-gray-600 dark:text-gray-100">No articles available.</p>
                </div>
            @endforelse
        </div>

        @if ($articles->hasPages())
            <div class="mt-12">
                {{ $articles->links() }}
            </div>
        @endif
    </main>





