import './bootstrap';

import Alpine from 'alpinejs';
import Swiper from 'swiper';
import {
    Pagination,
    Autoplay,
} from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/pagination';

window.Alpine = Alpine;

const heroSwiperModules = [Pagination, Autoplay];

function waitForFonts(fontDescriptors, text, waitMs = 650) {
    if (!document.fonts || !document.fonts.load) {
        return Promise.resolve();
    }

    const fontLoads = fontDescriptors.map((descriptor) => document.fonts.load(descriptor, text));
    const timeout = new Promise((resolve) => window.setTimeout(resolve, waitMs));

    return Promise.race([
        Promise.all(fontLoads),
        timeout,
    ]).catch(() => undefined);
}

window.heroSlider = (config = {}) => ({
    swiper: null,
    ready: false,
    fontsReady: false,
    swiperReady: false,
    slideLabel: config.slideLabel ?? '',
    announcementTemplate: config.announcementTemplate ?? '',
    announcement: '',
    totalSlides: Number(config.totalSlides ?? 1),
    fontWaitMs: Number(config.fontWaitMs ?? 650),
    maybeMarkReady() {
        if (this.ready || !this.fontsReady || !this.swiperReady) {
            return;
        }

        requestAnimationFrame(() => {
            requestAnimationFrame(() => {
                this.ready = true;
            });
        });
    },
    initFonts() {
        const heroText = 'DGstep ოპერაციული პროგრამული პლატფორმები';

        waitForFonts([
            '400 1em "FiraGO"',
            '700 1em "FiraGO"',
        ], heroText, this.fontWaitMs).then(() => {
            this.fontsReady = true;
            this.maybeMarkReady();
        });
    },
    init() {
        this.announcement = this.announcementTemplate
            .replace(':current', '1')
            .replace(':total', String(this.totalSlides));

        this.initFonts();

        if (!Swiper || this.totalSlides < 2) {
            this.swiperReady = true;
            this.maybeMarkReady();
            return;
        }

        const prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

        this.swiper = new Swiper(this.$refs.swiper, {
            modules: heroSwiperModules,
            slidesPerView: 1,
            loop: true,
            speed: prefersReduced ? 0 : 760,
            autoplay: prefersReduced
                ? false
                : {
                    delay: 8200,
                    disableOnInteraction: false,
                    pauseOnMouseEnter: true,
                },
            pagination: {
                el: this.$refs.pagination,
                clickable: true,
                bulletClass: 'hero-v2__dot',
                bulletActiveClass: 'is-active',
                renderBullet: (index, className) => `<button type="button" class="${className}" aria-label="${this.slideLabel} ${index + 1}"></button>`,
            },
            on: {
                init: () => {
                    this.swiperReady = true;
                    this.maybeMarkReady();
                },
                slideChange: (swiper) => {
                    const currentIndex = (swiper.realIndex ?? 0) + 1;
                    this.announcement = this.announcementTemplate
                        .replace(':current', String(currentIndex))
                        .replace(':total', String(this.totalSlides));
                },
            },
        });
    },
});

window.contactForm = (config = {}) => ({
    form: {
        name: config.initial?.name ?? '',
        surname: config.initial?.surname ?? '',
        phone: config.initial?.phone ?? '',
        comments: config.initial?.comments ?? '',
    },
    errors: {},
    messages: config.messages ?? {},
    submitForm() {
        this.errors = {};

        if (!this.form.name) this.errors.name = this.messages.name ?? '';
        if (!this.form.surname) this.errors.surname = this.messages.surname ?? '';

        if (!this.form.phone) {
            this.errors.phone = this.messages.phoneRequired ?? '';
        } else if (!/^\+?\d{7,15}$/.test(this.form.phone)) {
            this.errors.phone = this.messages.phoneInvalid ?? '';
        }

        if (Object.keys(this.errors).length === 0) {
            this.$el.submit();
        }
    },
});

window.aboutTeam = () => ({
    openMember: null,
    isMemberModalOpen: false,
    memberModalCleanupTimer: null,
    showAllMembers: false,
    openMemberModalFromDataset(dataset) {
        this.openMemberModal({
            name: dataset.memberName || '',
            role: dataset.memberRole || '',
            bio: dataset.memberBio || '',
            image: dataset.memberImage || '',
        });
    },
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
    },
    toggleMembers() {
        this.showAllMembers = !this.showAllMembers;
    },
});

window.siteNav = () => ({
    open: false,
    theme: 'light',
    fontsReady: false,
    desktopScrolled: false,
    desktopMedia: null,
    desktopScrollThreshold: 22,
    init() {
        const attr = document.documentElement.getAttribute('data-theme');
        this.theme = (attr === 'dark' || attr === 'light') ? attr : 'light';
        this.desktopMedia = window.matchMedia('(min-width: 900px)');
        this.syncDesktopScrollState();
        window.addEventListener('scroll', () => this.syncDesktopScrollState(), { passive: true });
        this.desktopMedia.addEventListener?.('change', () => this.syncDesktopScrollState());
        waitForFonts([
            '500 1em "FiraGO"',
            '700 1em "FiraGO"',
        ], 'DGstep Services About Projects Contact სერვისები ჩვენ შესახებ პროექტები კონტაქტი', 650).then(() => {
            this.fontsReady = true;
        });
    },
    syncDesktopScrollState() {
        this.desktopScrolled = !!this.desktopMedia?.matches && window.scrollY > this.desktopScrollThreshold;
        document.body.classList.toggle('nav-desktop-fixed', this.desktopScrolled);
    },
    toggleTheme() {
        this.theme = this.theme === 'dark' ? 'light' : 'dark';
        document.documentElement.setAttribute('data-theme', this.theme);
        try {
            localStorage.setItem('dg:theme', this.theme);
        } catch (_) {}
    },
    closeMenu() {
        this.open = false;
    },
    toggleMenu() {
        this.open = !this.open;
    },
    submitLocaleSwitch() {
        document.getElementById('locale-switch-form')?.submit();
    },
});

window.floatingCta = (config = {}) => ({
    isVisible: false,
    delayMs: Number(config.delayMs ?? 7200),
    showTimer: null,
    init() {
        const schedule = () => {
            this.showTimer = window.setTimeout(() => {
                this.isVisible = true;
            }, this.delayMs);
        };

        if (document.readyState === 'complete') {
            schedule();
            return;
        }

        window.addEventListener('load', schedule, { once: true });
    },
    dismiss() {
        this.isVisible = false;
        if (this.showTimer !== null) {
            window.clearTimeout(this.showTimer);
            this.showTimer = null;
        }
    },
    markConverted() {
        this.dismiss();
    },
});

Alpine.start();

function initLtrRevealOnScroll() {
    const allTargets = Array.from(document.querySelectorAll('[data-reveal-ltr]'));
    if (allTargets.length === 0) return;

    const prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    if (prefersReduced) {
        allTargets.forEach((node) => node.classList.add('is-visible'));
        return;
    }

    const observer = new IntersectionObserver((entries, obs) => {
        entries.forEach((entry) => {
            if (!entry.isIntersecting) return;
            entry.target.classList.add('is-visible');
            obs.unobserve(entry.target);
        });
    }, {
        threshold: 0.16,
        rootMargin: '0px 0px 2% 0px',
    });

    const grouped = new Set();
    document.querySelectorAll('[data-reveal-ltr-group]').forEach((group) => {
        const targets = Array.from(group.querySelectorAll('[data-reveal-ltr]'));
        const groupStyles = window.getComputedStyle(group);
        const isGridGroup = groupStyles.display.includes('grid');
        const gridTemplate = groupStyles.gridTemplateColumns;
        const gridColumns = isGridGroup && gridTemplate && gridTemplate !== 'none'
            ? gridTemplate.split(' ').filter(Boolean).length
            : 1;

        targets.forEach((node, index) => {
            grouped.add(node);
            if (!node.style.getPropertyValue('--ltr-delay')) {
                const stepIndex = gridColumns > 1 ? (index % gridColumns) : index;
                node.style.setProperty('--ltr-delay', `${stepIndex * 160}ms`);
            }
            observer.observe(node);
        });
    });

    allTargets
        .filter((node) => !grouped.has(node))
        .forEach((node) => observer.observe(node));
}

function initMarketingApp() {
    initLtrRevealOnScroll();
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initMarketingApp, { once: true });
} else {
    initMarketingApp();
}

import.meta.glob([
    '../fonts/**',
]);

import.meta.glob('../images/**/*', { eager: true });
