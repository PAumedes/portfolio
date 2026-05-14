<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import { formatDistanceToNow } from 'date-fns';
import { Button } from '@/Components/ui/button';
import AdminLayout from '@/Layouts/AdminLayout.vue';

defineProps({
    notifications: Object,
});

const markAsRead = (id) => {
    router.post(route('admin.notifications.read', id));
};

const markAllAsRead = () => {
    router.post(route('admin.notifications.read-all'));
};
</script>

<template>
    <AdminLayout>
        <Head title="Admin - Notifications" />

        <div class="p-6 md:p-12">
            <header class="flex flex-col md:flex-row md:items-center justify-between mb-12 gap-6">
                <div>
                    <h1 class="text-4xl font-light tracking-tight text-white mb-2">Notifications</h1>
                    <p class="text-zinc-400">Manage your incoming inquiries and system alerts.</p>
                </div>
                
                <div class="flex items-center gap-4">
                    <Button 
                        v-if="notifications.data.some(n => !n.read_at)"
                        variant="outline" 
                        class="border-zinc-800 text-zinc-300 hover:bg-zinc-900 hover:text-white"
                        @click="markAllAsRead"
                    >
                        Mark all as read
                    </Button>
                </div>
            </header>


            <div v-if="notifications.data.length === 0" class="flex flex-col items-center justify-center py-24 border border-dashed border-zinc-800 rounded-2xl bg-zinc-900/20">
                <div class="w-12 h-12 rounded-full bg-zinc-900 flex items-center justify-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="text-zinc-500"><path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/></svg>
                </div>
                <p class="text-zinc-400 font-medium">All caught up!</p>
                <p class="text-zinc-600 text-sm mt-1">No new notifications at the moment.</p>
            </div>

            <div v-else class="space-y-4">
                <div 
                    v-for="notification in notifications.data" 
                    :key="notification.id"
                    class="group relative overflow-hidden bg-zinc-900/40 border border-zinc-900 hover:border-zinc-800 transition-all duration-300 rounded-2xl p-6"
                    :class="{ 'opacity-60': notification.read_at }"
                >
                    <div class="flex items-start justify-between gap-4">
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-2">
                                <span 
                                    v-if="!notification.read_at" 
                                    class="w-2 h-2 rounded-full bg-blue-500 shadow-[0_0_10px_rgba(59,130,246,0.5)]"
                                ></span>
                                <h3 class="text-lg font-medium text-white">
                                    {{ notification.data.name }} — New Inquiry
                                </h3>
                                <span class="text-xs text-zinc-600 font-mono">
                                    {{ formatDistanceToNow(new Date(notification.created_at), { addSuffix: true }) }}
                                </span>
                            </div>
                            
                            <p class="text-zinc-300 leading-relaxed mb-4 max-w-2xl">
                                "{{ notification.data.message }}"
                            </p>
                            
                            <div class="flex items-center gap-6 text-sm">
                                <a :href="`mailto:${notification.data.email}`" class="text-zinc-400 hover:text-white transition-colors flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                                    {{ notification.data.email }}
                                </a>
                            </div>
                        </div>

                        <button 
                            v-if="!notification.read_at"
                            @click="markAsRead(notification.id)"
                            class="p-2 rounded-lg bg-zinc-800/50 text-zinc-400 hover:text-white hover:bg-zinc-800 transition-all opacity-0 group-hover:opacity-100 focus:opacity-100"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Pagination -->
            <div v-if="notifications.links && notifications.links.length > 3" class="mt-12 flex justify-center gap-2">
                <template v-for="(link, k) in notifications.links" :key="k">
                    <Link
                        v-if="link.url"
                        :href="link.url"
                        v-html="link.label"
                        class="px-4 py-2 text-sm rounded-lg border transition-all"
                        :class="{ 
                            'bg-white text-zinc-950 border-white': link.active,
                            'bg-zinc-900 text-zinc-400 border-zinc-800 hover:border-zinc-600': !link.active 
                        }"
                    />
                </template>
            </div>
        </div>
    </AdminLayout>
</template>



<style>
@font-face {
    font-family: 'Satoshi';
    src: url('/fonts/Satoshi-Variable.woff2') format('woff2');
    font-weight: 300 900;
    font-display: swap;
    font-style: normal;
}

.font-satoshi {
    font-family: 'Satoshi', sans-serif;
}
</style>
