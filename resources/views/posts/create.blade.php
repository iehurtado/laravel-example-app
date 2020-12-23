@extends('layouts.app')
@section('content')
<div class="container">
    <form action="{{ route('posts.store', $post ?? null) }}" method="POST">
        @isset($post)
            @method('PUT')
        @endisset
        @csrf
        <div class="form-row">
            <label for="title">Título</label>
            <input type="text" id="title" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $post->title ?? null) }}" />
            @error('title')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-row">
            <label for="body">Contenido</label>
            <textarea type="text" id="body" name="body" class="form-control @error('body') is-invalid @enderror">{{ old('body', $post->body ?? null) }}</textarea>
            @error('body')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-row">
            <button type="submit" class="btn btn-primary">Publicar</button>
        </div>
    </form>
</div>
@endsection