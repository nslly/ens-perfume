
<template>
    <div class="mx-auto text-justify overflow-hidden z-20">
        <Navbar />

        <main class="w-full mx-auto pb-8">
            <slot />
        </main>
    </div>
</template>

<script setup>

import Navbar from './Navbar.vue';

</script>
