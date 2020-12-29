<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Iehurtado\Comments\Models\Comment;
use App\Models\Post;

class CommentsController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Post $post)
    {
        $this->authorize('create', Comment::class);
        
        $data = $this->validateComment($request);
        
        $comment = new Comment();
        $comment->fill($data);
        $comment->author()->associate(Auth::user());
        $post->comments()->save($comment);
        
        return redirect(route('comments.show', ['comment' => $comment]));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        $this->authorize('view', $comment);
        
        return redirect(route('posts.show', $comment->commentable));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        $this->authorize('update', $comment);
        
        return view('posts.show', ['post' => $comment->commentable, 'comment' => $comment]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post, Comment $comment)
    {
        $this->authorize('update', $comment);
        
        $data = $this->validateComment($request);
        $comment->content = $data['content'];
        $comment->save();
        
        return redirect(route('comments.show', $comment));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);
        
        $comment->delete();
        return redirect(route('posts.show', $comment->commentable));
    }
    
    protected function validateComment(Request $request)
    {
        return $request->validate([
            'content' => 'required|max:1000'
        ]);
    }
}
