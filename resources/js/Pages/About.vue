<script setup>
import { Head, Link } from '@inertiajs/vue3';
import Footer from '@/Components/Footer.vue';
</script>

<template>
    <Head title="About">
        <meta name="description" content="Learn about my approach to digital design and development." />
        <meta property="og:title" content="About - Portfolio" />
    </Head>

    <div class="min-h-screen bg-zinc-950 text-zinc-100">
        <!-- Header -->
        <div class="border-b border-zinc-800">
            <div class="max-w-6xl mx-auto px-4 md:px-8 py-16">
                <Link href="/" class="text-zinc-400 hover:text-white transition-colors mb-6 inline-block">
                    ← Back to Portfolio
                </Link>
                <h1 class="text-5xl md:text-6xl font-bold tracking-tight mb-6">About</h1>
            </div>
        </div>

        <!-- Content -->
        <div class="max-w-3xl mx-auto px-4 md:px-8 py-16">
            <div class="space-y-8 text-lg leading-relaxed">
                <p class="text-zinc-300">
                    I'm a digital designer and developer with a passion for creating elegant, minimalist experiences.
                    Each project is an opportunity to explore the intersection of aesthetics and functionality,
                    crafting work that speaks through its simplicity and precision.
                </p>

                <p class="text-zinc-300">
                    My approach focuses on understanding your vision and translating it into timeless digital experiences
                    that stand apart from the ordinary. I believe that great design is invisible—it doesn't call attention
                    to itself, but rather enhances the experience and makes the user's journey seamless.
                </p>

                <div class="border-t border-zinc-800 pt-8 mt-12">
                    <h2 class="text-2xl font-bold mb-6">Approach</h2>
                    <p class="text-zinc-300 mb-6">
                        Every project begins with understanding. I take time to listen, analyze, and immerse myself
                        in the context of what needs to be created. This foundation informs every decision, from the
                        initial concept through to the final pixel.
                    </p>
                    <p class="text-zinc-300">
                        I believe in the power of constraints. Limitations fuel creativity and push us toward elegant solutions.
                        Whether it's a complex web application or a minimal brand identity, I approach each challenge with the
                        same commitment to craftsmanship and attention to detail.
                    </p>
                </div>

                <div class="border-t border-zinc-800 pt-8 mt-12">
                    <h2 class="text-2xl font-bold mb-6">Get in Touch</h2>
                    <p class="text-zinc-300 mb-8">
                        Interested in collaborating on a project? I'd love to hear about your vision.
                    </p>
                    <Link
                        href="/contact"
                        class="inline-block px-8 py-3 bg-white text-zinc-950 rounded-lg font-medium hover:bg-zinc-200 transition-colors"
                    >
                        Contact Me
                    </Link>
                </div>
            </div>
        </div>
    </div>

    <Footer />
</template>

<style scoped>
a:focus-visible {
    outline: 2px solid white;
    outline-offset: 2px;
}
</style>
