<!DOCTYPE html>
<html lang="en" class="scroll-smooth" data-theme="light">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ $title ?? 'DGstep' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Google Fonts: Inter (modern, variable) -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet" />

    <style>
        /* Make electric sky available as a CSS variable globally */
        :root {
            --color-electric-sky: #00a7ff;
            --color-electric-sky-hover: #008fdb;
            --color-electric-sky-focus: #005f9e;
        }

        /* Support dark mode variables */
        [data-theme='dark'] {
            --color-electric-sky: #66ccff;
            --color-electric-sky-hover: #3399ff;
            --color-electric-sky-focus: #1a73e8;
            --bg-default: #121212;
            --text-default: #e0e0e0;
            --bg-elevated: #1e1e1e;
        }
    </style>
</head>

<body
    class="bg-white text-gray-900 font-sans antialiased selection:bg-[var(--color-electric-sky)] selection:text-white dark:bg-[var(--bg-default)] dark:text-[var(--text-default)] transition-colors duration-300 ease-in-out">

    {{ $slot }}

    <script>
        // Simple Dark Mode Toggle: store in localStorage, toggle data-theme on <html>
        (() => {
            const themeToggleKey = 'dgstep-theme';
            const htmlEl = document.documentElement;
            const currentTheme = localStorage.getItem(themeToggleKey);

            if (currentTheme === 'dark') {
                htmlEl.setAttribute('data-theme', 'dark');
            }

            window.toggleTheme = () => {
                const isDark = htmlEl.getAttribute('data-theme') === 'dark';
                if (isDark) {
                    htmlEl.setAttribute('data-theme', 'light');
                    localStorage.setItem(themeToggleKey, 'light');
                } else {
                    htmlEl.setAttribute('data-theme', 'dark');
                    localStorage.setItem(themeToggleKey, 'dark');
                }
            }
        })();
    </script>

</body>

</html>
