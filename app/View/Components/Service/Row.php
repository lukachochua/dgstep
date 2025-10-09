<?php

namespace App\View\Components\Service;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Row extends Component
{
    public string $title;
    public string $description;
    public string $cueStyle;
    public string $cueLabel;
    public array $cueValues;

    public function __construct(
        string $title = '',
        string $description = '',
        string $cueStyle = 'bubbles',
        string $cueLabel = '',
        array $cueValues = []
    ) {
        $this->title = $title;
        $this->description = $description;
        $this->cueStyle = $cueStyle;
        $this->cueLabel = $cueLabel;
        $this->cueValues = $cueValues;
    }

    public function render(): View|Closure|string
    {
        return view('components.service.row');
    }
}
