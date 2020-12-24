<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\Post;


class PostsController extends Controller
{
    public function __construct() {
        $this->middleware('auth', ['except' => ['index', 'view']]);
    }
    
    
    public function create()
    {
        $this->authorize('create', Post::class);
        return view('posts.create');
    }
    
    
    public function delete($id)
    {
        $post = Post::findOrFail($id);
        
        $this->authorize('delete', $post);
        
        $post->delete();
        
        return redirect(route('posts.index'));
    }
    
    
    public function edit(Request $request, $id)
    {
        $post = Post::findOrFail($id);
            
        $this->authorize('update', $post);
        $data = $this->validatePost($request);

        $post->title = $data['title'];
        $post->body = $data['body'];
        
        $post->save();
        
        return redirect(route('posts.view', ['id' => $post->id]));
    }
    
    
    public function index() 
    {
        $posts = Post::query()
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('posts.index', ['posts' => $posts]);
    }
    
    
    public function store(Request $request)
    {
        $this->authorize('create', Post::class);
        
        $data = $this->validatePost($request);
        $post = Post::create(array_merge($data, ['author_id' => auth()->user()->id]));
        
        return redirect(route('posts.view', ['id' => $post->id]));
    }
    
    
    public function update($id)
    {
        $post = Post::findOrFail($id);
            
        $this->authorize('update', $post);
        
        return view('posts.update', ['post' => $post]);
    }
    
    
    public function view($id)
    {
        $post = Post::findOrFail($id);
        
        return view('posts.view', ['post' => $post]);
    }
    
    
    protected function validatePost(Request $request)
    {
        return $request->validate([
            'title' => 'required|max:255',
            'body' => 'required',
        ]);
    }
}
