@extends('layouts.base')

<body class="bg-violet-100 dark:bg-gray-900">
    <x-nav-menu />

    <!-- Article Header -->
    <header class="relative isolate overflow-hidden bg-violet-100 dark:bg-gray-900 py-24 mb-8">
        <div class="mx-auto max-w-4xl px-6">
            <div class="flex flex-col items-center text-center">
                <div class="space-y-4">
                    @if($article->category)
                    <div class="inline-block px-4 py-1 bg-yellow-600/10 text-yellow-400 text-sm">
                        {{ $article->category->name }}
                    </div>
                    @endif
                    <h1 class="text-4xl font-bold tracking-tight text-grey-900 dark:text-gray-100 sm:text-5xl">{{ $article->title }}</h1>
                    <div class="flex items-center justify-center space-x-4 text-gray-700 dark:text-gray-300">
                        <span>{{ $article->reading_time }} read</span>
                        <span>•</span>
                        <span>{{ $article->published_at->format('F j, Y') }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="absolute left-1/2 top-0 -z-10 -translate-x-1/2 blur-3xl xl:-top-6" aria-hidden="true">
            <div class="aspect-[1155/678] w-[72.1875rem] bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-20"
                 style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)">
            </div>
        </div>
    </header>
    <div class="bg-violet-100 dark:bg-gray-800">
        <!-- Navigation Bar -->
        <nav class="bg-violet-100 dark:bg-gray-900 p-12 shadow-sm py-4 sticky top-0 z-50">
            <div class="container mx-auto px-6">
                <a href="{{ route('articles.index') }}" class="text-gray-600 dark:text-gray-100 hover:text-byellow-600 flex items-center space-x-2 transition-colors duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10.707 3.293a1 1 0 010 1.414L6.414 9H17a1 1 0 110 2H6.414l4.293 4.293a1 1 0 11-1.414 1.414l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                    <span>Back to Articles</span>
                </a>
            </div>
        </nav>
    </div>

    <!-- Featured Image -->
    @if($article->featuredImage)
    <div class="container mx-auto px-6 mb-12 bg-violet-100 dark:bg-gray-900">
        <div class="max-w-6xl mx-auto">
            <img src="{{ $article->featuredImage->url }}"
                 alt="{{ $article->title }}"
                 class="w-full h-auto rounded-xl shadow-lg object-cover aspect-video">
        </div>
    </div>
    @endif

    <!-- Article Content -->
    <main class="container mx-auto px-6 py-12">
        <div class="max-w-4xl mx-auto  bg-gray-100 dark:bg-gray-800 p-16">
            @if($article->excerpt)
            <div class="text-xl text-gray-600 dark:text-gray-100 mb-12 leading-relaxed font-light">
                {{ $article->excerpt }}
            </div>
            @endif



            <!-- Main Content -->
            <div class="prose prose-lg max-w-none mb-12 text-gray-600 dark:text-gray-100">
                {!! $article->content !!}
            </div>

            <!-- Tags -->
            @if($article->tags->count() > 0)
            <div class="border-t border-gray-100 dark:border-gray-700 pt-8">
                <div class="flex flex-wrap gap-2">
                    @foreach($article->tags as $tag)
                    <span class="bg-gray-300 dark:bg-gray-900 text-gray-700 dark:text-gray-200 px-4 py-2 text-sm transition-colors duration-200">
                        #{{ $tag->name }}
                    </span>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
           <!-- Author -->
           <div class="flex items-center space-x-4 mb-12 p-6 bg-gray-50 dark:bg-gray-800 rounded-lg border border-gray-100 dark:border-gray-700 max-w-4xl mx-auto">
            <div class="bg-gray-100 rounded-full w-14 h-14 flex items-center justify-center">
                <span class="text-xl font-bold text-bg-gray-800 dark:bg-gray-200">{{ substr($article->author->name, 0, 1) }}</span>
            </div>
            <div>
                <div class="font-medium text-gray-900 dark:text-gray-100">{{ $article->author->name }}</div>
                <div class="text-sm text-gray-500 dark:text-gray-200">Author</div>
            </div>
        </div>
    </main>

    <!-- Related Articles -->
  <!-- Related Articles Section -->
  @if($relatedArticles->count() > 0)
  <section class="bg-gray-100 dark:bg-gray-900 py-16">
      <div class="container mx-auto px-6">
          <div class="max-w-7xl mx-auto">
              <h2 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-2">Related Articles</h2>
              <p class="text-gray-600 dark:text-gray-100 mb-8">Continue reading more articles in {{ $article->category->name }}</p>

              <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                  @foreach($relatedArticles as $related)
                  <article class="bg-violet-100 dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden transition-all hover:shadow-lg">
                      @if($related->featuredImage)
                      <div class="aspect-video overflow-hidden">
                          <img
                              src="{{ $related->featuredImage->url }}"
                              alt="{{ $related->title }}"
                              class="w-full h-full object-cover transition-transform hover:scale-105"
                          >
                      </div>
                      @endif
                      <div class="p-6">
                          <!-- Category -->
                          @if($related->category)
                          <span class="text-yellow-600 dark:text-yellow-500 text-sm font-medium">
                              {{ $related->category->name }}
                          </span>
                          @endif

                          <!-- Title -->
                          <h3 class="mt-2 text-xl font-semibold text-gray-900 dark:text-gray-100 group-hover:text-yellowe-600 transition-colors">
                              <a href="{{ route('articles.show', $related->slug) }}" class="hover:text-yellow-600">
                                  {{ $related->title }}
                              </a>
                          </h3>

                          <!-- Excerpt -->
                          <p class="mt-3 text-gray-600 dark:text-gray-200 text-sm line-clamp-2">
                              {{ Str::limit($related->excerpt, 150) }}
                          </p>

                          <!-- Footer -->
                          <div class="mt-4 flex items-center justify-between">
                              <div class="flex items-center space-x-2 text-sm text-gray-500 dark:text-gray-200">
                                  <span>{{ $related->published_at->format('M j, Y') }}</span>
                                  <span>•</span>
                                  <span>{{ $related->reading_time }}</span>
                              </div>

                              <a href="{{ route('articles.show', $related->slug) }}"
                                 class="text-yellow-600 hover:text-yellow-500 text-sm font-medium">
                                  Read more →
                              </a>
                          </div>
                      </div>
                  </article>
                  @endforeach
              </div>

              <!-- View All Articles Link -->
              <div class="text-center mt-12">
                  <a href="{{ route('articles.index') }}"
                     class="inline-flex items-center space-x-2 bg-gray-600 text-white px-6 py-3 rounded-lg hover:bg-yellow-600 transition-colors">
                      <span>View All Articles</span>
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                          <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                      </svg>
                  </a>
              </div>
          </div>
      </div>
  </section>
  @endif

    <!-- Newsletter Section -->
    <section class="bg-gray-900 py-24">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="mx-auto grid max-w-2xl grid-cols-1 gap-x-8 gap-y-16 lg:max-w-none lg:grid-cols-2">
                <div class="max-w-xl lg:max-w-lg">
                    <h2 class="text-3xl font-bold tracking-tight text-white sm:text-4xl">Subscribe to our newsletter</h2>
                    <p class="mt-4 text-lg leading-8 text-gray-300">Stay updated with our latest articles, news, and insights delivered directly to your inbox.</p>
                    <div class="mt-6 flex max-w-md gap-x-4">
                        <label for="email-address" class="sr-only">Email address</label>
                        <input id="email-address"
                               name="email"
                               type="email"
                               required
                               class="min-w-0 flex-auto rounded-md border-0 bg-white/5 px-3.5 py-2 text-white shadow-sm ring-1 ring-inset ring-white/10 focus:ring-2 focus:ring-inset focus:ring-blue-500 sm:text-sm sm:leading-6"
                               placeholder="Enter your email">
                        <button type="submit"
                                class="flex-none rounded-md bg-blue-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-500 transition-colors duration-200">
                            Subscribe
                        </button>
                    </div>
                </div>
                <dl class="grid grid-cols-1 gap-x-8 gap-y-10 sm:grid-cols-2 lg:pt-2">
                    <div class="flex flex-col items-start">
                        <div class="rounded-md bg-white/5 p-2 ring-1 ring-white/10">
                            <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                            </svg>
                        </div>
                        <dt class="mt-4 font-semibold text-white">Weekly articles</dt>
                        <dd class="mt-2 leading-7 text-gray-400">Get fresh insights and articles delivered to your inbox every week.</dd>
                    </div>
                    <div class="flex flex-col items-start">
                        <div class="rounded-md bg-white/5 p-2 ring-1 ring-white/10">
                            <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <dt class="mt-4 font-semibold text-white">No spam</dt>
                        <dd class="mt-2 leading-7 text-gray-400">We respect your inbox. Unsubscribe at any time.</dd>
                    </div>
                </dl>
            </div>
        </div>
    </section>

   