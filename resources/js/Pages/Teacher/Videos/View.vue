<script lang="ts" setup>
import DangerButton from '@/Components/DangerButton.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import VerticalEllipsis from '@/Components/Icons/VerticalEllipsis.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Modal from '@/Components/Modal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router, useForm, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';

const page = usePage();

const confirmingVideoDeletion = ref(false);

const closeVideoDeletionModal = () => {
    confirmingVideoDeletion.value = false;
}

const confirmVideoDeletion = () => {
    confirmingVideoDeletion.value = true;
}

const deleteProcessing = false;

const deleteVideo = () => {
    router.delete(`/videos/${ (video as any).id }`)
}

const goBack = () => {
    window.history.back();
}

const showingVideoEditor = ref(false);

const showVideoEditor = () => {
    showingVideoEditor.value = true;
}

const closeVideoEditor = () => {
    showingVideoEditor.value = false;
}

const video = page.props.video as any;

const form = useForm({
    title: video.title,
    link: video.link,
    description: video.description,
    grade_level: video.grade_level,
    quarter: video.quarter
})

const updateVideo = () => {
    form.post(`/videos/${ video.id }`, {
        onSuccess: () => {
            closeVideoEditor();
        }
    })
}

</script>

<template>

    <Head :title="(video as any).title" />
    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-5xl mx-auto px-6 lg:px-8">
                <div
                    class="bg-white p-10 relative dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg block select-none">
                    <div class="top-0 right-0 absolute h-12 w-12 m-4 grid place-items-center text-white">
                        <Dropdown class="hover:cursor-pointer">
                            <template #trigger>
                                <VerticalEllipsis class="h-8" />
                            </template>
                            <template #content>
                                <DropdownLink @click="showVideoEditor">Edit</DropdownLink>
                                <DropdownLink @click="confirmVideoDeletion">Delete</DropdownLink>
                            </template>
                        </Dropdown>
                    </div>
                    <iframe class="w-full h-full aspect-video rounded-lg mt-8"
                        :src="`https://www.youtube.com/embed/${video.link}`"
                        title="YouTube video player" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                    <h2 class="mt-4 text-2xl font-semibold dark:text-slate-100 text-gray-800">
                        {{ (video as any).title }}
                    </h2>
                    <h5 class="dark:text-slate-100 text-gray-800 mt-2">
                        {{ (video as any).description }}
                    </h5>
                </div>
            </div>
        </div>

        <Modal :show="confirmingVideoDeletion" @close="closeVideoDeletionModal">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    Are you sure you want to delete this worksheet?
                </h2>

                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="closeVideoDeletionModal"> Cancel </SecondaryButton>

                    <DangerButton
                        class="ms-3"
                        :class="{ 'opacity-25': deleteProcessing }"
                        :disabled="deleteProcessing"
                        @click="deleteVideo"
                    >
                        Delete Worksheet
                    </DangerButton>
                </div>
            </div>
        </Modal>

        <Modal :show="showingVideoEditor">
            <form class="p-6" @submit.prevent="updateVideo">
                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        Add New Worksheet
                    </h2>
                    <div class="my-4">
                        <InputLabel>Worksheet Name</InputLabel>
                        <TextInput id="worksheet-name" type="text" class="mt-1 block w-full" v-model="form.title!"
                            required autofocus />
                            <InputError :message="$page.props.errors.title" />
                    </div>
                    <div class="my-4">
                        <InputLabel>Worksheet Description</InputLabel>
                        <TextInput id="worksheet-description" type="text" class="mt-1 block w-full"
                            v-model="form.description!" required autofocus />
                        <InputError :message="$page.props.errors.description" />
                    </div>
                    <div class="my-4 ">
                        <InputLabel>Grade Level</InputLabel>
                        <div class="grid grid-cols-3 gap-2">
                            <SecondaryButton :active="form.grade_level === 1" @click="form.grade_level = 1">Grade 1</SecondaryButton>
                            <SecondaryButton :active="form.grade_level === 2" @click="form.grade_level = 2">Grade 2</SecondaryButton>
                            <SecondaryButton :active="form.grade_level === 3" @click="form.grade_level = 3">Grade 3</SecondaryButton>
                            <InputError class="col-span-3" :message="$page.props.errors.grade_level ? 'Grade level is required.' : ''" />
                        </div>
                    </div>
                    <div class="my-4 ">
                        <InputLabel>Quarter</InputLabel>
                        <div class="grid grid-cols-4 gap-2">
                            <SecondaryButton :active="form.quarter === 1" @click="form.quarter = 1">Q1</SecondaryButton>
                            <SecondaryButton :active="form.quarter === 2" @click="form.quarter = 2">Q2</SecondaryButton>
                            <SecondaryButton :active="form.quarter === 3" @click="form.quarter = 3">Q3</SecondaryButton>
                            <SecondaryButton :active="form.quarter === 4" @click="form.quarter = 4">Q4</SecondaryButton>
                            <InputError class="col-span-4" :message="$page.props.errors.quarter ? 'Quarter for this material is required.' : ''" />
                        </div>
                    </div>
                    <div class="my-4">
                        <InputLabel>Video ID (YouTube)</InputLabel>
                        <TextInput id="video-link" type="text" class="mt-1 block w-full"
                            v-model="form.link!" required autofocus />
                        <InputError :message="$page.props.errors.description" />
                    </div>
                    <div class="mt-6 flex justify-end">
                        <SecondaryButton @click="closeVideoEditor"> Cancel </SecondaryButton>
                        <PrimaryButton class="ms-3" :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing">
                            Add New Worksheet
                        </PrimaryButton>
                    </div>
                </form>
        </Modal>
    </AuthenticatedLayout>
</template>