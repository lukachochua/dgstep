<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Lang;
use Spatie\Translatable\HasTranslations;

class AboutPage extends Model
{
    use HasTranslations;

    protected $fillable = [
        'title',
        'who_heading',
        'who_paragraph_1',
        'who_paragraph_2',
        'mission_heading',
        'mission_label',
        'mission_description',
        'vision_heading',
        'vision_label',
        'vision_description',
        'management_heading',
        'management_view_all',
        'management_collapse',
        'badges',
        'hero_image_url',
        'hero_image_alt',
        'hero_caption',
        'hero_status_label',
        'management_members',
    ];

    protected $casts = [
        'badges' => 'array',
        'management_members' => 'array',
    ];

    public array $translatable = [
        'title',
        'who_heading',
        'who_paragraph_1',
        'who_paragraph_2',
        'mission_heading',
        'mission_label',
        'mission_description',
        'vision_heading',
        'vision_label',
        'vision_description',
        'management_heading',
        'management_view_all',
        'management_collapse',
        'hero_image_alt',
        'hero_caption',
        'hero_status_label',
    ];

    public static function defaults(): array
    {
        return [
            'title' => [
                'en' => Lang::get('about.title', [], 'en'),
                'ka' => Lang::get('about.title', [], 'ka'),
            ],
            'who_heading' => [
                'en' => Lang::get('about.who_we_are.heading', [], 'en'),
                'ka' => Lang::get('about.who_we_are.heading', [], 'ka'),
            ],
            'who_paragraph_1' => [
                'en' => Lang::get('about.who_we_are.paragraph_1', [], 'en'),
                'ka' => Lang::get('about.who_we_are.paragraph_1', [], 'ka'),
            ],
            'who_paragraph_2' => [
                'en' => Lang::get('about.who_we_are.paragraph_2', [], 'en'),
                'ka' => Lang::get('about.who_we_are.paragraph_2', [], 'ka'),
            ],
            'mission_heading' => [
                'en' => Lang::get('about.mission.heading', [], 'en'),
                'ka' => Lang::get('about.mission.heading', [], 'ka'),
            ],
            'mission_label' => [
                'en' => Lang::get('about.mission.label', [], 'en'),
                'ka' => Lang::get('about.mission.label', [], 'ka'),
            ],
            'mission_description' => [
                'en' => Lang::get('about.mission.description', [], 'en'),
                'ka' => Lang::get('about.mission.description', [], 'ka'),
            ],
            'vision_heading' => [
                'en' => Lang::get('about.vision.heading', [], 'en'),
                'ka' => Lang::get('about.vision.heading', [], 'ka'),
            ],
            'vision_label' => [
                'en' => Lang::get('about.vision.label', [], 'en'),
                'ka' => Lang::get('about.vision.label', [], 'ka'),
            ],
            'vision_description' => [
                'en' => Lang::get('about.vision.description', [], 'en'),
                'ka' => Lang::get('about.vision.description', [], 'ka'),
            ],
            'management_heading' => [
                'en' => Lang::get('about.management.heading', [], 'en'),
                'ka' => Lang::get('about.management.heading', [], 'ka'),
            ],
            'management_view_all' => [
                'en' => Lang::get('about.management.view_all', [], 'en'),
                'ka' => Lang::get('about.management.view_all', [], 'ka'),
            ],
            'management_collapse' => [
                'en' => Lang::get('about.management.collapse', [], 'en'),
                'ka' => Lang::get('about.management.collapse', [], 'ka'),
            ],
            'badges' => [
                'en' => [
                    'Laravel 12.x',
                    'Tailwind & Alpine.js',
                    'SMB & Pawn Ops',
                ],
                'ka' => [
                    'Laravel 12.x',
                    'Tailwind და Alpine.js',
                    'SMB და ლომბარდ ოპერაციები',
                ],
            ],
            'hero_image_url' => 'https://images.unsplash.com/photo-1600880292203-757bb62b4baf?q=80&w=1200&auto=format&fit=crop',
            'hero_image_alt' => [
                'en' => 'Team working',
                'ka' => 'გუნდი მუშაობის პროცესში',
            ],
            'hero_caption' => [
                'en' => 'DGstep • SaaS for regulated services',
                'ka' => 'DGstep • SaaS რეგულირებადი სერვისებისთვის',
            ],
            'hero_status_label' => [
                'en' => 'Live',
                'ka' => 'აქტიური',
            ],
            'management_members' => [
                [
                    'name' => [
                        'en' => 'Sergo Matiashvili',
                        'ka' => 'სერგო მათიაშვილი',
                    ],
                    'role' => [
                        'en' => 'Founder & CEO',
                        'ka' => 'დამფუძნებელი და დირექტორი',
                    ],
                    'image_url' => 'https://images.unsplash.com/photo-1607746882042-944635dfe10e?ixid=1&w=300&h=300&fit=crop',
                ],
                [
                    'name' => [
                        'en' => 'Luka Chochua',
                        'ka' => 'ლუკა ჩოჩუა',
                    ],
                    'role' => [
                        'en' => 'Chief Technology Officer',
                        'ka' => 'ტექნოლოგიური დირექტორი',
                    ],
                    'image_url' => 'https://images.unsplash.com/photo-1522075469751-3a6694fb2f61?ixid=4&w=300&h=300&fit=crop',
                ],
                [
                    'name' => [
                        'en' => 'Mirian Tabatadze',
                        'ka' => 'მირიან ტაბატაძე',
                    ],
                    'role' => [
                        'en' => 'Marketing & Operations',
                        'ka' => 'მარკეტინგი და ოპერაციები',
                    ],
                    'image_url' => 'https://images.unsplash.com/photo-1607746882042-944635dfe10e?ixid=2&w=300&h=300&fit=crop',
                ],
                [
                    'name' => [
                        'en' => 'Lasha Endeladze',
                        'ka' => 'ლაშა ენდელაძე',
                    ],
                    'role' => [
                        'en' => 'Head of Compliance',
                        'ka' => 'კომპლაიანსის უფროსი',
                    ],
                    'image_url' => 'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?ixid=5&w=300&h=300&fit=crop',
                ],
                [
                    'name' => [
                        'en' => 'Giga Lapachi',
                        'ka' => 'გიგა ლაფაჩი',
                    ],
                    'role' => [
                        'en' => 'Project Manager',
                        'ka' => 'პროექტების მენეჯერი',
                    ],
                    'image_url' => 'https://images.unsplash.com/photo-1607746882042-944635dfe10e?ixid=3&w=300&h=300&fit=crop',
                ],
                [
                    'name' => [
                        'en' => 'Puchi Pachuria',
                        'ka' => 'პუჩი პაჭურია',
                    ],
                    'role' => [
                        'en' => 'Lead Software Engineer',
                        'ka' => 'წამყვანი პროგრამული ინჟინერი',
                    ],
                    'image_url' => 'https://images.unsplash.com/photo-1521737604893-d14cc237f11d?ixid=6&w=300&h=300&fit=crop',
                ],
            ],
        ];
    }

    public static function singleton(): self
    {
        return static::first() ?? static::create(static::defaults());
    }

    public function translated(string $attribute, string $locale, array $defaults = []): ?string
    {
        $value = $this->getTranslation($attribute, $locale, false);

        if (filled($value)) {
            return $value;
        }

        return $this->resolveLocalizedValue(Arr::get($defaults, $attribute), $locale);
    }

    public function badgesForLocale(string $locale, array $defaults = []): array
    {
        $badges = $this->badges ?? [];

        $resolved = $this->resolveLocalizedArray($badges, $locale);

        if ($resolved) {
            return $resolved;
        }

        $defaultBadges = Arr::get($defaults, 'badges', []);

        return $this->resolveLocalizedArray($defaultBadges, $locale);
    }

    public function membersForLocale(string $locale, array $defaults = []): array
    {
        $members = collect($this->management_members ?? [])
            ->map(fn (array $member) => $this->mapMember($member, $locale))
            ->filter()
            ->values()
            ->all();

        if (! empty($members)) {
            return $members;
        }

        $defaultMembers = Arr::get($defaults, 'management_members', []);

        return collect($defaultMembers)
            ->map(fn (array $member) => $this->mapMember($member, $locale))
            ->filter()
            ->values()
            ->all();
    }

    protected function mapMember(array $member, string $locale): ?array
    {
        $name = $this->resolveLocalizedValue($member['name'] ?? null, $locale);
        $role = $this->resolveLocalizedValue($member['role'] ?? null, $locale);

        if (! $name && ! $role) {
            return null;
        }

        return [
            'name' => $name ?? '',
            'role' => $role ?? '',
            'image_url' => $member['image_url'] ?? null,
        ];
    }

    protected function resolveLocalizedArray($value, string $locale): array
    {
        if (! is_array($value)) {
            return [];
        }

        $localized = $value[$locale] ?? $value['en'] ?? null;

        if (! is_array($localized)) {
            return [];
        }

        return array_values(array_filter($localized, fn ($item) => filled($item)));
    }

    protected function resolveLocalizedValue($value, string $locale): ?string
    {
        if (is_array($value)) {
            return $value[$locale] ?? $value['en'] ?? (is_scalar(reset($value)) ? (string) reset($value) : null);
        }

        return filled($value) ? (string) $value : null;
    }
}
