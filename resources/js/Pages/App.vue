<template>
    <div class="relative h-screen flex bg-white">
        <Navbar />

    </div>
</template>

<script setup>

import { defineProps } from 'vue';
import Navbar from '../Component/Users/Navbar.vue'

const props = defineProps([
    'message'
])

// export default {
//     props: {
//         message: String,
//     },
// };
</script>