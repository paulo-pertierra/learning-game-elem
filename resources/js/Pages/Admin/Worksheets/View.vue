<script lang="ts" setup>
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import VerticalEllipsis from "@/Components/Icons/VerticalEllipsis.vue";

import { Head, router, usePage } from '@inertiajs/vue3';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import { ref } from 'vue';
import Modal from '@/Components/Modal.vue';

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
        <Modal :show="confirmingWorksheetDeletion">
            Hello
        </Modal>
    </AuthenticatedLayout>
</template>