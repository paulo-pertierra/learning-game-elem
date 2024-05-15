<template>
    <TeacherLayout class="overflow-hidden">
        <div class="py-12">

            <div class="max-w-7xl mx-auto px-6 lg:px-8 text-white rounded-lg">
                <div class="mb-4 relative">
                    <div class="flex justify-between">
                        <ConfettiExplosion :stageHeight="1280" :stageWidth="1920" :particleCount="75" />
                        <ConfettiExplosion :stageHeight="1280" :stageWidth="1920" :particleCount="75" />
                        <ConfettiExplosion :stageHeight="1280" :stageWidth="1920" :particleCount="75" />
                    </div>
                    <h2 class="text-3xl font-bold my-6 text-center">
                        Congratulations on finishing {{ ($page.props.game as any).title }}!
                    </h2>
                    <p class="text-2xl my-6 text-center">Total Questions: {{ ($page.props.game as any).total_questions
                        }}</p>
                    <div class="mx-auto w-fit">
                        <PrimaryButton @click="router.visit('/games')">Go Back to Games</PrimaryButton>
                    </div>
                </div>
            </div>
        </div>
    </TeacherLayout>
</template>

<script lang="ts" setup>
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TeacherLayout from '@/Layouts/TeacherLayout.vue';
import { router } from '@inertiajs/vue3';
import ConfettiExplosion from "vue-confetti-explosion";
</script>