<div class="container">
    <div class="row">
        <div class="col">
            <h3>{{ $post->title }}</h3>
            <h6><em>{{ $post->author->name }}</em></h6>
        </div>
        <div class="col-auto ml-auto">
            {{ $post->created_at->format('d/m/Y') }}
        </div>
    </div>
    <div class="row">
        <div class="col">
            <p>{{ $post->abstract }}</p>
            <p class="text-right"><a href="{{ route('posts.view', $post) }}">Ver más</a></p>
        </div>
    </div>
</div>