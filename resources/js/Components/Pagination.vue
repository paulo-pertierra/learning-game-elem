<script lang="ts" setup>
import { Link } from '@inertiajs/vue3';

const props = defineProps<{
    resource: any
}>();

console.log(props.resource);

</script>

<template>
    <Link class="text-center border rounded-lg p-2" :href="resource.path + '?page=1'"
        v-if="resource.current_page != 1">
    First
    </Link>
    <div v-else></div>
    <Link v-if="resource.prev_page_url" :href="resource.prev_page_url" class="text-center border rounded-lg p-2">
    Prev</Link>
    <div v-else></div>
    <span class="text-center">{{ resource.current_page }}</span>
    <Link v-if="resource.next_page_url" :href="resource.next_page_url" class="text-center border rounded-lg p-2">
    Next</Link>
    <Link :href="resource.path + `?page=${resource.last_page}`"
        v-if="resource.current_page != resource.last_page" class="text-center border rounded-lg p-2">
    Last
    </Link>
</template>