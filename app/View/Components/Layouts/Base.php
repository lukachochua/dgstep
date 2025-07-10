<?php

namespace App\View\Components\Layouts;

use Illuminate\View\Component;
use Closure;
use Illuminate\Contracts\View\View;

class Base extends Component
{
    public function __construct()
    {
        //
    }

    public function render(): View|Closure|string
    {
        return view('layouts.base');
    }
}
