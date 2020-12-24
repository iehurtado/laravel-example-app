<?php

namespace App\View\Components;

use Illuminate\View\Component;

class PostForm extends Component
{
    public $action = '';
    public $method = 'POST';
    public $post;
    
    /**
     * Create a new component instance.
     * 
     * @param string $method
     * @param string $action
     * @param App\Models\Post $post
     *
     * @return void
     */
    public function __construct($action = '', $method = 'POST', $post = NULL)
    {
        $this->action = $action;
        $this->method = $method;
        $this->post = $post;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.post-form');
    }
}
