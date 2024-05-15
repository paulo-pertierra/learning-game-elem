<script lang="ts" setup>
import PrimaryButton from "@/Components/PrimaryButton.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { router } from "@inertiajs/vue3";
</script>

<template>
    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto px-6 lg:px-8 text-white">
                <div class="mb-4">
                    <h2 class="text-3xl font-bold">
                        {{ $page.props.game.title }}
                    </h2>
                    <p>Total Questions: {{ $page.props.game.total_questions }}</p>
                    <PrimaryButton class="my-10" @click="router.visit(`/games/${$page.props.game.id}/question/1`)">Answer</PrimaryButton>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>