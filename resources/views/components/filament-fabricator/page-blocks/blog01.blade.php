@aware(['page'])

@props([
'title',
'description',
'articles' => collect(),
])



<div>
    <h1>Debug Info</h1>
    <p>Articles Count: {{ $articles->count() }}</p>
    @foreach ($articles as $article)
        <div>
            <h2>{{ $article->title }}</h2>
            <p>{{ $article->id }}</p>
        </div>
    @endforeach
</div>

