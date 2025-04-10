<template>
    <div class="w-screen h-full flex overflow-hidden">
        <Sidebar :showSide="showSide" />

        <!-- Main content -->
        <div class="w-full h-full flex flex-col bg-gray-100">
            <!-- Navbar -->
            <Navbar @toggle-sidebar="toggleSideBar" />

            <div class="flex-1 overflow-y-auto py-8 px-6">
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