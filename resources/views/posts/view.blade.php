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
                    <a href="{{ route('posts.update', $post) }}" class="btn btn-primary" role="button">Modificar</a>
                @endcan
                @can('delete', $post)
                    <form class="d-inline" action="{{ route('posts.delete', $post) }}" method="POST">
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
</div>
@endsection