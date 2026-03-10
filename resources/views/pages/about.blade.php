<x-layouts.base :title="$page['title'] ?? __('about.title')">
  <section class="section-block">
    <div class="section-inner space-y-8">
      <section class="panel about-hero-card p-6 md:p-8 lg:p-10 reveal">
        <div class="about-hero-grid">
          <div class="space-y-5">
            <span class="section-kicker">{{ $page['hero']['kicker'] }}</span>

            <div class="space-y-4">
              <h1 class="section-title">{!! $page['hero']['heading'] !!}</h1>

              <div class="about-story-copy">
                @foreach ($page['hero']['paragraphs'] as $index => $paragraph)
                  <p class="{{ $index === 0 ? 'section-lead' : 'text-sm text-[color:var(--text-muted)] md:text-base' }}">
                    {!! $paragraph !!}
                  </p>
                @endforeach
              </div>
            </div>

            @if (!empty($page['hero']['badges']))
              <div class="about-proof-grid">
                @foreach ($page['hero']['badges'] as $badge)
                  <div class="about-proof-chip">
                    <span>{{ $badge }}</span>
                  </div>
                @endforeach
              </div>
            @endif
          </div>

          <figure class="about-hero-media">
            <img
              src="{{ $page['hero']['image'] }}"
              alt="{{ $page['hero']['image_alt'] }}"
              class="service-image about-hero-image"
              loading="eager"
              fetchpriority="high"
              decoding="async"
            />
            @if (filled($page['hero']['caption']))
              <figcaption class="about-hero-caption">{{ $page['hero']['caption'] }}</figcaption>
            @endif
          </figure>
        </div>
      </section>

        <section class="about-principles stagger">
        @foreach ($page['principles'] as $principle)
          <article class="panel about-principle-card about-principle-card--{{ $principle['tone'] }} p-6 md:p-7">
            @if ($principle['show_label'])
              <span class="about-principle-label">{{ $principle['label'] }}</span>
            @endif
            <h2 class="{{ $principle['show_label'] ? 'mt-4' : '' }} text-2xl font-semibold leading-tight">{!! $principle['heading'] !!}</h2>
            <p class="mt-3 text-sm leading-6 text-[color:var(--text-muted)] md:text-base">{!! $principle['description'] !!}</p>
          </article>
        @endforeach
      </section>

      <section
        class="about-team-section space-y-5 reveal reveal-delay-1"
        x-data="{
          openMember: null,
          isMemberModalOpen: false,
          memberModalCleanupTimer: null,
          showAllMembers: false,
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
        <div class="about-team-header">
          <h2 class="section-title text-[clamp(1.4rem,2.2vw,2.1rem)]">{!! $team['heading'] !!}</h2>

          @if (!empty($team['extended']))
            <button type="button" class="btn btn-ghost about-team-toggle" @click="showAllMembers = !showAllMembers">
              <span x-show="!showAllMembers">{{ $team['view_all'] }}</span>
              <span x-show="showAllMembers" x-cloak>{{ $team['collapse'] }}</span>
            </button>
          @endif
        </div>

        @if ($team['count'] === 0)
          <article class="panel p-5 text-sm text-[color:var(--text-muted)]">{{ $team['no_members'] }}</article>
        @else
          <div class="about-team-showcase">
            @if (!empty($team['lead']))
              <button
                type="button"
                class="team-card about-team-lead w-full cursor-pointer p-6 text-left"
                data-member-name="{{ $team['lead']['name'] ?? $team['member_fallback'] }}"
                data-member-role="{{ $team['lead']['role'] ?? '' }}"
                data-member-bio="{{ $team['lead']['bio'] ?? '' }}"
                data-member-image="{{ $team['lead']['image'] ?? '' }}"
                @click="openMemberModal({
                  name: $el.dataset.memberName || '',
                  role: $el.dataset.memberRole || '',
                  bio: $el.dataset.memberBio || '',
                  image: $el.dataset.memberImage || ''
                })"
                aria-label="{{ $team['open_profile'] }} {{ $team['lead']['name'] ?? $team['member_fallback'] }}"
              >
                <div class="about-team-lead-media">
                  <img
                    src="{{ $team['lead']['image'] }}"
                    alt="{{ $team['lead']['name'] ?? $team['member_fallback'] }}"
                    class="about-team-lead-image"
                    loading="lazy"
                    decoding="async"
                  />
                </div>

                <div class="about-team-lead-copy">
                  <span class="section-kicker">{{ $team['lead']['role'] ?? '' }}</span>
                  <h3 class="text-[clamp(1.5rem,2.4vw,2.1rem)] font-semibold leading-tight">{{ $team['lead']['name'] ?? $team['member_fallback'] }}</h3>
                  @if (!empty($team['lead']['bio']))
                    <p class="text-sm leading-6 text-[color:var(--text-muted)] md:text-base">{{ $team['lead']['bio'] }}</p>
                  @endif
                </div>
              </button>
            @endif

            @if (!empty($team['core']))
              <div class="about-team-aside">
                @foreach ($team['core'] as $member)
                  <button
                    type="button"
                    class="team-card about-member-button w-full cursor-pointer p-5 text-left"
                    data-member-name="{{ $member['name'] ?? $team['member_fallback'] }}"
                    data-member-role="{{ $member['role'] ?? '' }}"
                    data-member-bio="{{ $member['bio'] ?? '' }}"
                    data-member-image="{{ $member['image'] ?? '' }}"
                    @click="openMemberModal({
                      name: $el.dataset.memberName || '',
                      role: $el.dataset.memberRole || '',
                      bio: $el.dataset.memberBio || '',
                      image: $el.dataset.memberImage || ''
                    })"
                    aria-label="{{ $team['open_profile'] }} {{ $member['name'] ?? $team['member_fallback'] }}"
                  >
                    <div class="about-member-preview">
                      <img
                        src="{{ $member['image'] }}"
                        alt="{{ $member['name'] ?? $team['member_fallback'] }}"
                        class="h-16 w-16 rounded-full object-cover"
                        loading="lazy"
                        decoding="async"
                      />
                      <div>
                        <h3 class="text-base font-semibold">{{ $member['name'] ?? $team['member_fallback'] }}</h3>
                        <p class="text-xs text-[color:var(--text-muted)]">{{ $member['role'] ?? '' }}</p>
                      </div>
                    </div>

                    @if (!empty($member['bio']))
                      <p class="mt-4 line-clamp-3 text-sm text-[color:var(--text-muted)]">{{ $member['bio'] }}</p>
                    @endif
                  </button>
                @endforeach
              </div>
            @endif
          </div>

          @if (!empty($team['extended']))
            <div
              x-cloak
              x-show="showAllMembers"
              x-transition:enter="transition ease-out duration-220"
              x-transition:enter-start="opacity-0 translate-y-3"
              x-transition:enter-end="opacity-100 translate-y-0"
              x-transition:leave="transition ease-in duration-180"
              x-transition:leave-start="opacity-100 translate-y-0"
              x-transition:leave-end="opacity-0 translate-y-2"
              class="about-team-grid"
            >
              @foreach ($team['extended'] as $member)
                <button
                  type="button"
                  class="team-card about-member-button w-full cursor-pointer p-5 text-left"
                  data-member-name="{{ $member['name'] ?? $team['member_fallback'] }}"
                  data-member-role="{{ $member['role'] ?? '' }}"
                  data-member-bio="{{ $member['bio'] ?? '' }}"
                  data-member-image="{{ $member['image'] ?? '' }}"
                  @click="openMemberModal({
                    name: $el.dataset.memberName || '',
                    role: $el.dataset.memberRole || '',
                    bio: $el.dataset.memberBio || '',
                    image: $el.dataset.memberImage || ''
                  })"
                  aria-label="{{ $team['open_profile'] }} {{ $member['name'] ?? $team['member_fallback'] }}"
                >
                  <div class="about-member-preview">
                    <img
                      src="{{ $member['image'] }}"
                      alt="{{ $member['name'] ?? $team['member_fallback'] }}"
                      class="h-16 w-16 rounded-full object-cover"
                      loading="lazy"
                      decoding="async"
                    />
                    <div>
                      <h3 class="text-base font-semibold">{{ $member['name'] ?? $team['member_fallback'] }}</h3>
                      <p class="text-xs text-[color:var(--text-muted)]">{{ $member['role'] ?? '' }}</p>
                    </div>
                  </div>

                  @if (!empty($member['bio']))
                    <p class="mt-4 line-clamp-3 text-sm text-[color:var(--text-muted)]">{{ $member['bio'] }}</p>
                  @endif
                </button>
              @endforeach
            </div>
          @endif
        @endif

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
              class="panel about-member-modal relative z-[1] w-full max-w-4xl p-5 md:p-7"
            >
              <button
                type="button"
                class="btn btn-sm btn-ghost absolute right-4 top-4"
                @click="closeMemberModal()"
              >
                {{ $team['close_modal'] }}
              </button>

              <div class="grid gap-5 pt-10 md:grid-cols-[280px_1fr] md:items-start md:gap-7 md:pt-0">
                <img
                  :src="openMember ? openMember.image : ''"
                  :alt="openMember ? openMember.name : ''"
                  class="service-image h-52 w-full md:h-80"
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
