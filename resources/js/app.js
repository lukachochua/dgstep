import './bootstrap';

window.addEventListener('DOMContentLoaded', () => {
    const toggleBtn = document.getElementById("menu-toggle");
    const mobileMenu = document.getElementById("mobile-menu");

    if (!toggleBtn || !mobileMenu) return;

    toggleBtn.addEventListener("click", () => {
        const expanded = toggleBtn.getAttribute("aria-expanded") === "true";
        toggleBtn.setAttribute("aria-expanded", String(!expanded));
        mobileMenu.classList.toggle("hidden");
    });
});
