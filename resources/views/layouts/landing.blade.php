<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Ani-Senso Academy'))</title>

    <!-- Fonts - Instrument Sans & Nunito Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600;700&family=Nunito+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Nunito Sans', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                        heading: ['Instrument Sans', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                    },
                    colors: {
                        'brand-dark': '#1a1a1a',
                        'brand-yellow': '#f5c518',
                        'brand-yellow-hover': '#e6b800',
                        'brand-green': '#4a7c2a',
                        'brand-green-hover': '#3d6823',
                        'brand-green-dark': '#2d5016',
                        'brand-green-light': '#6b9f3d',
                        'brand-olive': '#5a6f2a',
                    }
                }
            }
        }
    </script>

    <!-- Alpine.js with Intersect & Collapse Plugins -->
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/intersect@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }

        /* Smooth scrolling */
        html {
            scroll-behavior: smooth;
        }
    </style>

    @stack('styles')
</head>
<body class="min-h-screen bg-white font-sans antialiased">
    @yield('content')

    @include('layouts.partials.chat-widget')

    @stack('scripts')
</body>
</html>
