<script lang="ts" setup>
import { Head, router, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Modal from '@/Components/Modal.vue';
import { ref } from 'vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import FileInput from '@/Components/FileInput.vue';


const addingNewWorksheet = ref(false);

const addNewWorksheetModal = () => {
    addingNewWorksheet.value = true;
};
function addNewWorksheet() {
    form.post('/worksheets/new');
}

const closeModal = () => {
    addingNewWorksheet.value = false;
}

const form = useForm({
    title: "",
    description: null,
    file: null,
    grade_level: null,
    quarter: null
})
</script>

<template>

    <Head title="Worksheets" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Worksheets</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Worksheets</h2>
                    <PrimaryButton @click="addNewWorksheetModal">New Worksheet</PrimaryButton>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        In this page, you can add worksheets for your students. To add a worksheet, you can click the
                        add
                        worksheet button, and upload a PDF document.
                    </div>
                </div>
            </div>
        </div>

        <Modal :show="addingNewWorksheet" :closable="true">
            <form class="p-6" @submit.prevent="addNewWorksheet">
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    Add New Worksheet
                </h2>

                <div class="my-4">
                    <InputLabel>Worksheet Name</InputLabel>
                    <TextInput
                        id="worksheet-name"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.title!"
                        required
                        autofocus
                    />
                </div>

                <div class="my-4">
                    <InputLabel>Worksheet Description</InputLabel>
                    <TextInput
                        id="worksheet-description"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.description!"
                        required
                        autofocus
                    />
                </div>

                <div class="my-4">
                    <InputLabel>File Input</InputLabel>
                    <FileInput
                        @on-file-change="function(file) { console.log(file)}"
                    />
                </div>

                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="closeModal"> Cancel </SecondaryButton>

                    <PrimaryButton
                        class="ms-3"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        @click="addNewWorksheet"
                    >
                        Add New Worksheet
                    </PrimaryButton>
                </div>
            </form>
        </Modal>
    </AuthenticatedLayout>
</template>