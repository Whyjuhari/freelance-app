<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>FreelanceHub - Login</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&amp;display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet" />
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        primary: "#2563EB", // Vibrant Blue from dashboard
                        "primary-hover": "#1D4ED8",
                        "background-light": "#F3F4F6", // Light gray background
                        "background-dark": "#0F172A", // Dark Slate
                        "card-light": "#FFFFFF",
                        "card-dark": "#1E293B",
                        "text-main-light": "#111827",
                        "text-main-dark": "#F9FAFB",
                        "text-muted-light": "#6B7280",
                        "text-muted-dark": "#94A3B8",
                    },
                    fontFamily: {
                        display: ["Inter", "sans-serif"],
                    },
                    borderRadius: {
                        DEFAULT: "0.75rem", // Consistent rounded corners
                        xl: "1rem",
                        "2xl": "1.5rem",
                    },
                    boxShadow: {
                        soft: "0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03)",
                    },
                },
            },
        };
    </script>
    <style>
        body {
            min-height: max(884px, 100dvh);
        }
    </style>
</head>

<body
    class="bg-background-light dark:bg-background-dark font-display antialiased min-h-screen flex items-center justify-center p-6 transition-colors duration-300">
    <main class="w-full max-w-sm mx-auto">
        {{ $slot }}
    </main>
    <button
        class="fixed top-4 right-4 p-2 rounded-full bg-white dark:bg-slate-800 shadow-md text-gray-500 dark:text-gray-400 z-50"
        onclick="document.documentElement.classList.toggle('dark')">
        <span class="material-icons-round dark:hidden">dark_mode</span>
        <span class="material-icons-round hidden dark:inline">light_mode</span>
    </button>
</body>

</html>
