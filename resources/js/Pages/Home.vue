<script setup>
import { Head, Link } from '@inertiajs/vue3';
import Button from '@/Components/ui/button/Button.vue';
</script>

<template>
    <Head title="Crafting Digital Luxury">
        <meta name="description" content="I build high-end, performant, and beautifully animated web experiences utilizing Laravel, Vue, and cutting-edge architecture." />
        <meta property="og:title" content="Crafting Digital Luxury" />
        <meta property="og:description" content="I build high-end, performant, and beautifully animated web experiences." />
        <meta property="og:type" content="website" />
    </Head>
    <div class="min-h-screen bg-zinc-950 flex flex-col justify-center items-center p-4 relative overflow-hidden">
        <!-- Abstract gradient blob for high-end feel -->
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-white/5 blur-[120px] rounded-full pointer-events-none"></div>

        <h1 class="text-white text-5xl md:text-7xl font-bold tracking-tighter mb-6 reveal-item text-center">
            Crafting Digital Luxury.
        </h1>
        <p class="text-zinc-400 text-lg md:text-xl max-w-2xl text-center mb-10 reveal-item" style="animation-delay: 200ms;">
            I build high-end, performant, and beautifully animated web experiences utilizing Laravel, Vue, and cutting-edge architecture.
        </p>
        <div class="flex gap-4 reveal-item relative z-10" style="animation-delay: 400ms;">
            <Button asChild size="lg" class="bg-white text-zinc-950 hover:bg-zinc-200">
                <Link href="/portfolio">View Portfolio</Link>
            </Button>
            <Button asChild variant="outline" size="lg">
                <Link href="/contact">Get in Touch</Link>
            </Button>
        </div>
    </div>
</template>

<style scoped>
.reveal-item {
    opacity: 0;
    transform: translateY(20px);
    animation: reveal 1.2s cubic-bezier(0.25, 1, 0.5, 1) forwards;
}

@keyframes reveal {
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>
