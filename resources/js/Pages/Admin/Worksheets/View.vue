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

const page = usePage();

function downloadFile() {
    const url = `/worksheets/${(page.props.worksheet as any).id}/download-file`;
    window.location.href = url;
}

function goBack() {
    window.history.back();
}

const confirmingWorksheetDeletion = ref(false);

const confirmWorksheetDeletion = () => {
    confirmingWorksheetDeletion.value = true;
}

const closeModal = () => {
    confirmingWorksheetDeletion.value = false;
}

const deleteProcessing = ref(false);
const deleteWorksheet = () => {
    deleteProcessing.value = true;

    router.delete(`/worksheets/${(page.props.worksheet as any).id}`, {
        onFinish: () => {
            deleteProcessing.value = false;
            window.history.back();
        }
    });
}
</script>

<template>
    <Head :title="($page.props.worksheet as any).title" />
    <AuthenticatedLayout>
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
                        <PrimaryButton class="block bottom-0 mt-8" @click="downloadFile">Download File</PrimaryButton>
                    </div>
                    <div class="top-0 right-0 absolute h-12 w-12 m-4 grid place-items-center text-white">
                        <Dropdown>
                            <template #trigger>
                                <VerticalEllipsis class="h-8" />
                            </template>
                            <template #content>
                                <DropdownLink href="">Edit</DropdownLink>
                                <DropdownLink @click="confirmWorksheetDeletion">Delete</DropdownLink>
                            </template>
                        </Dropdown>
                    </div>
                </div>
            </div>
        </div>
        <Modal :show="confirmingWorksheetDeletion" @close="closeModal">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    Are you sure you want to delete your account?
                </h2>

                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    Once your account is deleted, all of its resources and data will be permanently deleted. Please
                    enter your password to confirm you would like to permanently delete your account.
                </p>

                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="closeModal"> Cancel </SecondaryButton>

                    <DangerButton
                        class="ms-3"
                        :class="{ 'opacity-25': deleteProcessing }"
                        :disabled="deleteProcessing"
                        @click="deleteWorksheet"
                    >
                        Delete Account
                    </DangerButton>
                </div>
            </div>
        </Modal>
    </AuthenticatedLayout>
</template>