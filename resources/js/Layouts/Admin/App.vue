<template>
    <div class="flex w-full h-screen overflow-hidden">
        <Sidebar :showSide="showSide" />

        <!-- Main content -->
        <div class="flex flex-col w-full h-full overflow-hidden bg-slate-100">            
            <!-- Navbar -->
            <Navbar @toggle-sidebar="toggleSideBar" />

            <div class="flex-1 p-8 overflow-auto">
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