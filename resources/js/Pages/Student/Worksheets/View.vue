<script lang="ts" setup>
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router, usePage } from '@inertiajs/vue3';

const page = usePage();
function downloadFile() {
    const url = `/worksheets/${(page.props.worksheet as any).id}/download-file`;
    window.location.href = url;
}

function goBack() {
    window.history.back();
}

</script>

<template>
    <Head :title="($page.props.worksheet as any).title" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ ($page.props.worksheet as any).title }}</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                
                <SecondaryButton @click="goBack()" class="mb-10">Go Back</SecondaryButton>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg flex items-center">
                    <div class="h-96 w-96 border flex-shrink-0 rounded-lg"></div>
                    <div class="p-6 text-gray-900 dark:text-gray-100 flex-shrink">
                        {{ $page.props.worksheet }}
                        <PrimaryButton class="block" @click="downloadFile">Download  File</PrimaryButton>
                    </div>
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>