<script lang="ts" setup>
import { Head, Link, usePage } from '@inertiajs/vue3';
import Pagination from '@/Components/Pagination.vue';
import StudentLayout from '@/Layouts/StudentLayout.vue';

const page = usePage();
const printables = page.props.printables as any;
</script>

<template>
    <div>

        <Head title="Printable Documents" />

        <StudentLayout>
            <template #header>
                <div class="flex items-center justify-between">
                    <h2 class="font-semibold mr-2 text-xl text-gray-800 dark:text-gray-200 leading-tight">Printable Documents</h2>
                </div>
            </template>

            <div class="py-12">
                <div class="max-w-7xl mx-auto px-6 lg:px-8">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Printable Documents List</h2>
                    </div>
                    <div v-if="!($page.props.printables as any).data.length" class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900 dark:text-gray-100">
                            In this page, you can add documents for your students. To add a worksheet, you can click
                            the
                            new
                            printable button, and upload a PDF document.
                        </div>
                    </div>
                    <div v-else>
                        <div class="text-gray-900 dark:text-gray-100 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                            <Link :href="`/printables/${printable.id}`" v-for="printable in printables.data" class="border border-gray-500 dark:text-gray-200 h-64 rounded-2xl flex items-end">
                                <div class="p-8">
                                    <h2 class="text-2xl">{{ printable.title }}</h2>
                                    <p>{{ printable.description || 'No description provided.' }}</p>
                                </div>
                            </Link>
                            <div class="md:col-span-2 lg:col-span-3 grid grid-cols-5 gap-2 mx-auto items-center justify-center">
                                <Pagination :resource="printables" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </StudentLayout>
    </div>
</template>