<script lang="ts" setup>
import Pagination from "@/Components/Pagination.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import TeacherLayout from "@/Layouts/TeacherLayout.vue";
import { Link, router, usePage } from "@inertiajs/vue3";

const page = usePage();

const games = page.props.games as any;
</script>

<template>
    <TeacherLayout>
        <template #header>
            <div class="flex items-center justify-between">
                    <h2 class="font-semibold mr-2 text-xl text-gray-800 dark:text-gray-200 leading-tight">Games</h2>
                <form class="flex items-center gap-4 ml-2" action="">
                    <select
                        class="w-fit g-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        name="quarter" id="">
                        <option value="" selected>Select a Quarter</option>
                        <option value="1">1st Quarter</option>
                        <option value="2">2nd Quarter</option>
                        <option value="3">3rd Quarter</option>
                        <option value="4">4th Quarter</option>
                    </select>
                    <select
                        class="w-fit g-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        name="quarter" id="">
                        <option value="" selected>Select a Grade Level</option>
                        <option value="1">Grade 1</option>
                        <option value="2">Grade 2</option>
                        <option value="3">Grade 3</option>
                        <option value="4">Grade 4</option>
                    </select>
                    <button
                        class="w-fit g-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg  focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    >Filter
                    </button>
                    </form>
                </div>
        </template>
        <div class="py-12">
                <div class="max-w-7xl mx-auto px-6 lg:px-8">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Games List</h2>
                        <PrimaryButton @click="router.visit('/games/build')">New Game</PrimaryButton>
                    </div>
                    <div v-if="!($page.props.games as any).data.length" class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900 dark:text-gray-100">
                            In this page, you can add games for your students. To add a game, you can click the New Game button.
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
    </TeacherLayout>
</template>