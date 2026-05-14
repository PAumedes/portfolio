<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import Footer from '@/Components/Footer.vue';

const props = defineProps({
    work: Object,
});

const selectedImageIndex = ref(0);
const selectedImage = computed(() =>
    props.work.media[selectedImageIndex.value] || props.work.media[0]
);
</script>

<template>
    <Head :title="props.work.title">
        <meta name="description" :content="`View ${props.work.title} project details`" />
    </Head>

    <div class="min-h-screen bg-zinc-950 text-zinc-100">
        <!-- Header -->
        <div class="border-b border-zinc-800">
            <div class="max-w-6xl mx-auto px-4 md:px-8 py-8">
                <Link href="/" class="text-zinc-400 hover:text-white transition-colors mb-6 inline-block">
                    ← Back to Portfolio
                </Link>
                <h1 class="text-4xl md:text-5xl font-bold tracking-tight">{{ props.work.title }}</h1>
                <p class="text-zinc-400 mt-4 text-lg max-w-2xl">{{ props.work.description }}</p>
            </div>
        </div>

        <!-- Gallery -->
        <div class="max-w-6xl mx-auto px-4 md:px-8 py-12">
            <!-- Main Image -->
            <div class="mb-8 overflow-hidden rounded-lg bg-zinc-900 border border-zinc-800">
                <picture v-if="selectedImage">
                    <source :srcset="selectedImage.preview" type="image/avif" />
                    <source :srcset="selectedImage.preview_fallback" type="image/webp" />
                    <img
                        :src="selectedImage.preview_fallback"
                        :alt="selectedImage.name"
                        class="w-full h-auto object-cover"
                    />
                </picture>
            </div>

            <!-- Thumbnails -->
            <div v-if="props.work.media.length > 1" class="grid grid-cols-4 md:grid-cols-6 gap-2 md:gap-4">
                <button
                    v-for="(media, index) in props.work.media"
                    :key="media.id"
                    @click="selectedImageIndex = index"
                    :class="[
                        'overflow-hidden rounded-lg border-2 transition-all duration-300',
                        selectedImageIndex === index
                            ? 'border-white'
                            : 'border-zinc-800 hover:border-zinc-700 opacity-60 hover:opacity-100'
                    ]"
                >
                    <picture>
                        <source :srcset="media.thumb" type="image/webp" />
                        <img
                            :src="media.thumb"
                            :alt="`Thumbnail ${index + 1}`"
                            class="w-full h-24 object-cover"
                        />
                    </picture>
                </button>
            </div>
        </div>

    </div>

    <Footer />
</template>

<style scoped>
button {
    outline: none;
}

button:focus-visible {
    outline: 2px solid white;
    outline-offset: 2px;
}
</style>
