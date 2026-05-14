<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <title inertia>{{ config('app.name', 'Portfolio') }}</title>
        
        <!-- Satoshi Font from Fontshare -->
        <link href="https://api.fontshare.com/v2/css?f[]=satoshi@900,700,500,300,400&display=swap" rel="stylesheet">
        
        @routes
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @inertiaHead
    </head>
    <body class="font-satoshi antialiased bg-zinc-50 text-zinc-900 dark:bg-zinc-950 dark:text-zinc-50">
        @inertia
    </body>
</html>
