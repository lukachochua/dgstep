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
        :root {
            --color-electric-sky: #00a7ff;
            --color-electric-sky-hover: #008fdb;
            --color-electric-sky-focus: #005f9e;
        }

        [data-theme='dark'] {
            --color-electric-sky: #66ccff;
            --color-electric-sky-hover: #3399ff;
            --color-electric-sky-focus: #1a73e8;
            --bg-default: #121212;
            --text-default: #e0e0e0;
            --bg-elevated: #1e1e1e;
        }

        html,
        body {
            margin: 0;
            padding: 0;
            /* Remove all height/min-height declarations */
        }

        /* Use position fixed approach instead of viewport units */
        .page-wrapper {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow-y: auto;
            overflow-x: hidden;
        }

        /* Alternative approach: Use JavaScript to set height dynamically */
        .js-full-height {
            height: 100vh;
        }
    </style>
</head>

<body
    class="font-sans antialiased dark:bg-[var(--bg-default)] dark:text-[var(--text-default)] transition-colors duration-300 ease-in-out">

    <div
        class="page-wrapper bg-white dark:bg-[var(--bg-default)] text-gray-900 dark:text-[var(--text-default)] selection:bg-[var(--color-electric-sky)] selection:text-white">
        <main>
            {{ $slot }}
        </main>
    </div>

    <script>
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

            // Dynamic height calculation to avoid viewport unit issues
            function setDynamicHeight() {
                const wrapper = document.querySelector('.page-wrapper');
                if (wrapper) {
                    wrapper.style.height = window.innerHeight + 'px';
                }
            }

            // Set initial height
            setDynamicHeight();

            // Update height on resize (including zoom)
            window.addEventListener('resize', setDynamicHeight);

            // Also listen for orientationchange on mobile
            window.addEventListener('orientationchange', () => {
                setTimeout(setDynamicHeight, 100);
            });
        })();
    </script>

</body>

</html>
