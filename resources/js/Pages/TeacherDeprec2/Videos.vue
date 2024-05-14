<script lang="ts" setup>
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import Modal from "@/Components/Modal.vue";
import Pagination from "@/Components/Pagination.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Link, useForm, usePage, Head } from "@inertiajs/vue3";
import { onMounted } from "vue";
import { ref } from "vue";

onMounted(() => {

})

const page = usePage();

const videos = page.props.videos as any;

const addingNewVideo = ref(false);

const addNewVideoModal = () => {
    addingNewVideo.value = true;
}

const closeModal = () => {
    addingNewVideo.value = false;
}

const form = useForm({
    title: "",
    link: "",
    description: "",
    grade_level: 0,
    quarter: 0
})

const addNewVideo = () => {
    form.post('/videos', {
        onSuccess: _ => {
            closeModal();
        }
    });
}

</script>
<template>

    <Head title="Videos List" />
    <AdminLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="font-semibold mr-2 text-xl text-gray-800 dark:text-gray-200 leading-tight">Videos</h2>
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
                        class="w-fit g-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg  focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">Filter
                    </button>
                </form>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Videos List</h2>
                    <PrimaryButton @click="addNewVideoModal">New Video</PrimaryButton>
                </div>
                <div v-if="!($page.props.videos as any).data.length"
                    class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        In this page, you can add videos for your students. To add a video, you can click the new video
                        button,
                        and paste the YouTube link ID.
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

        <Modal :show="addingNewVideo">
            <form class="p-6" @submit.prevent="addNewVideo">
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    Add New Video
                </h2>
                <div class="my-4">
                    <InputLabel>Video Name</InputLabel>
                    <TextInput id="worksheet-name" type="text" class="mt-1 block w-full" v-model="form.title!" required
                        autofocus />
                    <InputError :message="$page.props.errors.title" />
                </div>
                <div class="my-4">
                    <InputLabel>Video Description</InputLabel>
                    <TextInput id="worksheet-description" type="text" class="mt-1 block w-full"
                        v-model="form.description!" required autofocus />
                    <InputError :message="$page.props.errors.description" />
                </div>
                <div class="my-4 ">
                    <InputLabel>Grade Level</InputLabel>
                    <div class="grid grid-cols-3 gap-2">
                        <SecondaryButton :active="form.grade_level === 1" @click="form.grade_level = 1">Grade 1
                        </SecondaryButton>
                        <SecondaryButton :active="form.grade_level === 2" @click="form.grade_level = 2">Grade 2
                        </SecondaryButton>
                        <SecondaryButton :active="form.grade_level === 3" @click="form.grade_level = 3">Grade 3
                        </SecondaryButton>
                        <InputError class="col-span-3"
                            :message="$page.props.errors.grade_level ? 'Grade level is required.' : ''" />
                    </div>
                </div>
                <div class="my-4 ">
                    <InputLabel>Quarter</InputLabel>
                    <div class="grid grid-cols-4 gap-2">
                        <SecondaryButton :active="form.quarter === 1" @click="form.quarter = 1">Q1</SecondaryButton>
                        <SecondaryButton :active="form.quarter === 2" @click="form.quarter = 2">Q2</SecondaryButton>
                        <SecondaryButton :active="form.quarter === 3" @click="form.quarter = 3">Q3</SecondaryButton>
                        <SecondaryButton :active="form.quarter === 4" @click="form.quarter = 4">Q4</SecondaryButton>
                        <InputError class="col-span-4"
                            :message="$page.props.errors.quarter ? 'Quarter for this material is required.' : ''" />
                    </div>
                </div>
                <div class="my-4">
                    <InputLabel>Video ID (YouTube)</InputLabel>
                    <TextInput id="worksheet-description" type="text" class="mt-1 block w-full" v-model="form.link!"
                        required autofocus />
                    <InputError :message="$page.props.errors.description" />
                </div>
                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="closeModal"> Cancel </SecondaryButton>
                    <PrimaryButton class="ms-3" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Link Video
                    </PrimaryButton>
                </div>
            </form>
        </Modal>

    </AdminLayout>
</template>