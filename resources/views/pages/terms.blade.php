<x-layouts.base :title="__('messages.footer.nav.terms')">
    <section
        class="bg-gradient-to-r from-[#0b0f1a] via-[#141d2f] to-[#0b0f1a] text-white py-20 select-none font-[FiraGO]">
        <div class="container mx-auto px-4 sm:px-6 md:px-8 max-w-4xl space-y-8">
            <h1 class="text-4xl md:text-5xl font-bold text-center text-[var(--color-electric-sky)] mb-8">
                {{ __('messages.footer.nav.terms') }}
            </h1>

            <div class="space-y-6 text-white/80 leading-relaxed text-[17px]">
                <p>
                    These Terms and Conditions ("Terms") govern your use of the DGstep website and services. By
                    accessing our site or using our services, you agree to comply with these Terms.
                </p>

                <h2 class="text-white text-2xl font-semibold mt-6">1. Use of Services</h2>
                <p>
                    Our services are provided for professional use by businesses and individuals. You agree not to
                    misuse or abuse any features offered through the DGstep platform.
                </p>

                <h2 class="text-white text-2xl font-semibold mt-6">2. Intellectual Property</h2>
                <p>
                    All content, branding, and software provided by DGstep are the intellectual property of DGstep and
                    protected under applicable laws.
                </p>

                <h2 class="text-white text-2xl font-semibold mt-6">3. Privacy</h2>
                <p>
                    We collect minimal data and are committed to safeguarding user privacy. Please read our Privacy
                    Policy for more details.
                </p>

                <h2 class="text-white text-2xl font-semibold mt-6">4. Limitation of Liability</h2>
                <p>
                    DGstep is not liable for any indirect or consequential damages arising from the use of our services.
                </p>

                <h2 class="text-white text-2xl font-semibold mt-6">5. Changes to Terms</h2>
                <p>
                    We reserve the right to update these Terms at any time. Users will be notified of significant
                    changes via the site.
                </p>

                <p>
                    If you have any questions regarding these Terms, please contact us at info@example.com.
                </p>
            </div>

            <div class="text-center pt-10">
                <a href="{{ route('contact') }}"
                    class="inline-block mt-6 px-6 py-3 border-2 border-white text-white font-semibold rounded-lg hover:bg-white hover:text-[var(--color-electric-sky)] transition">
                    {{ __('messages.footer.nav.contact') }}
                </a>
            </div>
        </div>
    </section>
</x-layouts.base>
