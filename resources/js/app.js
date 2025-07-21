import './bootstrap';
import.meta.glob([
    '../fonts/**',
]);

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
