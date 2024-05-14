<script lang="ts" setup>
import Pagination from "@/Components/Pagination.vue";
import StudentLayout from "@/Layouts/StudentLayout.vue";
import { Link, usePage, Head } from "@inertiajs/vue3";

const page = usePage();

const videos = page.props.videos as any;
</script>
<template>

    <Head title="Videos List" />
    <StudentLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="font-semibold mr-2 text-xl text-gray-800 dark:text-gray-200 leading-tight">Videos</h2>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Videos List</h2>
                </div>
                <div v-if="!($page.props.videos as any).data.length"
                    class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        In this page, you can watch videos. Please wait once the teacher has added videos.
                    </div>
                </div>
                <div v-else>
                    <div class="text-white grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        <Link :href="`/videos/${video.id}`" v-for="video in videos.data"
                            class="border border-gray-500 dark:text-gray-200 aspect-video rounded-2xl flex items-end relative overflow-hidden">
                        <img :src="`https://img.youtube.com/vi/${video.link}/0.jpg`"
                            class="object-cover h-full w-full border brightness-75" alt="">
                        <div class="p-4 absolute bg-black/75 w-full">
                            <h2 class="text-2xl">{{ video.title }}</h2>
                        </div>
                        </Link>
                        <div
                            class="md:col-span-2 lg:col-span-3 grid grid-cols-5 gap-2 mx-auto items-center justify-center">
                            <Pagination :resource="videos" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </StudentLayout>
</template>