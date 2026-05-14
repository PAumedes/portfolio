<script setup>
import { Link } from '@inertiajs/vue3';
import { Button } from '@/Components/ui/button';

const navItems = [
    { name: 'Works', href: route('admin.works.index') },
    { name: 'Notifications', href: route('admin.notifications.index') },
];

</script>

<template>
    <div class="min-h-screen bg-zinc-950 text-zinc-100 font-satoshi flex">
        <!-- Sidebar -->
        <aside class="w-64 border-r border-zinc-900 flex flex-col fixed inset-y-0 left-0 z-50 bg-zinc-950">
            <div class="p-8">
                <Link :href="route('home')" class="block">
                    <h2 class="text-xl font-bold tracking-tighter text-white">PORTFOLIO<span class="text-zinc-600">.</span>ADMIN</h2>
                </Link>
            </div>

            <nav class="flex-1 px-4 space-y-1">
                <Link 
                    v-for="item in navItems" 
                    :key="item.name"
                    :href="item.href"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all"
                    :class="route().current(item.href.split('/').pop() + '*') ? 'bg-white text-zinc-950' : 'text-zinc-400 hover:text-white hover:bg-zinc-900'"
                >
                    <!-- Work Icon -->
                    <svg v-if="item.name === 'Works'" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="16" height="13" x="4" y="7" rx="2"/><path d="M9 21v-4a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v4"/><path d="M15 21H9"/><path d="M8 7V5a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                    <!-- Bell Icon -->
                    <svg v-if="item.name === 'Notifications'" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/></svg>
                    {{ item.name }}
                </Link>

            </nav>

            <div class="p-8 border-t border-zinc-900">
                <Link 
                    :href="route('logout')" 
                    method="post" 
                    as="button"
                    class="flex items-center gap-3 text-sm text-zinc-500 hover:text-red-400 transition-colors"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" x2="9" y1="12" y2="12"/></svg>
                    Logout
                </Link>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 ml-64 min-h-screen">
            <slot />
        </main>
    </div>
</template>

<style>
@font-face {
    font-family: 'Satoshi';
    src: url('/fonts/Satoshi-Variable.woff2') format('woff2');
    font-weight: 300 900;
    font-display: swap;
    font-style: normal;
}

.font-satoshi {
    font-family: 'Satoshi', sans-serif;
}
</style>
