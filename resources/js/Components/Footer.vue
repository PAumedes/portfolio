<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <footer class="border-t border-zinc-800 bg-zinc-950">
        <div class="max-w-7xl mx-auto px-4 md:px-12 py-12">
            <div class="flex items-center justify-between">
                <p class="text-zinc-500 text-sm">&copy; {{ new Date().getFullYear() }} Patricio Aumedes</p>

                <div class="flex gap-6">
                    <a
                        href="https://instagram.com/patricioaumedes.ph"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="text-zinc-400 hover:text-white transition-colors"
                        aria-label="Instagram"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect width="20" height="20" x="2" y="2" rx="5" ry="5" />
                            <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37" />
                            <circle cx="17.5" cy="6.5" r="1.5" />
                        </svg>
                    </a>
                    <a
                        href="https://behance.net/381studios"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="text-zinc-400 hover:text-white transition-colors"
                        aria-label="Behance"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 7h16M4 12h16M4 17h16" />
                        </svg>
                    </a>
                    <Link
                        href="/contact"
                        class="text-zinc-400 hover:text-white transition-colors"
                        aria-label="Contact"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                            <polyline points="22,6 12,13 2,6" />
                        </svg>
                    </Link>
                    <Link
                        href="/about"
                        class="text-zinc-400 hover:text-white transition-colors"
                        aria-label="About"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10" />
                            <path d="M12 16v-4M12 8h.01" />
                        </svg>
                    </Link>
                </div>
            </div>
        </div>
    </footer>
</template>

<style scoped>
a:focus-visible {
    outline: 2px solid white;
    outline-offset: 2px;
}
</style>
