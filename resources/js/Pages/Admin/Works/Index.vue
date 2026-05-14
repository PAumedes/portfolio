<script setup>
import { Head, Link } from '@inertiajs/vue3';
import Button from '@/Components/ui/button/Button.vue';

defineProps({
    works: Array,
});
</script>

<template>
    <Head title="Backoffice - Works" />

    <div class="min-h-screen bg-zinc-950 text-white p-8">
        <div class="max-w-6xl mx-auto">
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-3xl font-bold tracking-tighter">Works</h1>
                <div class="flex gap-4">
                    <Button asChild class="bg-white text-zinc-950 hover:bg-zinc-200">
                        <Link href="/admin/works/create">Add New Work</Link>
                    </Button>
                    <Button asChild variant="outline">
                        <Link href="/logout" method="post" as="button">Logout</Link>
                    </Button>
                </div>
            </div>

            <div v-if="$page.props.flash?.success" class="bg-green-500/20 text-green-400 p-4 rounded-lg mb-6 border border-green-500/30">
                {{ $page.props.flash.success }}
            </div>

            <div class="bg-zinc-900 border border-zinc-800 rounded-xl overflow-hidden">
                <table class="w-full text-left text-sm">
                    <thead class="bg-zinc-950 border-b border-zinc-800 text-zinc-400">
                        <tr>
                            <th class="px-6 py-4 font-medium">Image</th>
                            <th class="px-6 py-4 font-medium">Title</th>
                            <th class="px-6 py-4 font-medium">Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-800">
                        <tr v-for="work in works" :key="work.id" class="hover:bg-zinc-800/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="w-16 h-16 bg-zinc-800 rounded overflow-hidden" v-if="work.media && work.media.length">
                                    <img :src="work.media[0].original_url" alt="" class="w-full h-full object-cover" />
                                </div>
                                <div class="w-16 h-16 bg-zinc-800 rounded flex items-center justify-center text-xs text-zinc-500" v-else>
                                    No img
                                </div>
                            </td>
                            <td class="px-6 py-4 font-medium">{{ work.title }}</td>
                            <td class="px-6 py-4 text-zinc-400">{{ new Date(work.created_at).toLocaleDateString() }}</td>
                        </tr>
                        <tr v-if="works.length === 0">
                            <td colspan="3" class="px-6 py-8 text-center text-zinc-500">No works uploaded yet.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>
