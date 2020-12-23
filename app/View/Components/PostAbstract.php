<?php

namespace App\View\Components;

use Illuminate\View\Component;

class PostAbstract extends Component
{
    /**
     * @var \App\Models\Post
     */
    public $post;
    
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($post)
    {
        $this->post = $post;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.post-abstract');
    }
}
