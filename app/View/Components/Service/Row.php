<?php

namespace App\View\Components\Service;

use Closure;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Row extends Component
{
    public string $title;
    public string $description;
    public ?string $image;
    public string $imageAlt;
    public string $fullDescription;
    public bool $reversed;
    public string $slug;
    public array $problems;
    public int $index;
    public string $cueStyle;
    public string $cueLabel;
    public array $cueValues;
    public string $problemsHeading;
    public string $ctaLabel;
    public string $backToTopLabel;
    public string $readMoreLabel;
    public string $showLessLabel;

    public function __construct(
        string $title = '',
        string $description = '',
        ?string $image = null,
        string $imageAlt = '',
        Htmlable|string|null $fullDescription = '',
        bool $reversed = false,
        string $slug = '',
        array $problems = [],
        int $index = 0,
        string $cueStyle = 'bubbles',
        string $cueLabel = '',
        array $cueValues = [],
        string $problemsHeading = '',
        string $ctaLabel = '',
        string $backToTopLabel = '',
        string $readMoreLabel = '',
        string $showLessLabel = ''
    ) {
        $this->title = $title;
        $this->description = $description;
        $this->image = $image;
        $this->imageAlt = $imageAlt;
        $this->fullDescription = $fullDescription instanceof Htmlable
            ? trim($fullDescription->toHtml())
            : trim((string) $fullDescription);
        $this->reversed = $reversed;
        $this->slug = $slug;
        $this->problems = collect($problems)
            ->filter(fn ($problem) => filled($problem))
            ->map(fn ($problem) => trim((string) $problem))
            ->values()
            ->all();
        $this->index = max(0, $index);
        $this->cueStyle = in_array($cueStyle, ['bubbles', 'bars', 'dots'], true)
            ? $cueStyle
            : 'bubbles';
        $this->cueLabel = trim($cueLabel);
        $this->cueValues = collect($cueValues)
            ->filter(fn ($value) => is_numeric($value))
            ->map(fn ($value) => (int) $value)
            ->values()
            ->all();
        $this->problemsHeading = trim($problemsHeading);
        $this->ctaLabel = trim($ctaLabel);
        $this->backToTopLabel = trim($backToTopLabel);
        $this->readMoreLabel = trim($readMoreLabel);
        $this->showLessLabel = trim($showLessLabel);
    }

    public function render(): View|Closure|string
    {
        return view('components.service.row');
    }
}
