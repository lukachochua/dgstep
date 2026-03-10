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
