@php
    use Illuminate\Support\Facades\Storage;

    $locale = app()->getLocale();
    $aboutDefaults = $aboutDefaults ?? \App\Models\AboutPage::defaults();
    $aboutPage = $aboutPage ?? \App\Models\AboutPage::singleton();

    $pageTitle = $aboutPage->translated('title', $locale, $aboutDefaults);

    $heroImageUrl = $aboutPage->hero_image_url ?? ($aboutDefaults['hero_image_url'] ?? null);
    $heroImageAlt = $aboutPage->translated('hero_image_alt', $locale, $aboutDefaults);
    $heroCaption = $aboutPage->translated('hero_caption', $locale, $aboutDefaults);

    $whoHeading = $aboutPage->translated('who_heading', $locale, $aboutDefaults);
    $whoParagraph1 = $aboutPage->translated('who_paragraph_1', $locale, $aboutDefaults);
    $whoParagraph2 = $aboutPage->translated('who_paragraph_2', $locale, $aboutDefaults);

    $missionHeading = $aboutPage->translated('mission_heading', $locale, $aboutDefaults);
    $missionDescription = $aboutPage->translated('mission_description', $locale, $aboutDefaults);

    $visionHeading = $aboutPage->translated('vision_heading', $locale, $aboutDefaults);
    $visionDescription = $aboutPage->translated('vision_description', $locale, $aboutDefaults);

    $badges = $aboutPage->badgesForLocale($locale, $aboutDefaults);

    $managementHeading = $aboutPage->translated('management_heading', $locale, $aboutDefaults);
    $managementMembers = $aboutPage->membersForLocale($locale, $aboutDefaults);

    $defaultMemberImage = 'https://images.unsplash.com/photo-1607746882042-944635dfe10e?w=300&h=300&fit=crop';

    $resolveMemberImage = function (array $member) use ($defaultMemberImage) {
        $uploadPath = $member['image_path'] ?? null;

        if ($uploadPath) {
            try {
                return Storage::disk('public')->url($uploadPath);
            } catch (\Throwable $exception) {
            }
        }

        return ($member['image_url'] ?? null) ?: $defaultMemberImage;
    };
@endphp

<x-layouts.base :title="$pageTitle ?? __('about.title')">
  <section class="section-block">
    <div class="section-inner space-y-8">
      <div class="panel p-6 md:p-8 lg:p-10 reveal">
        <div class="grid gap-8 lg:grid-cols-[1.1fr_0.9fr] lg:items-center">
          <div class="space-y-4">
            <span class="section-kicker">{{ __('messages.about') }}</span>
            <h1 class="section-title">{!! $whoHeading ?? __('about.who_we_are.heading') !!}</h1>
            <p class="section-lead">{!! $whoParagraph1 ?? __('about.who_we_are.paragraph_1') !!}</p>
            <p class="text-sm text-[color:var(--text-muted)]">{!! $whoParagraph2 ?? __('about.who_we_are.paragraph_2') !!}</p>

            <div class="flex flex-wrap gap-2 pt-2">
              @foreach ($badges as $badge)
                <span class="section-kicker">{{ $badge }}</span>
              @endforeach
            </div>
          </div>

          <div>
            <img
              src="{{ $heroImageUrl }}"
              alt="{{ $heroImageAlt ?? __('about.hero_image_fallback_alt') }}"
              class="service-image h-72 w-full md:h-80"
              loading="eager"
              fetchpriority="high"
              decoding="async"
            />
            <p class="mt-2 text-xs text-[color:var(--text-muted)]">{{ $heroCaption }}</p>
          </div>
        </div>
      </div>

      <div class="grid gap-6 md:grid-cols-2 stagger">
        <article class="panel p-6 md:p-7">
          <h2 class="text-2xl font-semibold leading-tight">{!! $missionHeading ?? __('about.mission.heading') !!}</h2>
          <p class="mt-3 text-sm text-[color:var(--text-muted)]">{!! $missionDescription ?? __('about.mission.description') !!}</p>
        </article>

        <article class="panel p-6 md:p-7">
          <h2 class="text-2xl font-semibold leading-tight">{!! $visionHeading ?? __('about.vision.heading') !!}</h2>
          <p class="mt-3 text-sm text-[color:var(--text-muted)]">{!! $visionDescription ?? __('about.vision.description') !!}</p>
        </article>
      </div>

      <section
        class="space-y-5 reveal reveal-delay-1"
        x-data="{
          openMember: null,
          isMemberModalOpen: false,
          memberModalCleanupTimer: null,
          openMemberModal(member) {
            if (this.memberModalCleanupTimer) {
              clearTimeout(this.memberModalCleanupTimer);
              this.memberModalCleanupTimer = null;
            }
            this.openMember = member;
            this.isMemberModalOpen = true;
          },
          closeMemberModal() {
            this.isMemberModalOpen = false;
            if (this.memberModalCleanupTimer) {
              clearTimeout(this.memberModalCleanupTimer);
            }
            this.memberModalCleanupTimer = setTimeout(() => {
              if (!this.isMemberModalOpen) {
                this.openMember = null;
              }
              this.memberModalCleanupTimer = null;
            }, 220);
          }
        }"
        @keydown.escape.window="if (isMemberModalOpen) closeMemberModal()"
        x-effect="document.body.classList.toggle('overflow-hidden', isMemberModalOpen)"
      >
        <h2 class="section-title text-[clamp(1.4rem,2.2vw,2.1rem)]">{!! $managementHeading ?? __('about.management.heading') !!}</h2>

        <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
          @forelse ($managementMembers as $member)
            @php
              $memberData = is_array($member) ? $member : (array) $member;
              $memberName = $memberData['name'] ?? __('about.management.member_fallback');
              $memberRole = $memberData['role'] ?? '';
              $memberBio = $memberData['bio'] ?? '';
              $memberImage = $resolveMemberImage($memberData);
            @endphp

            <button
              type="button"
              class="team-card w-full cursor-pointer p-5 text-left"
              data-member-name="{{ $memberName }}"
              data-member-role="{{ $memberRole }}"
              data-member-bio="{{ $memberBio }}"
              data-member-image="{{ $memberImage }}"
              @click="openMemberModal({
                name: $el.dataset.memberName || '',
                role: $el.dataset.memberRole || '',
                bio: $el.dataset.memberBio || '',
                image: $el.dataset.memberImage || ''
              })"
              aria-label="{{ __('about.management.open_profile') }} {{ $memberName }}"
            >
              <div class="flex items-center gap-4">
                <img
                  src="{{ $memberImage }}"
                  alt="{{ $memberName }}"
                  class="h-14 w-14 rounded-full object-cover"
                  loading="lazy"
                  decoding="async"
                />
                <div>
                  <h3 class="text-base font-semibold">{{ $memberName }}</h3>
                  <p class="text-xs text-[color:var(--text-muted)]">{{ $memberRole }}</p>
                </div>
              </div>

              @if (!empty($memberBio))
                <p class="mt-4 line-clamp-3 text-sm text-[color:var(--text-muted)]">{{ $memberBio }}</p>
              @endif
            </button>
          @empty
            <article class="panel p-5 text-sm text-[color:var(--text-muted)]">{{ __('about.management.no_members') }}</article>
          @endforelse
        </div>

        <template x-teleport="body">
          <div
            x-cloak
            x-show="isMemberModalOpen"
            class="fixed inset-0 z-[120] grid place-items-center p-4 sm:p-6"
            role="dialog"
            aria-modal="true"
            @click.self="closeMemberModal()"
          >
            <div class="absolute inset-0 bg-black/52 backdrop-blur-md" aria-hidden="true"></div>

            <div
              x-show="isMemberModalOpen"
              x-transition:enter="transition ease-out duration-250"
              x-transition:enter-start="opacity-0 translate-y-3 scale-[0.98]"
              x-transition:enter-end="opacity-100 translate-y-0 scale-100"
              x-transition:leave="transition ease-in duration-180"
              x-transition:leave-start="opacity-100 translate-y-0 scale-100"
              x-transition:leave-end="opacity-0 translate-y-2 scale-[0.98]"
              class="panel relative z-[1] w-full max-w-2xl p-5 md:p-7"
            >
              <button
                type="button"
                class="btn btn-sm btn-ghost absolute right-4 top-4"
                @click="closeMemberModal()"
              >
                {{ __('about.management.close_modal') }}
              </button>

              <div class="grid gap-5 pt-10 md:grid-cols-[220px_1fr] md:items-start md:pt-0">
                <img
                  :src="openMember ? openMember.image : ''"
                  :alt="openMember ? openMember.name : ''"
                  class="service-image h-52 w-full md:h-64"
                  loading="lazy"
                  decoding="async"
                />

                <div class="space-y-3">
                  <h3 class="text-2xl font-semibold leading-tight" x-text="openMember ? openMember.name : ''"></h3>
                  <p class="text-sm text-[color:var(--brand-strong)]" x-text="openMember ? openMember.role : ''"></p>
                  <p
                    x-show="openMember && openMember.bio"
                    class="text-sm leading-6 text-[color:var(--text-muted)]"
                    x-text="openMember ? openMember.bio : ''"
                  ></p>
                </div>
              </div>
            </div>
          </div>
        </template>
      </section>
    </div>
  </section>
</x-layouts.base>
