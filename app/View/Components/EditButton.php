<?php

namespace App\View\Components;

use Illuminate\View\Component;

class EditButton extends Component
{
    public $route;
    public $text;
    public $size;
    public $variant;

    public function __construct($route = '#', $text = 'Edit', $size = 'md', $variant = 'primary')
    {
        $this->route = $route;
        $this->text = $text;
        $this->size = $size;
        $this->variant = $variant;
    }

    public function render()
    {
        return view('components.edit-button');
    }
}