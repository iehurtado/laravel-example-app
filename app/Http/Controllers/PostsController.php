<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Http\Requests\StorePostRequest;


class PostsController extends Controller
{
    public function __construct() {
        $this->middleware('auth', ['except' => ['index', 'show']]);
        $this->authorizeResource(Post::class, 'post');
    }
    
    
    public function create()
    {
        return view('posts.create');
    }
    
    
    public function destroy(Post $post)
    {
        $post->delete();
        
        return redirect(route('posts.index'));
    }
    
    
    public function edit(Post $post)
    {            
        return view('posts.edit', ['post' => $post]);
    }
    
    
    public function index() 
    {
        $models = Post::query()
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('posts.index', ['posts' => $models]);
    }
    
    public function show(Post $post)
    {
        return view('posts.show', ['post' => $post]);
    }
    
    
    public function store(StorePostRequest $request)
    {
        $data = $request->validate();
        $post = Post::create(array_merge($data, ['author_id' => auth()->user()->id]));
        
        return redirect(route('posts.show', $post));
    }
    
    public function update(StorePostRequest $request, Post $post)
    {
        $data = $request->validate();

        $post->title = $data['title'];
        $post->body = $data['body'];
        
        $post->save();
        
        return redirect(route('posts.show', $post));
    }
}
