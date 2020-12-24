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
    
    
    public function destroy($post)
    {
        $model = Post::findOrFail($post);
        
        $this->authorize('delete', $model);
        
        $model->delete();
        
        return redirect(route('posts.index'));
    }
    
    
    public function edit($post)
    {
        $model = Post::findOrFail($post);
            
        $this->authorize('update', $model);
        
        return view('posts.edit', ['post' => $model]);
    }
    
    
    public function index() 
    {
        $models = Post::query()
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('posts.index', ['posts' => $models]);
    }
    
    public function show($post)
    {
        $model = Post::findOrFail($post);
        
        return view('posts.show', ['post' => $model]);
    }
    
    
    public function store(Request $request)
    {
        $this->authorize('create', Post::class);
        
        $data = $this->validatePost($request);
        $model = Post::create(array_merge($data, ['author_id' => auth()->user()->id]));
        
        return redirect(route('posts.show', $model));
    }
    
    public function update(Request $request, $post)
    {
        $model = Post::findOrFail($post);
            
        $this->authorize('update', $model);
        $data = $this->validatePost($request);

        $model->title = $data['title'];
        $model->body = $data['body'];
        
        $model->save();
        
        return redirect(route('posts.show', $model));
    }
    
    
    protected function validatePost(Request $request)
    {
        return $request->validate([
            'title' => 'required|max:255',
            'body' => 'required',
        ]);
    }
}
