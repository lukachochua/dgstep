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
window.Swiper = Swiper;
window.SwiperModules = {
    Pagination,
    Autoplay,
};

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
        if (!document.fonts || !document.fonts.load) {
            this.fontsReady = true;
            this.maybeMarkReady();
            return;
        }

        const heroText = 'DGstep ოპერაციული პროგრამული პლატფორმები';
        const fontLoads = [
            document.fonts.load('400 1em "FiraGO"', heroText),
            document.fonts.load('700 1em "FiraGO"', heroText),
        ];
        const timeout = new Promise((resolve) => window.setTimeout(resolve, this.fontWaitMs));

        Promise.race([
            Promise.all(fontLoads),
            timeout,
        ]).then(() => {
            this.fontsReady = true;
            this.maybeMarkReady();
        });
    },
    init() {
        this.announcement = this.announcementTemplate
            .replace(':current', '1')
            .replace(':total', String(this.totalSlides));

        this.initFonts();

        if (!window.Swiper || this.totalSlides < 2) {
            this.swiperReady = true;
            this.maybeMarkReady();
            return;
        }

        const prefersReduced = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        const modules = window.SwiperModules
            ? [window.SwiperModules.Pagination, window.SwiperModules.Autoplay].filter(Boolean)
            : [];

        this.swiper = new window.Swiper(this.$refs.swiper, {
            modules,
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

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initLtrRevealOnScroll, { once: true });
} else {
    initLtrRevealOnScroll();
}

import.meta.glob([
    '../fonts/**',
]);

import.meta.glob('../images/**/*', { eager: true });
