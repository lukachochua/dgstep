import './bootstrap';

import Swiper from 'swiper';
import { Navigation, Pagination, Autoplay } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';

window.Swiper = Swiper;
window.SwiperModules = { Navigation, Pagination, Autoplay };

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
        threshold: 0.2,
        rootMargin: '0px 0px -8% 0px',
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
                node.style.setProperty('--ltr-delay', `${stepIndex * 280}ms`);
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

import.meta.glob('../images/brand/*', { eager: true });
