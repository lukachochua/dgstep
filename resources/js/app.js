import './bootstrap';
import.meta.glob([
    '../fonts/**',
]);

import.meta.glob('../images/brand/*', { eager: true });


window.addEventListener('DOMContentLoaded', () => {

    // Mobile menu toggle
    // This code toggles the visibility of the mobile menu when the button is clicked.

    const toggleBtn = document.getElementById("menu-toggle");
    const mobileMenu = document.getElementById("mobile-menu");

    if (!toggleBtn || !mobileMenu) return;

    toggleBtn.addEventListener("click", () => {
        const expanded = toggleBtn.getAttribute("aria-expanded") === "true";
        toggleBtn.setAttribute("aria-expanded", String(!expanded));
        mobileMenu.classList.toggle("hidden");
    });

    // Theme toggle functionality
    // This code toggles the theme between light and dark modes.

    (() => {
        const themeToggleKey = 'dgstep-theme';
        const htmlEl = document.documentElement;
        const currentTheme = localStorage.getItem(themeToggleKey);

        if (currentTheme === 'dark') {
            htmlEl.setAttribute('data-theme', 'dark');
        }

        window.toggleTheme = () => {
            const isDark = htmlEl.getAttribute('data-theme') === 'dark';
            htmlEl.setAttribute('data-theme', isDark ? 'light' : 'dark');
            localStorage.setItem(themeToggleKey, isDark ? 'light' : 'dark');
        };

        function setDynamicHeight() {
            const wrapper = document.querySelector('.page-wrapper');
            if (wrapper) {
                wrapper.style.height = window.innerHeight + 'px';
            }
        }

        setDynamicHeight();
        window.addEventListener('resize', setDynamicHeight);
        window.addEventListener('orientationchange', () => setTimeout(setDynamicHeight, 100));
    })();

});
// Ensure the bundle is actually loaded on the page with @vite and that sourcemaps work.
// Delegated handler so timing/HMR won't matter.
document.addEventListener('click', (e) => {
  const btn = e.target.closest('[data-js="menu-toggle"]');
  if (!btn) return;

  const menu = document.getElementById('mobile-menu');
  if (!menu) return;

  const isOpen = menu.getAttribute('data-state') === 'open';
  menu.setAttribute('data-state', isOpen ? 'closed' : 'open');
  btn.setAttribute('aria-expanded', String(!isOpen));

  // Tailwind show/hide
  menu.classList.toggle('hidden', isOpen);

  // Optional: lock scroll while open (mobile UX)
  document.documentElement.classList.toggle('overflow-hidden', !isOpen);
});

// Keep menu consistent when jumping across breakpoints
const mq = window.matchMedia('(min-width: 1024px)');
const syncOnResize = () => {
  const menu = document.getElementById('mobile-menu');
  const btn  = document.querySelector('[data-js="menu-toggle"]');
  if (!menu || !btn) return;
  if (mq.matches) {
    // On desktop, keep it hidden/reset
    menu.classList.add('hidden');
    menu.setAttribute('data-state', 'closed');
    btn.setAttribute('aria-expanded', 'false');
    document.documentElement.classList.remove('overflow-hidden');
  }
};
mq.addEventListener?.('change', syncOnResize);
window.addEventListener('resize', syncOnResize);
