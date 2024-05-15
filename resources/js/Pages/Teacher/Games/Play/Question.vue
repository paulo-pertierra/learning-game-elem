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

import Swal from "sweetalert2";
async function selectAnswer(answer: any) {
    if (answer.is_correct) {
        await Swal.fire({
            icon: "success",
            title: "You're correct!",
            text: `The correct answer is: ${ (answer.text as string).toUpperCase() }!`
        })
        console.log(game.total_questions != question.item_no);
        
        game.total_questions != question.item_no ? 
            router.visit(`/games/${game.id}/question/${question.item_no + 1}`) : 
            router.visit(`/games/${game.id}/end`)
    }
    else {
        Swal.fire({
            icon: "error",
            title: "You're wrong!",
            text: "Please try again!"
        })
    }
}
</script>

<template>
    <QuizLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Question {{
                question.item_no }}</h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto px-6 lg:px-8 text-white">
                <div class="mb-4 grid grid-cols-2 gap-4">
                    <h4 class="text-3xl my-4 col-span-2">
                        {{ question.question }}
                    </h4>
                    <div v-for="answer in answers" class="w-full h-full">
                        <PrimaryButton @click="selectAnswer(answer)" class="h-full w-full">
                            <p class="text-2xl text-center w-full">{{ answer.text }}</p>
                        </PrimaryButton>
                    </div>
                </div>
                <div class="flex gap-8 w-full justify-between">
                    <PrimaryButton class="my-10" :disabled="question.item_no == 1"
                        @click="router.visit(`/games/${game.id}/question/${question.item_no - 1}`)">Go Back
                    </PrimaryButton>
                    <PrimaryButton class=" my-10" :disabled="question.item_no == game.total_questions"
                        @click="router.visit(`/games/${game.id}/question/${question.item_no + 1}`)">Next</PrimaryButton>
                </div>
                <div class="flex items-center w-full gap-2">
                    <div v-for="i in game.total_questions" class="w-full h-8 rounded-lg hover:cursor-pointer"
                        @click="router.visit(`/games/${game.id}/question/${i}`, { data: { storedAnswers } })"
                        :class="{ 'bg-blue-700': route().params.item == i, 'bg-slate-100': route().params.item != i }">
                    </div>
                </div>
            </div>
        </div>
    </QuizLayout>
</template>