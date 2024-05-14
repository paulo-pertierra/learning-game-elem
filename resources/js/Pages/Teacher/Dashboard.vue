<script setup lang="ts">
import AdminLayout from '@/Layouts/AdminLayout.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, usePage } from '@inertiajs/vue3';

const page = usePage();
</script>

<template>
    <Head title="Dashboard" />

    <AdminLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Administrator Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 text-gray-800 dark:text-gray-200">
                
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg grid grid-cols-3">
                    <div class="h-[96px] flex items-center p-4 border m-2 rounded-lg text-2xl">
                        Worksheets: {{ page.props.statistics.worksheets }}
                    </div>
                    <div class="h-[96px] flex items-center p-4 border m-2 rounded-lg text-2xl">
                        Games: {{ page.props.statistics.games }}
                    </div>
                    <div class="h-[96px] flex items-center p-4 border m-2 rounded-lg text-2xl">
                        Videos: {{ page.props.statistics.videos }}
                    </div>
                    <div class="h-[96px] flex items-center p-4 border m-2 rounded-lg text-2xl">
                        Printables: {{ page.props.statistics.printables }}
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
