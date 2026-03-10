<?php

namespace App\Http\Controllers;

use App\Models\AboutPage;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AboutPageController extends Controller
{
    private const DEFAULT_MEMBER_IMAGE = 'https://images.unsplash.com/photo-1607746882042-944635dfe10e?w=300&h=300&fit=crop';

    public function __invoke(): View
    {
        $locale = app()->getLocale();
        $defaults = AboutPage::defaults();
        $page = AboutPage::singleton();

        $members = collect($page->membersForLocale($locale, $defaults))
            ->map(fn (array $member): array => [
                ...$member,
                'image' => $this->resolveMemberImage($member),
            ])
            ->values();

        return view('pages.about', [
            'page' => [
                'title' => $page->translated('title', $locale, $defaults),
                'hero' => [
                    'kicker' => trans('messages.about', [], $locale),
                    'heading' => $page->translated('who_heading', $locale, $defaults),
                    'paragraphs' => array_values(array_filter([
                        $page->translated('who_paragraph_1', $locale, $defaults),
                        $page->translated('who_paragraph_2', $locale, $defaults),
                    ])),
                    'badges' => $page->badgesForLocale($locale, $defaults),
                    'image' => $page->hero_image_url ?? ($defaults['hero_image_url'] ?? null),
                    'image_alt' => $page->translated('hero_image_alt', $locale, $defaults)
                        ?: trans('about.hero_image_fallback_alt', [], $locale),
                    'caption' => $page->translated('hero_caption', $locale, $defaults),
                ],
                'principles' => [
                    [
                        'tone' => 'mission',
                        'label' => $page->translated('mission_label', $locale, $defaults),
                        'heading' => $page->translated('mission_heading', $locale, $defaults),
                        'description' => $page->translated('mission_description', $locale, $defaults),
                        'show_label' => $this->shouldShowPrincipleLabel(
                            $page->translated('mission_label', $locale, $defaults),
                            $page->translated('mission_heading', $locale, $defaults),
                        ),
                    ],
                    [
                        'tone' => 'vision',
                        'label' => $page->translated('vision_label', $locale, $defaults),
                        'heading' => $page->translated('vision_heading', $locale, $defaults),
                        'description' => $page->translated('vision_description', $locale, $defaults),
                        'show_label' => $this->shouldShowPrincipleLabel(
                            $page->translated('vision_label', $locale, $defaults),
                            $page->translated('vision_heading', $locale, $defaults),
                        ),
                    ],
                ],
            ],
            'team' => [
                'heading' => $page->translated('management_heading', $locale, $defaults),
                'view_all' => $page->translated('management_view_all', $locale, $defaults),
                'collapse' => $page->translated('management_collapse', $locale, $defaults),
                'member_fallback' => trans('about.management.member_fallback', [], $locale),
                'open_profile' => trans('about.management.open_profile', [], $locale),
                'close_modal' => trans('about.management.close_modal', [], $locale),
                'no_members' => trans('about.management.no_members', [], $locale),
                'lead' => $members->first(),
                'core' => $members->slice(1, 2)->values()->all(),
                'extended' => $members->slice(3)->values()->all(),
                'count' => $members->count(),
            ],
        ]);
    }

    private function resolveMemberImage(array $member): string
    {
        $uploadPath = $member['image_path'] ?? null;

        if ($uploadPath) {
            try {
                return url(Storage::disk('public')->url($uploadPath));
            } catch (\Throwable $exception) {
                // fall back to the stored URL when storage URL resolution fails
            }
        }

        return $member['image_url'] ?? self::DEFAULT_MEMBER_IMAGE;
    }

    private function shouldShowPrincipleLabel(?string $label, ?string $heading): bool
    {
        $normalizedLabel = $this->normalizePrincipleText($label);
        $normalizedHeading = $this->normalizePrincipleText($heading);

        if ($normalizedLabel === '' || $normalizedHeading === '') {
            return $normalizedLabel !== '';
        }

        return $normalizedLabel !== $normalizedHeading;
    }

    private function normalizePrincipleText(?string $value): string
    {
        return Str::lower(
            trim(
                preg_replace('/\s+/u', ' ', strip_tags((string) $value)) ?? ''
            )
        );
    }
}
