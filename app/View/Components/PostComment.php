<?php

namespace App\View\Components;

use Illuminate\View\Component;

class PostComment extends Component
{
    public $comment;
    public $edit;
    
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($comment, $edit = false)
    {
        $this->comment = $comment;
        $this->edit = $edit;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.post-comment');
    }
}
