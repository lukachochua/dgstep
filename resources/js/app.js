import './bootstrap';


// Navigation Bar Toggle and Color Change

window.addEventListener('DOMContentLoaded', () => {
    const btn = document.getElementById("menu-toggle");
    const menu = document.getElementById("mobile-menu");
    const logo = document.getElementById("logo-text");
    const desktopMenu = document.getElementById("desktop-menu");

    if (!btn || !menu || !logo || !desktopMenu) return; 


    btn.addEventListener("click", () => {
        const expanded = btn.getAttribute("aria-expanded") === "true";
        btn.setAttribute("aria-expanded", !expanded);
        menu.classList.toggle("hidden");
    });

    let ticking = false;
    const updateColors = () => {
        const isScrolled = window.scrollY > 50;

        logo.classList.toggle("text-white", isScrolled);
        logo.classList.toggle("text-electric", !isScrolled);

        if (isScrolled) {
            desktopMenu.querySelectorAll("a").forEach(a => {
                a.classList.remove("text-electric");
                a.classList.add("text-white");
            });
        } else {
            desktopMenu.querySelectorAll("a").forEach(a => {
                a.classList.add("text-electric");
                a.classList.remove("text-white");
            });
        }

        ticking = false;
    };

    const onScroll = () => {
        if (!ticking) {
            window.requestAnimationFrame(updateColors);
            ticking = true;
        }
    };

    window.addEventListener("scroll", onScroll);
    window.addEventListener("load", updateColors); 
});