<script lang="ts" setup>
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Modal from '@/Components/Modal.vue';
import { ref, watch } from 'vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import FileInput from '@/Components/FileInput.vue';
import InputError from '@/Components/InputError.vue';
import Pagination from '@/Components/Pagination.vue';

const addingNewWorksheet = ref(false);

const addNewWorksheetModal = () => {
    addingNewWorksheet.value = true;
};

function addNewWorksheet() {
    form.post('/worksheets', {
       onSuccess: () => {
        form.reset();
        closeModal();
       }
    });
};

const closeModal = () => {
    addingNewWorksheet.value = false;
};

const form = useForm({
    title: "",
    description: "",
    file: null,
    grade_level: 0,
    quarter: 0
});

watch(form, () => {
    console.log(form);
    
})

const page = usePage();

const worksheets = page.props.worksheets as any;
</script>

<template>
    <div>

        <Head title="Worksheets" />

        <AuthenticatedLayout>
            <template #header>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Worksheets</h2>
            </template>

            <div class="py-12">
                <div class="max-w-7xl mx-auto px-6 lg:px-8">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Worksheets List</h2>
                    </div>
                    <div v-if="!($page.props.worksheets as any).data.length" class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900 dark:text-gray-100">
                            Here you will see and view your worksheets the teacher has uploaded. Please wait until the teacher adds new documents.
                        </div>
                    </div>
                    <div v-else>
                        <div class="text-white grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                            <Link :href="`/worksheets/${worksheet.id}`" v-for="worksheet in worksheets.data" class="border border-gray-500 dark:text-gray-200 h-64 rounded-2xl flex items-end">
                                <div class="p-8">
                                    <h2 class="text-2xl">{{ worksheet.title }}</h2>
                                    <p>{{ worksheet.description || 'No description provided.' }}</p>
                                </div>
                            </Link>
                            <div class="md:col-span-2 lg:col-span-3 grid grid-cols-5 gap-2 mx-auto items-center justify-center">
                                <Pagination :resource="worksheets" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <Modal :show="addingNewWorksheet">
                <form class="p-6" @submit.prevent="addNewWorksheet">
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
                        <FileInput @on-file-change="function (file) { form.file = file }" />
                        <InputError :message="$page.props.errors.file" />
                    </div>
                    <div class="mt-6 flex justify-end">
                        <SecondaryButton @click="closeModal"> Cancel </SecondaryButton>
                        <PrimaryButton class="ms-3" :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing">
                            Add New Worksheet
                        </PrimaryButton>
                    </div>
                </form>
            </Modal>
        </AuthenticatedLayout>
    </div>
</template>