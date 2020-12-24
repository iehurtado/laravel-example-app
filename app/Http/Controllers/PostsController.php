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
        return view('posts.create');
    }
    
    public function delete($id)
    {
        $post = Post::findOrFail($id);
        
        Gate::authorize('delete-post', $post);
        
        $post->delete();
        
        return redirect(route('posts.index'));
    }
    
    public function index() 
    {
        $posts = Post::query()
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('posts.index', ['posts' => $posts]);
    }
    
    public function store(Request $request, $id = null)
    {
        $data = $request->validate([
            'title' => 'required|max:255',
            'body' => 'required',
        ]);
        
        $post = null;
        if ($id === null)
        {
            $post = Post::create(array_merge($data, ['author_id' => auth()->user()->id]));
        }
        else
        {
            $post = Post::findOrFail($id);
            
            Gate::authorize('update-post', $post);
            
            $post->title = $data['title'];
            $post->body = $data['body'];
            $post->save();
        }
        
        return redirect(route('posts.view', ['id' => $post->id]));
    }
    
    public function update($id)
    {
        $post = Post::findOrFail($id);
            
        Gate::authorize('update-post', $post);
        
        return view('posts.create', ['post' => $post]);
    }
    
    public function view($id)
    {
        $post = Post::findOrFail($id);
        
        return view('posts.view', ['post' => $post]);
    }
}
