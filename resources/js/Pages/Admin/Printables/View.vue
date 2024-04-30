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

const page = usePage();

const downloadFile = () => {
    const url = `/printables/${(page.props.printable as any).id}/download-file`;
    window.location.href = url;
}

const previewFile = () => {
    const url = `/printables/${(page.props.printable as any).id}/view`;
    window.location.href = url;
}

const goBack = () => {
    window.history.back();
}

const confirmingPrintableDeletion = ref(false);

const confirmPrintableDeletion = () => {
    confirmingPrintableDeletion.value = true;
}

const closePrintableDeletionModal = () => {
    confirmingPrintableDeletion.value = false;
}

const deleteProcessing = ref(false);
const deletePrintable = () => {
    deleteProcessing.value = true;

    router.delete(`/printables/${printable.id}`, {
        onSuccess: () => {
            deleteProcessing.value = false;
        }
    });
}

const showingPrintableEditor = ref(false);

const showPrintableEditor = () => {
    showingPrintableEditor.value = true;
}

const closePrintableEditor = () => {
    showingPrintableEditor.value = false;
}

const form = useForm({
    title: (page.props.printable as any).title,
    description: (page.props.printable as any).description,
    file: (page.props.printable as any).file,
    grade_level: (page.props.printable as any).grade_level,
    quarter: (page.props.printable as any).quarter
});

const updateWorksheet = () => {
    form.post(`/printables/${printable.id}`, {
        onError: (error) => {
            console.log(error);
            
        },
        onSuccess: () => {
            form.reset();
            closePrintableEditor();
            window.location.reload();
       }
    })
}

watch(form, () => {
    console.log(form);
    
})

const printable = page.props.printable as any;

</script>

<template>
    <Head :title="printable.title" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ printable.title }}</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                
                <SecondaryButton @click="goBack()" class="mb-10">Go Back</SecondaryButton>

                <div class="bg-white relative dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg block sm:flex sm:items-center">
                    <div class="aspect-square h-full sm:h-64 sm:w-64 border flex-shrink-0 rounded-lg m-4 grid items-end text-gray-800 dark:text-gray-200 overflow-hidden">
                        <div class="p-4 bg-slate-200 dark:bg-gray-900">
                            <h2 class="text-lg font-semibold">{{ printable.title }}
                            for Q{{ printable.quarter }}</h2>
                            <h2>Grade {{ printable.grade_level }}</h2>
                        </div>
                    </div>
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h2 class="text-3xl font-semibold">
                            {{ printable.title }}
                        </h2>
                        <h4>
                            {{ printable.description }}
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
                                <DropdownLink @click="showPrintableEditor">Edit</DropdownLink>
                                <DropdownLink @click="confirmPrintableDeletion">Delete</DropdownLink>
                            </template>
                        </Dropdown>
                    </div>
                </div>
            </div>
        </div>
        <Modal :show="confirmingPrintableDeletion" @close="closePrintableDeletionModal">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    Are you sure you want to delete this worksheet?
                </h2>

                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="closePrintableDeletionModal"> Cancel </SecondaryButton>

                    <DangerButton
                        class="ms-3"
                        :class="{ 'opacity-25': deleteProcessing }"
                        :disabled="deleteProcessing"
                        @click="deletePrintable"
                    >
                        Delete Worksheet
                    </DangerButton>
                </div>
            </div>
        </Modal>
        <Modal :show="showingPrintableEditor">
            <form class="p-6" @submit.prevent="updateWorksheet">
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
                        <InputLabel>File Input</InputLabel>
                        <FileInput @on-file-change="function (file: any) { form.file = file }" />
                        <InputError :message="$page.props.errors.file" />
                    </div>
                    <div class="mt-6 flex justify-end">
                        <SecondaryButton @click="closePrintableEditor"> Cancel </SecondaryButton>
                        <PrimaryButton class="ms-3" :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing">
                            Add New Printable
                        </PrimaryButton>
                    </div>
                </form>
        </Modal>
    </AuthenticatedLayout>
</template>