@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            <h1>{{ $post->title }}</h1>
            <h5><i>Escrito por </i>{{ $post->author->name }}<i> el día </i>{{ $post->created_at->format('d/m/Y') }}</h5>
        </div>
        @auth
            @if ($post->author_id == Auth::user()->id)
                <div class="col-auto ml-auto">
                    <a href="{{ route('posts.update', $post) }}" class="btn btn-primary" role="button">Modificar</a>
                    <form class="d-inline" action="{{ route('posts.delete', $post) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                </div>
            @endif
        @endauth
    </div>
    <div class="row">
        <div class="col">
            @foreach($post->paragraphs as $paragraph)
            <p>{{ $paragraph }}</p>
            @endforeach
        </div>
    </div>
</div>
@endsection