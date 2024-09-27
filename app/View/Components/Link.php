<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Link extends Component
{
    public $type;
    public $href;

    public function __construct($type = 'default', $href = "#")
    {
        $this->type = $type;
        $this->href = $href;
    }

    public function render(): View|Closure|string
    {
        return view('components.link');
    }
}
