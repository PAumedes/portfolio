<script setup>
import { onMounted, ref } from 'vue';
import { Head } from '@inertiajs/vue3';

defineProps({
    works: Array,
});

const galleryRefs = ref([]);

onMounted(() => {
    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add('reveal-active');
            }
        });
    }, {
        threshold: 0.1,
    });

    galleryRefs.value.forEach((el) => {
        if (el) observer.observe(el);
    });
});
</script>

<template>
    <Head title="Portfolio">
        <meta name="description" content="View my curated collection of high-end digital luxury web applications and architectural experiments." />
        <meta property="og:title" content="Selected Works - Portfolio" />
    </Head>
    
    <div class="min-h-screen bg-zinc-950 p-4 md:p-12">
        <div class="masonry-grid max-w-7xl mx-auto gap-px bg-zinc-800 border border-zinc-800">
            <article 
                v-for="(work, index) in works" 
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
