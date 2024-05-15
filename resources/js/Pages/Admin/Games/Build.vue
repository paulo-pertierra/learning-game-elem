<script lang="ts" setup>
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

type Answer = {
    text: string,
    is_correct: boolean
}

const questions = ref<{
    item_no: number,
    question: string,
    answers: Answer[]
}[]>([]);
const currentItemNumber = ref(0);

const game = ref({
    title: "",
    game_mode: "multiple_choice",
    difficulty: "easy",
    grade_level: 1,
    quarter: 1,
    total_questions: currentItemNumber,
})

const addItem = () => {
    currentItemNumber.value += 1;
    questions.value.push({
        item_no: currentItemNumber.value,
        question: "",
        answers: [
            { text: "", is_correct: true },
            { text: "", is_correct: false },
            { text: "", is_correct: false },
            { text: "", is_correct: false }
        ]
    })
}

const removeItem = () => {
    currentItemNumber.value -= 1;
    questions.value.pop();
}

const createGame = () => {
    const form = useForm({
        game: game.value,
        questions: questions.value
    })
    form.post("/games");
}
</script>
<template>
    <AdminLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="font-semibold mr-2 text-xl text-gray-800 dark:text-gray-200 leading-tight">Create A New Game
                </h2>
            </div>
        </template>

        <div class="py-12 text-gray-800 dark:text-gray-200">
            <div class="max-w-3xl mx-auto px-6 lg:px-8">
                <div class="p-4 border rounded-lg">
                    <InputLabel class="mb-3">
                        <p class="text-xl">Game Title</p>
                    </InputLabel>
                    <TextInput class="w-full" v-model="game.title" />
                    <InputLabel class="my-3">
                       Game Mode
                    </InputLabel>
                    <select name="" class="w-full text-slate-200 bg-gray-900 rounded-md border-gray-700">
                        <option value="easy">Pop Quiz</option>
                        <option value="easy">Immersive Reading</option>
                        <option value="easy">Guess the Body Parts</option>
                    </select>
                    <InputLabel class="my-3">
                       Difficulty
                    </InputLabel>
                    <select name="" class="w-full text-slate-200 bg-gray-900 rounded-md border-gray-700">
                        <option value="easy">Easy</option>
                        <option value="average">Average</option>
                        <option value="difficult">Difficult</option>
                    </select>
                </div>
                <div class="p-4 border rounded-lg my-4">
                    <div v-for="question in questions">
                        <div class="pb-8">
                            <InputLabel class="py-2">
                                <p class="text-2xl">{{ question.item_no }}. Question: {{ question.question }}</p>
                            </InputLabel>
                            <TextInput class="w-full" v-model="question.question" />
                        </div>
                        <div class="bg-green-600 rounded-lg p-2">
                            <InputLabel>Answer 1 (Correct Answer)</InputLabel>
                            <TextInput class="block w-full mb-4" v-model="question.answers[0].text" />
                        </div>
                        <InputLabel>Answer 2</InputLabel>
                        <TextInput class="block w-full mb-4" v-model="question.answers[1].text" />
                        <InputLabel>Answer 3</InputLabel>
                        <TextInput class="block w-full mb-4" v-model="question.answers[2].text" />
                        <InputLabel>Answer 4</InputLabel>
                        <TextInput class="block w-full mb-4" v-model="question.answers[3].text" />
                    </div>
                    <div class="grid grid-cols-3 gap-4">
                        <SecondaryButton v-if="questions.length" @click="removeItem">Remove Last Question</SecondaryButton>
                <PrimaryButton @click="addItem">Add A New Question</PrimaryButton>
                <PrimaryButton v-if="questions.length" @click="createGame">Submit Game</PrimaryButton>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>