@extends('layouts.app')
@section('content')
<div class="container">
    <h1>Editar Post</h1>
    <x-post-form :action="route('posts.update', $post)" method="PUT" :post="$post"></x-post-form>
</div>
@endsection