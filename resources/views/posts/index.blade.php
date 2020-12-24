@extends('layouts.app')
@section('content')
<div class="container">
    @can('create', App\Models\Post::class)
    <div class="row">
        <div class="col-auto ml-auto">
            <a href="{{ route('posts.create') }}" class="btn btn-success" role="button">Nuevo Post</a>
        </div>
    </div>
    @endcan
    @foreach($posts as $post)
    <div class="row">
        <x-post-abstract :post="$post"></x-post-abstract>
    </div>
        @if (! $loop->last)
        <hr />
        @endif
    @endforeach
</div>
@endsection