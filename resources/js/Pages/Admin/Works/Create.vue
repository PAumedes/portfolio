<script setup>
import { Head, useForm, Link } from '@inertiajs/vue3';
import Button from '@/Components/ui/button/Button.vue';
import { ref } from 'vue';

const form = useForm({
    title: '',
    description: '',
    image: null,
});

const imagePreview = ref(null);

const handleImageChange = (e) => {
    const file = e.target.files[0];
    if (file) {
        form.image = file;
        const reader = new FileReader();
        reader.onload = (e) => {
            imagePreview.ref = e.target.result;
            imagePreview.value = e.target.result;
        };
        reader.readAsDataURL(file);
    }
};

const submit = () => {
    form.post('/admin/works', {
        preserveScroll: true,
    });
};
</script>

<template>
    <Head title="Add New Work" />

    <div class="min-h-screen bg-zinc-950 text-white p-8">
        <div class="max-w-2xl mx-auto">
            <div class="flex items-center gap-4 mb-8">
                <Link href="/admin/works" class="text-zinc-400 hover:text-white transition-colors">
                    &larr; Back
                </Link>
                <h1 class="text-3xl font-bold tracking-tighter">Add New Work</h1>
            </div>

            <div class="bg-zinc-900 border border-zinc-800 rounded-xl p-8">
                <form @submit.prevent="submit" class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-zinc-400 mb-2">Title</label>
                        <input
                            v-model="form.title"
                            type="text"
                            class="w-full bg-zinc-950 border border-zinc-800 rounded-lg px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-white/20 transition-all"
                            required
                        />
                        <div v-if="form.errors.title" class="text-red-400 text-sm mt-1">{{ form.errors.title }}</div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-zinc-400 mb-2">Description</label>
                        <textarea
                            v-model="form.description"
                            rows="4"
                            class="w-full bg-zinc-950 border border-zinc-800 rounded-lg px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-white/20 transition-all"
                            required
                        ></textarea>
                        <div v-if="form.errors.description" class="text-red-400 text-sm mt-1">{{ form.errors.description }}</div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-zinc-400 mb-2">Image</label>
                        <div class="border-2 border-dashed border-zinc-800 rounded-lg p-8 text-center" :class="{'bg-zinc-950': !imagePreview}">
                            <input
                                type="file"
                                id="image"
                                accept="image/*"
                                class="hidden"
                                @change="handleImageChange"
                                required
                            />
                            <label v-if="!imagePreview" for="image" class="cursor-pointer text-zinc-400 hover:text-white transition-colors">
                                <span class="block mb-2">Click to browse or drag image here</span>
                                <span class="text-xs text-zinc-600">JPG, PNG, WEBP (Max 10MB)</span>
                            </label>
                            <div v-else class="relative">
                                <img :src="imagePreview" class="max-h-64 mx-auto rounded" />
                                <button type="button" @click="imagePreview = null; form.image = null" class="absolute top-2 right-2 bg-zinc-900/80 text-white p-2 rounded-full hover:bg-zinc-900 transition-colors">
                                    &times;
                                </button>
                            </div>
                        </div>
                        <div v-if="form.errors.image" class="text-red-400 text-sm mt-1">{{ form.errors.image }}</div>
                    </div>

                    <div class="pt-4 flex justify-end">
                        <Button type="submit" class="bg-white text-zinc-950 hover:bg-zinc-200" :disabled="form.processing">
                            Upload Work
                        </Button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
