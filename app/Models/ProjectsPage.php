<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Lang;
use Spatie\Translatable\HasTranslations;

class ProjectsPage extends Model
{
    use HasTranslations;

    protected $fillable = [
        'title',
        'hero_kicker',
        'hero_title',
        'hero_lead',
        'proof_heading',
        'proof_body',
        'proof_items',
        'project_cards',
        'cta_heading',
        'cta_description',
        'cta_label',
    ];

    protected $casts = [
        'proof_items' => 'array',
        'project_cards' => 'array',
    ];

    public array $translatable = [
        'title',
        'hero_kicker',
        'hero_title',
        'hero_lead',
        'proof_heading',
        'proof_body',
        'cta_heading',
        'cta_description',
        'cta_label',
    ];

    public static function defaults(): array
    {
        $englishCards = Lang::get('projects.cards', [], 'en');
        $georgianCards = Lang::get('projects.cards', [], 'ka');

        $imageUrls = [
            'https://images.unsplash.com/photo-1450101499163-c8848c66ca85?q=80&w=1000&auto=format&fit=crop',
            'https://images.unsplash.com/photo-1560264280-88b68371db39?q=80&w=1000&auto=format&fit=crop',
            'https://images.unsplash.com/photo-1620825141088-a824daf6a46b?q=80&w=1000&auto=format&fit=crop',
        ];

        $projectCards = collect($englishCards)
            ->map(function (array $card, int $index) use ($georgianCards, $imageUrls): array {
                $georgianCard = $georgianCards[$index] ?? [];

                return [
                    'title' => [
                        'en' => $card['title'] ?? '',
                        'ka' => $georgianCard['title'] ?? '',
                    ],
                    'description' => [
                        'en' => $card['description'] ?? '',
                        'ka' => $georgianCard['description'] ?? '',
                    ],
                    'image_url' => $imageUrls[$index] ?? null,
                ];
            })
            ->all();

        return [
            'title' => [
                'en' => Lang::get('projects.title', [], 'en'),
                'ka' => Lang::get('projects.title', [], 'ka'),
            ],
            'hero_kicker' => [
                'en' => Lang::get('messages.projects', [], 'en'),
                'ka' => Lang::get('messages.projects', [], 'ka'),
            ],
            'hero_title' => [
                'en' => Lang::get('projects.heading', [], 'en'),
                'ka' => Lang::get('projects.heading', [], 'ka'),
            ],
            'hero_lead' => [
                'en' => Lang::get('projects.subheading', [], 'en'),
                'ka' => Lang::get('projects.subheading', [], 'ka'),
            ],
            'proof_heading' => [
                'en' => 'Delivery that matches complex regulated workflows.',
                'ka' => 'მიწოდება, რომელიც რთულ რეგულირებად პროცესებს ერგება.',
            ],
            'proof_body' => [
                'en' => 'We scope around operations, compliance, integrations, and rollout, not just interface screens.',
                'ka' => 'ვპროექტებთ ოპერაციების, შესაბამისობის, ინტეგრაციებისა და დანერგვის გათვალისწინებით და არა მხოლოდ ინტერფეისის ეკრანებით.',
            ],
            'proof_items' => [
                'en' => [
                    'Regulated operations',
                    'Local integrations',
                    'Laravel delivery',
                ],
                'ka' => [
                    'რეგულირებადი ოპერაციები',
                    'ლოკალური ინტეგრაციები',
                    'Laravel მიწოდება',
                ],
            ],
            'project_cards' => $projectCards,
            'cta_heading' => [
                'en' => Lang::get('projects.cta_heading', [], 'en'),
                'ka' => Lang::get('projects.cta_heading', [], 'ka'),
            ],
            'cta_description' => [
                'en' => Lang::get('projects.cta_description', [], 'en'),
                'ka' => Lang::get('projects.cta_description', [], 'ka'),
            ],
            'cta_label' => [
                'en' => Lang::get('projects.cta', [], 'en'),
                'ka' => Lang::get('projects.cta', [], 'ka'),
            ],
        ];
    }

    public static function singleton(): self
    {
        return static::query()->first() ?? static::create(static::defaults());
    }

    public function cardsForLocale(string $locale, array $defaults = []): array
    {
        $cards = collect($this->project_cards ?? [])
            ->map(fn (array $card) => $this->mapCard($card, $locale))
            ->filter()
            ->values()
            ->all();

        if (! empty($cards)) {
            return $cards;
        }

        return collect(Arr::get($defaults, 'project_cards', []))
            ->map(fn (array $card) => $this->mapCard($card, $locale))
            ->filter()
            ->values()
            ->all();
    }

    protected function mapCard(array $card, string $locale): ?array
    {
        $title = $this->resolveLocalizedValue($card['title'] ?? null, $locale);
        $description = $this->resolveLocalizedValue($card['description'] ?? null, $locale);

        if (! $title && ! $description) {
            return null;
        }

        return [
            'title' => $title ?? '',
            'description' => $description ?? '',
            'image_url' => $card['image_url'] ?? null,
            'image_path' => $card['image_path'] ?? null,
        ];
    }

    protected function resolveLocalizedValue(mixed $value, string $locale): ?string
    {
        if (is_array($value)) {
            return $value[$locale] ?? $value['en'] ?? (is_scalar(reset($value)) ? (string) reset($value) : null);
        }

        return filled($value) ? (string) $value : null;
    }
}
