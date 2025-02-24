<template>
    <div class="w-screen h-screen flex overflow-hidden">
        <Sidebar :showSide="showSide" />

        <!-- Main content -->
        <div class="w-full bg-gray-100">
            <!-- Navbar -->
            <Navbar @toggle-sidebar="toggleSideBar" />

            <div class="py-8 px-6">
                <slot />
            </div>
        </div>
    </div>
</template>


<script setup>
    import Sidebar from './Sidebar.vue';
    import Navbar from './Navbar.vue';
    import { ref } from 'vue';

    const showSide = ref(true);
    const toggleSideBar = () => {
        showSide.value = !showSide.value;
    };



</script>