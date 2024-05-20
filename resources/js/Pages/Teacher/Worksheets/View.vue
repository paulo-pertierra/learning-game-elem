<script lang="ts" setup>
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import VerticalEllipsis from "@/Components/Icons/VerticalEllipsis.vue";

import { Head, router, useForm, usePage } from '@inertiajs/vue3';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import { ref } from 'vue';
import Modal from '@/Components/Modal.vue';
import DangerButton from '@/Components/DangerButton.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import FileInput from '@/Components/FileInput.vue';
import { watch } from 'vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import TeacherLayout from '@/Layouts/TeacherLayout.vue';

const page = usePage();

const downloadFile = () => {
    const url = `/worksheets/${(page.props.worksheet as any).id}/download-file`;
    window.location.href = url;
}

const previewFile = () => {
    const url = `/worksheets/${(page.props.worksheet as any).id}/view`;
    window.location.href = url;
}

const goBack = () => {
    window.history.back();
}

const confirmingWorksheetDeletion = ref(false);

const confirmWorksheetDeletion = () => {
    confirmingWorksheetDeletion.value = true;
}

const closeWorksheetDeletionModal = () => {
    confirmingWorksheetDeletion.value = false;
}

const deleteProcessing = ref(false);
const deleteWorksheet = () => {
    deleteProcessing.value = true;

    router.delete(`/worksheets/${(page.props.worksheet as any).id}`, {
        onSuccess: () => {
            deleteProcessing.value = false;
        }
    });
}

const showingWorksheetEditor = ref(false);

const showWorksheetEditor = () => {
    showingWorksheetEditor.value = true;
}

const closeWorksheetEditor = () => {
    showingWorksheetEditor.value = false;
}

const form = useForm({
    title: (page.props.worksheet as any).title,
    description: (page.props.worksheet as any).description,
    file: (page.props.worksheet as any).file,
    grade_level: (page.props.worksheet as any).grade_level,
    quarter: (page.props.worksheet as any).quarter
});

const updateWorksheet = () => {
    form.post(`/worksheets/${(page.props.worksheet as any).id}`, {
        onError: (error) => {
            console.log(error);
            
        },
        onSuccess: () => {
            form.reset();
            closeWorksheetEditor();
            window.location.reload();
       }
    })
}

watch(form, () => {
    console.log(form);
    
})
</script>

<template>
    <Head :title="($page.props.worksheet as any).title" />
    <TeacherLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ ($page.props.worksheet as any).title }}</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                
                <SecondaryButton @click="goBack()" class="mb-10">Go Back</SecondaryButton>

                <div class="bg-white relative dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg block sm:flex sm:items-center">
                    <div class="aspect-square h-full sm:h-64 sm:w-64 border flex-shrink-0 rounded-lg m-4 grid items-end text-gray-800 dark:text-gray-200 overflow-hidden">
                        <div class="p-4 bg-slate-200 dark:bg-gray-900">
                            <h2 class="text-lg font-semibold">{{ (page.props.worksheet as any).title }}
                            for Q{{ (page.props.worksheet as any).quarter }}</h2>
                            <h2>Grade {{ (page.props.worksheet as any).grade_level }}</h2>
                        </div>
                    </div>
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h2 class="text-3xl font-semibold">
                            {{ (page.props.worksheet as any).title }}
                        </h2>
                        <h4>
                            {{ (page.props.worksheet as any).description }}
                        </h4>
                        <PrimaryButton class="block bottom-0 mt-8 mr-2" @click="downloadFile">Download File</PrimaryButton>
                        <PrimaryButton class="block bottom-0 mt-8 ml-2" @click="previewFile">View File</PrimaryButton>
                    </div>
                    <div class="top-0 right-0 absolute h-12 w-12 m-4 grid place-items-center text-white">
                        <Dropdown>
                            <template #trigger>
                                <VerticalEllipsis class="h-8" />
                            </template>
                            <template #content>
                                <DropdownLink @click="showWorksheetEditor">Edit</DropdownLink>
                                <DropdownLink @click="confirmWorksheetDeletion">Delete</DropdownLink>
                            </template>
                        </Dropdown>
                    </div>
                </div>
            </div>
        </div>
        <Modal :show="confirmingWorksheetDeletion" @close="closeWorksheetDeletionModal">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    Are you sure you want to delete this module?
                </h2>

                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="closeWorksheetDeletionModal"> Cancel </SecondaryButton>

                    <DangerButton
                        class="ms-3"
                        :class="{ 'opacity-25': deleteProcessing }"
                        :disabled="deleteProcessing"
                        @click="deleteWorksheet"
                    >
                        Delete Module
                    </DangerButton>
                </div>
            </div>
        </Modal>
        <Modal :show="showingWorksheetEditor">
            <form class="p-6" @submit.prevent="updateWorksheet">
                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        Add New Module
                    </h2>
                    <div class="my-4">
                        <InputLabel>Module Name</InputLabel>
                        <TextInput id="worksheet-name" type="text" class="mt-1 block w-full" v-model="form.title!"
                            required autofocus />
                            <InputError :message="$page.props.errors.title" />
                    </div>
                    <div class="my-4">
                        <InputLabel>Module Description</InputLabel>
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
                        <InputLabel>File Input</InputLabel>
                        <FileInput @on-file-change="function (file: any) { form.file = file }" />
                        <InputError :message="$page.props.errors.file" />
                    </div>
                    <div class="mt-6 flex justify-end">
                        <SecondaryButton @click="closeWorksheetEditor"> Cancel </SecondaryButton>
                        <PrimaryButton class="ms-3" :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing">
                            Add New Module
                        </PrimaryButton>
                    </div>
                </form>
        </Modal>
    </TeacherLayout>
</template>