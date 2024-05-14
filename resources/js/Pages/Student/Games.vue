<script lang="ts" setup>
import Pagination from "@/Components/Pagination.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Link, router, usePage } from "@inertiajs/vue3";

const page = usePage();

const games = page.props.games as any;
</script>

<template>
    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                    <h2 class="font-semibold mr-2 text-xl text-gray-800 dark:text-gray-200 leading-tight">Games</h2>
                </div>
        </template>
        <div class="py-12">
                <div class="max-w-7xl mx-auto px-6 lg:px-8">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Games List</h2>
                    </div>
                    <div v-if="!($page.props.games as any).data.length" class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900 dark:text-gray-100">
                            In this page, you can answer your games. Please wait for the teacher to add new games.
                        </div>
                    </div>
                    <div v-else>
                        <div class="text-gray-900 dark:text-gray-100 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                            <Link :href="`/games/${game.id}`" v-for="game in games.data" class="border border-gray-500 dark:text-gray-200 h-64 rounded-2xl flex items-end">
                                <div class="p-8">
                                    <h2 class="text-2xl">{{ game.title }}</h2>
                                    <p>{{ game.description || 'No description provided.' }}</p>
                                </div>
                            </Link>
                            <div class="md:col-span-2 lg:col-span-3 grid grid-cols-5 gap-2 mx-auto items-center justify-center">
                                <Pagination :resource="games" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </AuthenticatedLayout>
</template>