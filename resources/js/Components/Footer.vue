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
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M6.938 4.503c.702 0 1.538.057 2.32.157 1.134.145 2.318.568 2.318 1.949 0 1.066-.849 1.505-1.958 1.505h-2.68V4.503zm0 6.305h2.926c1.678 0 2.57.847 2.57 2.219 0 1.406-1.182 2.324-2.929 2.324H6.938v-4.543zm10.827-1.034c-1.233 0-2.329.504-2.926 1.276-.396.55-.55 1.022-.55 2.05h5.404c0-.502-.089-1.179-.464-1.793-.504-.911-1.566-1.533-2.464-1.533zm2.721 5.563h-5.72c.088 1.24.791 1.993 1.938 1.993 1.039 0 1.75-.504 2.047-1.307h2.198c-.571 1.912-2.222 3.229-4.272 3.229-2.703 0-4.518-2.08-4.518-5.108 0-2.977 1.815-5.118 4.518-5.118 2.951 0 4.562 2.303 4.562 5.138v.173z" />
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
