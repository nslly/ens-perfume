<template>
    <div class="flex flex-col items-center justify-center h-screen bg-gray-100">
        <h1 class="text-5xl font-bold text-red-500">404</h1>
        <p class="text-lg text-gray-700 mt-4">Oops! The page you are looking for does not exist.</p>
        <PrimaryButton class="mt-6" @click="goHome">Go Home</PrimaryButton>
    </div>
</template>

<script setup>
import PrimaryButton from '@/Components/Button/Primary.vue';

const goHome = () => {
    window.location.href = '/'; // Redirect to home
};
</script>