<script setup lang="ts">
import { onMounted, ref } from 'vue';

const input = ref<HTMLInputElement | null>(null);

onMounted(() => {
    if (input.value?.hasAttribute('autofocus')) {
        input.value?.focus();
    }
});

defineExpose({ focus: () => input.value?.focus() });
</script>

<template>
    <input
        type="file"
        accept="application/pdf"
        class="w-full p-2 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
        @input="$emit('onFileChange', ($event.target! as HTMLInputElement).files![0])"
        ref="input"
    />
</template>
