<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DeleteButton extends Component
{
    public $action;
    public $text;
    public $size;
    public $variant;
    public $confirmMessage;

    public function __construct($action = '#', $text = 'Delete', $size = 'md', $variant = 'danger', $confirmMessage = 'Are you sure?')
    {
        $this->action = $action;
        $this->text = $text;
        $this->size = $size;
        $this->variant = $variant;
        $this->confirmMessage = $confirmMessage;
    }

    public function render(): View|Closure|string
    {
        return view('components.delete-button');
    }
}