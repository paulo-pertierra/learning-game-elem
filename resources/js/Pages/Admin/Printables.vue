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
import AdminLayout from '@/Layouts/AdminLayout.vue';

const addingNewPrintable = ref(false);

const addNewPrintableModal = () => {
    addingNewPrintable.value = true;
};

function addNewPrintable() {
    form.post('/printables', {
       onSuccess: () => {
        form.reset();
        closeModal();
       }
    });
};

const closeModal = () => {
    addingNewPrintable.value = false;
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

const printables = page.props.printables as any;
</script>

<template>
    <div>

        <Head title="Printable Documents" />

        <AdminLayout>
            <template #header>
                <div class="flex items-center justify-between">
                    <h2 class="font-semibold mr-2 text-xl text-gray-800 dark:text-gray-200 leading-tight">Printable Documents</h2>
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
                        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Printable Documents List</h2>
                        <PrimaryButton @click="addNewPrintableModal">New Printable</PrimaryButton>
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

            <Modal :show="addingNewPrintable">
                <form class="p-6" @submit.prevent="addNewPrintable">
                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        Add New Printable Document
                    </h2>
                    <div class="my-4">
                        <InputLabel>Document Name</InputLabel>
                        <TextInput id="document-name" type="text" class="mt-1 block w-full" v-model="form.title!"
                            required autofocus />
                            <InputError :message="$page.props.errors.title" />
                    </div>
                    <div class="my-4">
                        <InputLabel>Document Description</InputLabel>
                        <TextInput id="document-description" type="text" class="mt-1 block w-full"
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
                            Add New Printable
                        </PrimaryButton>
                    </div>
                </form>
            </Modal>
        </AdminLayout>
    </div>
</template>