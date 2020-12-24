@extends('layouts.app')
@section('content')
<div class="container">
    <h1>Nuevo Post</h1>
    <x-post-form :action="route('posts.store')" method="POST"></x-post-form>
</div>
@endsection