<script lang="ts" setup>
import PrimaryButton from '@/Components/PrimaryButton.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import QuizLayout from '@/Layouts/QuizLayout.vue';
import { router, usePage } from '@inertiajs/vue3';
import { watch } from 'vue';
import { ref } from 'vue';

const page = usePage();

const question = page.props.question as any;
const game = page.props.game as any;
const answers = page.props.answers as any;
const serverSelectedAnswers = page.props

const selectedAnswer = ref();

const storedAnswers = ref<{}>(page.props.storedAnswers as any);

watch(selectedAnswer, () => {
    console.log(storedAnswers.value);
    const oldAnswers = storedAnswers.value
    storedAnswers.value = {
        ...oldAnswers,
        ...{ [question.item_no]: selectedAnswer.value }
    }
})
</script>

<template>
    <QuizLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Question {{
                question.item_no }}</h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto px-6 lg:px-8 text-white">
                <div class="mb-4">
                    <h4 class="text-3xl my-4">
                        {{ question.question }}
                    </h4>
                    <input class="m-2" type="radio" name="answer" :value="answers[0].id" v-model="selectedAnswer">
                    <label for="">{{ answers[0].text }}</label>
                    <br>
                    <input class="m-2" type="radio" name="answer" :value="answers[1].id" v-model="selectedAnswer">
                    <label for="">{{ answers[1].text }}</label>
                    <br>
                    <input class="m-2" type="radio" name="answer" :value="answers[2].id" v-model="selectedAnswer">
                    <label for="">{{ answers[2].text }}</label>
                    <br>
                    <input class="m-2" type="radio" name="answer" :value="answers[3].id" v-model="selectedAnswer">
                    <label for="">{{ answers[3].text }}</label>
                </div>
                <div class="flex justify-end py-2">
                    <PrimaryButton v-if="game.total_questions != route().params.item"
                        @click="router.visit(`/games/${game.id}/question/${question.item_no + 1}`, { data: { storedAnswers } })">
                        Next</PrimaryButton>
                </div>
                <div class="flex items-center w-full gap-2">
                    <div v-for="i in game.total_questions" class="w-full h-8 rounded-lg hover:cursor-pointer"
                        @click="router.visit(`/games/${game.id}/question/${i}`, { data: { storedAnswers } })"
                        :class="{ 'bg-blue-700': route().params.item == i, 'bg-slate-100': route().params.item != i }">
                    </div>
                    <PrimaryButton @click="router.post(`/games/${game.id}`, {
                data: { storedAnswers }
            })">Submit</PrimaryButton>
                </div>
            </div>
        </div>
    </QuizLayout>
</template>