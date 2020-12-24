<?php

namespace App\View\Components;

use Illuminate\View\Component;

class CommentForm extends Component
{
    public $action;
    public $method;
    public $comment;
    
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($action = '', $method = 'POST', $comment = NULL)
    {
        $this->action = $action;
        $this->method = $method;
        $this->comment = $comment;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.comment-form');
    }
}
