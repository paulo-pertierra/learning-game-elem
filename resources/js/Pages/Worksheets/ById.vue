<script lang="ts" setup>
import { usePage } from '@inertiajs/vue3';

const page = usePage();
function downloadFile() {
    const url = `/worksheets/${(page.props.worksheet as any).id}/download-file`;
    window.location.href = url;
}

</script>

<template>
    {{ $page.props.worksheet }}
    <div @click="downloadFile">Open File</div>
</template>