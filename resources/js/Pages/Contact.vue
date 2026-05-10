<script setup>
import { Head } from '@inertiajs/vue3';
import { useForm } from '@inertiajs/vue3';
import Button from '@/Components/ui/button/Button.vue';

const form = useForm({
    name: '',
    email: '',
    message: '',
});

const submit = () => {
    form.post('/contact', {
        preserveScroll: true,
        onSuccess: () => form.reset(),
    });
};
</script>

<template>
    <Head title="Contact">
        <meta name="description" content="Ready to start your next luxury web project? Get in touch." />
        <meta property="og:title" content="Contact Me" />
        <meta property="og:description" content="Ready to start your next luxury web project? Reach out today." />
    </Head>
    <div class="min-h-screen bg-zinc-950 flex justify-center items-center p-4">
        <div class="w-full max-w-lg bg-zinc-900 border border-zinc-800 p-8 rounded-xl shadow-2xl reveal-item">
            <h2 class="text-3xl font-bold text-white tracking-tight mb-2">Get in touch</h2>
            <p class="text-zinc-400 mb-8">Ready to start your next luxury web project? Reach out.</p>

            <div v-if="$page.props.flash && $page.props.flash.success" class="mb-6 p-4 bg-green-500/10 border border-green-500/20 text-green-400 rounded-md">
                {{ $page.props.flash.success }}
            </div>

            <form @submit.prevent="submit" class="space-y-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-zinc-300 mb-1">Name</label>
                    <input id="name" v-model="form.name" type="text" class="w-full bg-zinc-950 border border-zinc-800 rounded-md px-4 py-2 text-white focus:outline-none focus:ring-1 focus:ring-white transition-shadow" />
                    <div v-if="form.errors.name" class="text-red-400 text-xs mt-1">{{ form.errors.name }}</div>
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-zinc-300 mb-1">Email</label>
                    <input id="email" v-model="form.email" type="email" class="w-full bg-zinc-950 border border-zinc-800 rounded-md px-4 py-2 text-white focus:outline-none focus:ring-1 focus:ring-white transition-shadow" />
                    <div v-if="form.errors.email" class="text-red-400 text-xs mt-1">{{ form.errors.email }}</div>
                </div>

                <div>
                    <label for="message" class="block text-sm font-medium text-zinc-300 mb-1">Message</label>
                    <textarea id="message" v-model="form.message" rows="4" class="w-full bg-zinc-950 border border-zinc-800 rounded-md px-4 py-2 text-white focus:outline-none focus:ring-1 focus:ring-white transition-shadow"></textarea>
                    <div v-if="form.errors.message" class="text-red-400 text-xs mt-1">{{ form.errors.message }}</div>
                </div>

                <Button type="submit" class="w-full bg-white text-zinc-950 hover:bg-zinc-200" :disabled="form.processing">
                    {{ form.processing ? 'Sending...' : 'Send Message' }}
                </Button>
            </form>
        </div>
    </div>
</template>

<style scoped>
.reveal-item {
    opacity: 0;
    transform: translateY(20px);
    animation: reveal 1s cubic-bezier(0.25, 1, 0.5, 1) forwards;
}

@keyframes reveal {
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>
