<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;


class PostsController extends Controller
{
    public function create()
    {
        if (! auth()->check())
        {
            abort(401, 'Debes estar logueado para poder postear');
        }
        return view('posts.create');
    }
    
    public function delete($id)
    {
        if (! auth()->check())
        {
            abort(401, 'Debes estar logueado para poder eliminar un post');
        }
        
        $post = Post::findOrFail($id);
        
        if (auth()->user()->id !== $post->author_id)
        {
            abort(403, 'No puedes eliminar un post que no te pertenece');
        }
        
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
        if (! auth()->check())
        {
            abort(401, 'Debes estar logueado para poder postear');
        }
        
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
            
            if (auth()->user()->id !== $post->author_id)
            {
                abort(403, 'No puedes modificar un post que no te pertenece');
            }
            
            $post->title = $data['title'];
            $post->body = $data['body'];
            $post->save();
        }
        
        return redirect(route('posts.view', ['id' => $post->id]));
    }
    
    public function update($id)
    {
        $post = Post::findOrFail($id);
            
        if (auth()->user()->id !== $post->author_id)
        {
            abort(403, 'No puedes modificar un post que no te pertenece');
        }
        
        return view('posts.create', ['post' => $post]);
    }
    
    public function view($id)
    {
        $post = Post::findOrFail($id);
        
        return view('posts.view', ['post' => $post]);
    }
}
