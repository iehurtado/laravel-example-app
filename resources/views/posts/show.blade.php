@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            <h1>{{ $post->title }}</h1>
            <h5><i>Escrito por </i>{{ $post->author->name }}<i> el día </i>{{ $post->created_at->format('d/m/Y') }}</h5>
        </div>
        @canany(['update', 'delete'], $post)
            <div class="col-auto ml-auto">
                @can('update', $post)
                    <a href="{{ route('posts.edit', $post) }}" class="btn btn-primary" role="button">Modificar</a>
                @endcan
                @can('delete', $post)
                    <form class="d-inline" action="{{ route('posts.destroy', $post) }}" method="POST">
                        @method('DELETE')
                        @csrf
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                @endcan
            </div>
        @endcanany
    </div>
    <div class="row">
        <div class="col">
            @foreach($post->paragraphs as $paragraph)
            <p>{{ $paragraph }}</p>
            @endforeach
        </div>
    </div>
    <hr />
    @empty($comment)
    <div class="row">
        <div class="col">
            <x-comment-form :action="route('posts.comments.store', $post)"></x-comment-form>
        </div>
    </div>
    @endempty
    <hr />
    <div class="row">
        <div class="col">
            @forelse ($post->comments as $x)
            <div class="py-2">
                <x-post-comment :comment="$x" :edit="isset($comment) && $x->is($comment)"></x-post-comment>
            </div>
            @empty
            <div>No hay comentarios aún</div>
            @endforelse
        </div>
    </div>
</div>
@endsection