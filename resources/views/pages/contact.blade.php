<x-layouts.base :title="__('contact.title')">
    <section class="py-20 bg-[#141a2f] text-white select-none">
        <div class="container mx-auto px-4 sm:px-6 md:px-8 grid grid-cols-1 md:grid-cols-2 gap-12 items-center">

            {{-- Left Content --}}
            <div class="space-y-6">
                <span class="uppercase text-[var(--color-electric-sky)] font-medium tracking-wide text-[13px]">
                    {{ __('contact.tagline') }}
                </span>
                <h2 class="text-3xl sm:text-4xl font-semibold leading-snug text-white">
                    {{ __('contact.headline') }}
                </h2>
                <p class="text-gray-300 text-[16px] leading-relaxed">
                    {{ __('contact.description') }}
                </p>

                {{-- Client Satisfaction --}}
                <div class="space-y-2">
                    <p class="text-[14px] text-white font-medium flex justify-between">
                        <span>{{ __('contact.metric.label') }}</span>
                        <span>100%</span>
                    </p>
                    <div class="w-full bg-gray-700 h-2 rounded-full overflow-hidden">
                        <div class="h-2 bg-[var(--color-electric-sky)] w-full"></div>
                    </div>
                </div>

                {{-- Feature Badges --}}
                <div class="flex flex-wrap gap-6 pt-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center">
                            <svg class="w-5 h-5 text-[var(--color-electric-sky)]" fill="none" stroke="currentColor"
                                stroke-width="2" viewBox="0 0 24 24">
                                <path d="M12 6v6l4 2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </div>
                        <span class="text-sm font-medium text-white">
                            {{ __('contact.features.professional') }}
                        </span>
                    </div>

                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center">
                            <svg class="w-5 h-5 text-[var(--color-electric-sky)]" fill="none" stroke="currentColor"
                                stroke-width="2" viewBox="0 0 24 24">
                                <path d="M9 12l2 2 4-4" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </div>
                        <span class="text-sm font-medium text-white">
                            {{ __('contact.features.guarantees') }}
                        </span>
                    </div>
                </div>

                {{-- Optional CTA or phone --}}
                <div class="pt-6">
                    <a href="#contact-form"
                        class="inline-block bg-yellow-400 text-black font-medium px-6 py-3 rounded-md shadow hover:scale-105 transition">
                        {{ __('contact.read_more') }}
                    </a>
                </div>
            </div>

            {{-- Contact Form --}}
            <div class="bg-[#1f2744] p-8 rounded-xl shadow-xl" id="contact-form">
                <form x-data="contactForm()" x-on:submit.prevent="submitForm" method="POST"
                    action="{{ route('contact.submit') }}" class="space-y-6">
                    @csrf

                    @if (session('success'))
                        <div class="text-green-400 font-medium">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div>
                        <label class="text-[14px] font-medium text-gray-300 mb-1 block">{{ __('contact.form.name') }}
                            *</label>
                        <input type="text" name="name" x-model="form.name"
                            class="w-full bg-gray-900 border border-gray-600 text-white p-3 rounded focus:ring-[var(--color-electric-sky)] focus:border-[var(--color-electric-sky)]"
                            :class="{ 'border-red-500': errors.name }" />
                        <template x-if="errors.name">
                            <p class="text-red-400 text-[13px] mt-1" x-text="errors.name"></p>
                        </template>
                    </div>

                    <div>
                        <label
                            class="text-[14px] font-medium text-gray-300 mb-1 block">{{ __('contact.form.surname') }}
                            *</label>
                        <input type="text" name="surname" x-model="form.surname"
                            class="w-full bg-gray-900 border border-gray-600 text-white p-3 rounded focus:ring-[var(--color-electric-sky)] focus:border-[var(--color-electric-sky)]"
                            :class="{ 'border-red-500': errors.surname }" />
                        <template x-if="errors.surname">
                            <p class="text-red-400 text-[13px] mt-1" x-text="errors.surname"></p>
                        </template>
                    </div>

                    <div>
                        <label class="text-[14px] font-medium text-gray-300 mb-1 block">{{ __('contact.form.phone') }}
                            *</label>
                        <input type="text" name="phone" x-model="form.phone"
                            class="w-full bg-gray-900 border border-gray-600 text-white p-3 rounded focus:ring-[var(--color-electric-sky)] focus:border-[var(--color-electric-sky)]"
                            :class="{ 'border-red-500': errors.phone }" />
                        <template x-if="errors.phone">
                            <p class="text-red-400 text-[13px] mt-1" x-text="errors.phone"></p>
                        </template>
                    </div>

                    <div>
                        <label
                            class="text-[14px] font-medium text-gray-300 mb-1 block">{{ __('contact.form.comments') }}</label>
                        <textarea name="comments" x-model="form.comments"
                            class="w-full bg-gray-900 border border-gray-600 text-white p-3 rounded focus:ring-[var(--color-electric-sky)] focus:border-[var(--color-electric-sky)]"
                            rows="4"></textarea>
                    </div>

                    <button type="submit"
                        class="w-full bg-yellow-400 text-black font-bold py-3 rounded-md hover:bg-yellow-300 transition">
                        {{ __('contact.form.cta') }}
                    </button>
                </form>
            </div>
        </div>
    </section>

    <script>
        function contactForm() {
            return {
                form: {
                    name: '',
                    surname: '',
                    phone: '',
                    comments: ''
                },
                errors: {},
                submitForm() {
                    this.errors = {};

                    if (!this.form.name) this.errors.name = '{{ __('contact.validation.name') }}';
                    if (!this.form.surname) this.errors.surname = '{{ __('contact.validation.surname') }}';
                    if (!this.form.phone) {
                        this.errors.phone = '{{ __('contact.validation.phone_required') }}';
                    } else if (!/^\+?\d{7,15}$/.test(this.form.phone)) {
                        this.errors.phone = '{{ __('contact.validation.phone_invalid') }}';
                    }

                    if (Object.keys(this.errors).length === 0) {
                        document.getElementById('contact-form').submit();
                    }
                }
            }
        }
    </script>
</x-layouts.base>
