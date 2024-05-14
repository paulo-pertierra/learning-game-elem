<script lang="ts" setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue"
</script>

<template>
    <AuthenticatedLayout>
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
    </AuthenticatedLayout>
</template>