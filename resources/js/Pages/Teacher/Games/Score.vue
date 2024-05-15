<script lang="ts" setup>
import PrimaryButton from "@/Components/PrimaryButton.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import TeacherLayout from "@/Layouts/TeacherLayout.vue";
import { router } from "@inertiajs/vue3";
</script>

<template>
    <TeacherLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto px-6 lg:px-8 text-white">
                <div class="mb-4">
                    <h2 class="text-3xl font-bold">
                        {{ $page.props.game.title }}
                    </h2>
                    <p class="text-2xl">Total Score: {{ $page.props.score.score }} / {{ $page.props.score.total_questions }}</p>
                    <PrimaryButton class="my-10" @click="router.visit(`/games`)">Go To Games</PrimaryButton>
                </div>
            </div>
        </div>
    </TeacherLayout>
</template>