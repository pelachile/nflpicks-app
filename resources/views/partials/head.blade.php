<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<title>{{ $title ?? config('app.name') }}</title>

<link rel="icon" href="/favicon.ico?v={{ time() }}" sizes="any">
<link rel="icon" href="/favicon.svg?v={{ time() }}" type="image/svg+xml">
<link rel="apple-touch-icon" href="/apple-touch-icon.png">

<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

@vite(['resources/css/app.css', 'resources/js/app.js'])

<!-- Theme Script (must be loaded early to prevent flash) -->
<script>
    (function() {
        function applyTheme() {
            const theme = localStorage.getItem('theme') || 'system';
            if (theme === 'dark' || (theme === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        }
        
        // Apply theme immediately
        applyTheme();
        
        // Listen for system theme changes
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
            if (localStorage.getItem('theme') === 'system') {
                applyTheme();
            }
        });
        
        // Listen for storage changes (for cross-tab updates)
        window.addEventListener('storage', (e) => {
            if (e.key === 'theme') {
                applyTheme();
            }
        });
    })();
</script>
