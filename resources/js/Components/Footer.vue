<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <footer class="border-t border-zinc-800 bg-zinc-950">
        <div class="max-w-7xl mx-auto px-4 md:px-12 py-16">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                <!-- About Section -->
                <div>
                    <h3 class="text-xl font-bold text-white mb-4">About</h3>
                    <p class="text-zinc-400 leading-relaxed mb-6">
                        I'm a digital designer and developer with a passion for creating elegant, minimalist experiences.
                        Each project is an opportunity to explore the intersection of aesthetics and functionality,
                        crafting work that speaks through its simplicity and precision.
                    </p>
                    <p class="text-zinc-400 leading-relaxed">
                        My approach focuses on understanding your vision and translating it into timeless digital experiences
                        that stand apart from the ordinary. Let's create something exceptional together.
                    </p>
                </div>

                <!-- Social & Contact Section -->
                <div>
                    <h3 class="text-xl font-bold text-white mb-4">Connect</h3>
                    <p class="text-zinc-400 mb-6">
                        Interested in collaborating? Reach out via any of the platforms below or use the contact form.
                    </p>

                    <!-- Social Links -->
                    <div class="flex flex-col gap-3 mb-8">
                        <a
                            href="https://instagram.com/patricioaumedes.ph"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="text-zinc-400 hover:text-white transition-colors inline-flex items-center gap-2"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <rect width="20" height="20" x="2" y="2" rx="5" ry="5" />
                                <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37" />
                                <circle cx="17.5" cy="6.5" r="1.5" />
                            </svg>
                            Instagram
                        </a>
                        <a
                            href="https://behance.net/381studios"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="text-zinc-400 hover:text-white transition-colors inline-flex items-center gap-2"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M4 7h16M4 12h16M4 17h16" />
                            </svg>
                            Behance
                        </a>
                        <Link
                            href="/contact"
                            class="text-zinc-400 hover:text-white transition-colors inline-flex items-center gap-2"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                                <polyline points="22,6 12,13 2,6" />
                            </svg>
                            Contact
                        </Link>
                    </div>

                    <!-- Quick Links -->
                    <div class="pt-8 border-t border-zinc-800">
                        <p class="text-xs text-zinc-500 mb-4">Quick Links</p>
                        <div class="flex flex-col gap-2">
                            <Link href="/" class="text-zinc-400 hover:text-white text-sm transition-colors">
                                Portfolio
                            </Link>
                            <Link href="/contact" class="text-zinc-400 hover:text-white text-sm transition-colors">
                                Get in Touch
                            </Link>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Copyright -->
            <div class="border-t border-zinc-800 mt-12 pt-8 text-center text-zinc-500 text-sm">
                <p>&copy; {{ new Date().getFullYear() }} Patricio Aumedes. All rights reserved.</p>
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
