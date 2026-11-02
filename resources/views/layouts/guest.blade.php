<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Masuk ke Akun — gajiku.')</title>

    <!-- Google Fonts: DM Sans & Manrope -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,400..700;1,9..40,400..700&family=Manrope:wght@500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"DM Sans"', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                        display: ['"Manrope"', '"DM Sans"', 'sans-serif'],
                    },
                    colors: {
                        canvas: '#f7f9f8',
                        ink: '#242d2a',
                        forest: {
                            DEFAULT: '#326b4c',
                            50: '#f3f7ef',
                            100: '#eaf1e4',
                            200: '#dce8d2',
                            300: '#c3d7b5',
                            400: '#9bb98b',
                            500: '#779c69',
                            600: '#557d54',
                            700: '#326b4c',
                            800: '#2b5840',
                            900: '#244734',
                        }
                    }
                }
            }
        }
    </script>

    <style>
        body {
            font-family: 'DM Sans', sans-serif;
            background: #f7f9f8;
            color: #242d2a;
            -webkit-font-smoothing: antialiased;
        }

        h1, h2, h3, .font-display {
            font-family: 'Manrope', sans-serif;
        }

        .hero-surface {
            background:
                radial-gradient(90% 75% at 0% 0%, #edf6e5 0%, rgba(247, 250, 244, 0) 58%),
                radial-gradient(80% 70% at 100% 100%, #e6f0dc 0%, rgba(245, 248, 241, 0) 62%),
                linear-gradient(180deg, #f6faf2 0%, #f1f7ec 100%);
        }

        .auth-canvas {
            background:
                radial-gradient(110% 90% at 100% 0%, #eff6e8 0%, rgba(247, 250, 243, 0) 46%),
                radial-gradient(90% 80% at 0% 100%, #edf3e6 0%, rgba(247, 249, 248, 0) 52%),
                linear-gradient(180deg, #f7faf4 0%, #f5f8f2 100%);
        }

        .dot-field {
            background-image: radial-gradient(#c8d9bb 1.1px, transparent 1.1px);
            background-size: 21px 21px;
        }

        .brand-tile {
            display: inline-grid;
            place-items: center;
            background: linear-gradient(135deg, #3f7b58 0%, #2f6547 55%, #27563c 100%);
            box-shadow: 0 4px 10px -2px rgba(36, 82, 57, 0.45);
        }

        .preview-shadow {
            box-shadow:
                0 1px 2px rgba(35, 70, 49, 0.04),
                0 8px 24px -6px rgba(35, 70, 49, 0.08),
                0 22px 44px -14px rgba(35, 70, 49, 0.1);
        }

        .auth-card-shadow {
            box-shadow:
                0 1px 2px rgba(35, 70, 49, 0.03),
                0 10px 28px -8px rgba(35, 70, 49, 0.08),
                0 26px 54px -18px rgba(35, 70, 49, 0.12);
        }

        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>
<body class="min-h-screen font-sans text-ink selection:bg-[#dce8d2] selection:text-[#244734]">
    @yield('content')
</body>
</html>
