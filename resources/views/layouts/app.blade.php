<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Apotek JUJU') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] { display: none !important; }
        
        /* Custom Scrollbar Mewah */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f8fafc; }
        ::-webkit-scrollbar-thumb { background: #6366f1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #4f46e5; }

        /* Animasi Fade In Up Halus */
        .animate-fade-in-up {
            animation: fadeInUp 0.5s ease-out forwards;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>

    @stack('styles')
</head>

<body class="font-sans antialiased bg-slate-50 dark:bg-gray-900 text-slate-900 dark:text-slate-100 selection:bg-indigo-500 selection:text-white">
    
    <div class="min-h-screen flex flex-col">
        @include('layouts.navigation')

        @isset($header)
            <header class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-md sticky top-0 z-20 border-b border-slate-200 dark:border-gray-700 shadow-sm">
                <div class="max-w-7xl mx-auto py-5 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <main class="flex-grow">
            <div class="py-8 animate-fade-in-up">
                {{ $slot }}
            </div>
        </main>

        <footer class="bg-white dark:bg-gray-800 border-t border-slate-200 dark:border-gray-700 py-8">
            <div class="max-w-7xl mx-auto px-4">
                <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                    <div class="text-sm text-slate-500 dark:text-slate-400">
                        &copy; {{ date('Y') }} <span class="font-bold text-indigo-600">Apotek JUJU</span>. Politeknik LP3I Tasikmalaya.
                    </div>
                    <div class="flex space-x-6 text-slate-400">
                        <i class="fab fa-laravel hover:text-red-500 transition-colors"></i>
                        <i class="fab fa-php hover:text-indigo-400 transition-colors"></i>
                        <i class="fab fa-apple hover:text-black dark:hover:text-white transition-colors"></i>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    @stack('scripts')
</body>

</html>