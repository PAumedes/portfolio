<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { useReveal } from '@/Composables/useReveal';

defineProps({
    works: Object, // Inertia returns Resources as objects with a 'data' key
});

const { galleryRefs } = useReveal();
</script>


<template>
    <Head title="Portfolio">
        <meta name="description" content="View my curated collection of high-end digital luxury web applications and architectural experiments." />
        <meta property="og:title" content="Selected Works - Portfolio" />
    </Head>
    
    <div class="min-h-screen bg-zinc-950 p-4 md:p-12">
        <div class="masonry-grid max-w-7xl mx-auto gap-px bg-zinc-800 border border-zinc-800">
            <article 
                v-for="(work, index) in works.data" 
                :key="work.id"
                ref="galleryRefs"
                class="masonry-item reveal-item relative overflow-hidden bg-zinc-950"
            >
                <picture v-if="work.media && work.media.length > 0">
                    <source :srcset="work.media[0].preview" type="image/avif" />
                    <source :srcset="work.media[0].preview_fallback" type="image/webp" />
                    <img 
                        :src="work.media[0].preview_fallback" 
                        :alt="work.title"
                        loading="lazy"
                        class="w-full h-auto object-cover grayscale transition-all duration-1000 hover:grayscale-0"
                    />
                </picture>
                
                <div class="absolute bottom-0 left-0 w-full p-4 bg-gradient-to-t from-black/80 to-transparent opacity-0 transition-opacity duration-500 hover:opacity-100 flex flex-col justify-end">
                    <h2 class="text-white text-xl font-medium">{{ work.title }}</h2>
                    <p class="text-zinc-300 text-sm mt-1">{{ work.description }}</p>
                </div>
            </article>
        </div>

        <Link 
            :href="route('contact.show')"
            class="fixed bottom-8 right-8 z-50 group flex items-center gap-3 px-6 py-4 bg-white text-zinc-950 rounded-full shadow-2xl hover:scale-105 transition-all duration-500"
        >
            <span class="text-sm font-medium tracking-wide uppercase">Get in touch</span>
            <div class="w-8 h-8 rounded-full bg-zinc-950 text-white flex items-center justify-center group-hover:rotate-45 transition-transform duration-500">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m5 12 7-7 7 7"/><path d="M12 19V5"/></svg>
            </div>
        </Link>
    </div>
</template>


<style scoped>
.masonry-grid {
    column-count: 1;
    column-gap: 1px;
}

@media (min-width: 768px) {
    .masonry-grid {
        column-count: 2;
    }
}

@media (min-width: 1024px) {
    .masonry-grid {
        column-count: 3;
    }
}

.masonry-item {
    break-inside: avoid;
    margin-bottom: 1px;
}

.reveal-item {
    opacity: 0;
    transform: translateY(20px);
    transition: opacity 1s cubic-bezier(0.25, 1, 0.5, 1), transform 1s cubic-bezier(0.25, 1, 0.5, 1);
}

.reveal-active {
    opacity: 1;
    transform: translateY(0);
}
</style>
