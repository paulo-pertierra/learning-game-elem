<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';

defineProps<{
    canLogin?: boolean;
    canRegister?: boolean;
    laravelVersion: string;
    phpVersion: string;
}>();

function handleImageError() {
    document.getElementById('screenshot-container')?.classList.add('!hidden');
    document.getElementById('docs-card')?.classList.add('!row-span-1');
    document.getElementById('docs-card-content')?.classList.add('!flex-row');
    document.getElementById('background')?.classList.add('!hidden');
}
</script>

<template>

    <Head title="Home Page" />
    <div class=" bg-blue-900 dark:bg-blue-950 text-slate-200 px-4">
        <nav class="h-16 max-w-[1200px] mx-auto flex items-center justify-between">
            <div class="flex items-center">
                <Link href="/" class="font-bold text-4xl">C1ES LMS</Link>
                <Link class="ml-16" href="/">Home</Link>
                <Link class="ml-8" href="/product">Our Product</Link>
                <Link class="ml-8" href="/about">About Us</Link>
                <!-- <Link class="ml-8" href="/">Contact</Link> -->
            </div>
            <div v-if="canLogin">
                <div v-if="$page.props.auth.user">
                    <Link class="ml-4 underline underline-offset-4 hover:underline-offset-8 transition-all"
                        :href="route('dashboard')">Dashboard</Link>
                </div>
                <div v-else>
                    <Link class="ml-4 underline underline-offset-4 hover:underline-offset-8 transition-all"
                        :href="route('login')">Login</Link>
                    <Link class="ml-4 underline underline-offset-4 hover:underline-offset-8 transition-all"
                        :href="route('register')">Register</Link>
                </div>
            </div>
        </nav>
    </div>
    <main class="min-h-[calc(100dvh-128px)] dark:bg-slate-950 text-slate-100 py-8 px-2">
        <div class="max-w-[1200px] mx-auto py-10 my-8 text-center shadow-lg rounded-2xl">
            <h1 class="text-4xl font-semibold my-4">Who are We?</h1>
            <p>Central 1 Elementary School stands as a beacon of holistic education, not only focusing on academic excellence but also instilling values and fostering spiritual growth among its students. At the heart of this endeavor lies the Sagip Maka-Diyos program, a cornerstone initiative that integrates moral teachings, prayers, and catechism into the daily lives of its students.</p>
        </div>
        <div class="max-w-[1200px] mx-auto py-10 my-8 text-center shadow-lg rounded-2xl">
            <h1 class="text-4xl font-semibold my-4">We created this app to make learning more accessible</h1>
            <p>By allowing students to answer quizzes online, hybrid learning will become much easier. Grading students will also become easier because of automated scoring systems in the application.</p>
            <img src="/assets/images/app_image.webp" class="h-full w-full my-10 rounded-lg" alt="">
        </div>
        <div class="max-w-[1200px] mx-auto my-10 text-center">
            <h1 class="text-4xl font-semibold my-4">Are you ready to revolutionize learning?</h1>
            <Link :href="route('dashboard')"
                class="text-lg w-fit bg-blue-900 hover:bg-blue-950 transition-all text-white rounded-lg py-2 px-4 shadow-lg shadow-blue-900/50">
            Get Started</Link>
        </div>
    </main>
    <div class="w-full bg-blue-900 dark:bg-blue-950 text-slate-200">
        <footer class="mx-auto max-w-[1200px] p-2 grid grid-cols-3 gap-10">
            <div>
                <Link href="/" class="font-bold text-4xl mt-4 block">C1ES LMS</Link>
                <p>The interactive learning platform.</p>
            </div>
            <div>
                <Link href="" class="block my-4">Home Page</Link>
                <Link href="" class="block my-4">About Us</Link>
                <Link href="" class="block my-4">Our Product</Link>
                <Link href="" class="block my-4">Login</Link>
                <Link href="" class="block my-4">Register</Link>
            </div>
            <div>
                <Link href="" class="block my-4">Privacy Policy</Link>
                <Link href="" class="block my-4">Terms and Conditions</Link>
                <Link href="" class="block my-4">Developers</Link>
            </div>
            <div class="col-span-3 text-center my-8">
                Copyright &copy; 2024 C1ES LMS Inc. All rights reserved.
            </div>
        </footer>
    </div>
</template>
