<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Btn extends Component
{
    
    public $style;

    public function __construct($style = 'secondary')
    {
        $this->style     = $style;
    }

    
    public function render(): View|Closure|string
    {
        return view('components.btn');
    }
}
