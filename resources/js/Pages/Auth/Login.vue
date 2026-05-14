<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import Button from '@/Components/ui/button/Button.vue';

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post('/login', {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <Head title="Backoffice Login" />

    <div class="min-h-screen bg-zinc-950 flex flex-col justify-center items-center p-4 relative overflow-hidden">
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-white/5 blur-[120px] rounded-full pointer-events-none"></div>

        <div class="w-full max-w-md bg-zinc-900 border border-zinc-800 rounded-xl p-8 relative z-10 shadow-2xl">
            <h1 class="text-white text-3xl font-bold tracking-tighter mb-6 text-center">
                Backoffice
            </h1>
            
            <form @submit.prevent="submit" class="space-y-4">
                <div>
                    <label for="email" class="block text-sm font-medium text-zinc-400 mb-1">Email</label>
                    <input
                        id="email"
                        v-model="form.email"
                        type="email"
                        class="w-full bg-zinc-950 border border-zinc-800 rounded-lg px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-white/20 transition-all"
                        required
                        autofocus
                    />
                    <div v-if="form.errors.email" class="text-red-400 text-sm mt-1">{{ form.errors.email }}</div>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-zinc-400 mb-1">Password</label>
                    <input
                        id="password"
                        v-model="form.password"
                        type="password"
                        class="w-full bg-zinc-950 border border-zinc-800 rounded-lg px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-white/20 transition-all"
                        required
                    />
                    <div v-if="form.errors.password" class="text-red-400 text-sm mt-1">{{ form.errors.password }}</div>
                </div>

                <div class="flex items-center">
                    <input id="remember" v-model="form.remember" type="checkbox" class="rounded border-zinc-800 bg-zinc-950 text-white focus:ring-white/20" />
                    <label for="remember" class="ml-2 block text-sm text-zinc-400">Remember me</label>
                </div>

                <div class="pt-2">
                    <Button type="submit" class="w-full bg-white text-zinc-950 hover:bg-zinc-200" :disabled="form.processing">
                        Log in
                    </Button>
                </div>
            </form>
        </div>
    </div>
</template>
