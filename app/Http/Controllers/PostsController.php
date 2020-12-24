<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;


class PostsController extends Controller
{
    public function __construct() {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }
    
    
    public function create()
    {
        $this->authorize('create', Post::class);
        return view('posts.create');
    }
    
    
    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
        
        $post->delete();
        
        return redirect(route('posts.index'));
    }
    
    
    public function edit(Post $post)
    {            
        $this->authorize('update', $post);
        
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
    
    
    public function store(Request $request)
    {
        $this->authorize('create', Post::class);
        
        $data = $this->validatePost($request);
        $post = Post::create(array_merge($data, ['author_id' => auth()->user()->id]));
        
        return redirect(route('posts.show', $post));
    }
    
    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);
        
        $data = $this->validatePost($request);

        $post->title = $data['title'];
        $post->body = $data['body'];
        
        $post->save();
        
        return redirect(route('posts.show', $post));
    }
    
    
    protected function validatePost(Request $request)
    {
        return $request->validate([
            'title' => 'required|max:255',
            'body' => 'required',
        ]);
    }
}
