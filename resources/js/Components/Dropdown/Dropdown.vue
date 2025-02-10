<template>
    <div ref="dropdownRef" class="relative dropdown-container">
        <!-- Dropdown Trigger -->
        <div @click.prevent="toggleDropdown" class="cursor-pointer">
            <slot name="trigger"></slot>
        </div>

        <!-- Dropdown Menu -->
        <Transition
            enter-active-class="transition transform duration-200 ease-out"
            enter-from-class="opacity-0 scale-95"
            enter-to-class="opacity-100 scale-100"
            leave-active-class="transition transform duration-150 ease-in"
            leave-from-class="opacity-100 scale-100"
            leave-to-class="opacity-0 scale-95"
        >
            <div 
                v-if="isOpen" 
                class="absolute right-0 mt-2 w-40 bg-white rounded-lg shadow-lg py-1 font-medium z-10"
            >
                <slot name="menu"></slot>
            </div>
        </Transition>
    </div>
</template>

<script setup>
    import { ref, onMounted, onUnmounted } from 'vue';
    import { eventBus } from '@/eventBus'; 

    const isOpen = ref(false);
    const dropdownRef = ref(null);

    const toggleDropdown = () => {
        if (isOpen.value) {
            isOpen.value = false;
        } else {
            eventBus.emit('close-other-dropdowns');
            isOpen.value = true;
        }
    };

    const closeDropdown = () => {
        isOpen.value = false;
    };

    const handleClickOutside = (event) => {
        if (dropdownRef.value && !dropdownRef.value.contains(event.target)) {
            isOpen.value = false;
        }
    };

    // Lifecycle Hooks
    onMounted(() => {
        eventBus.on('close-other-dropdowns', closeDropdown);
        document.addEventListener('click', handleClickOutside);
    });

    onUnmounted(() => {
        eventBus.off('close-other-dropdowns', closeDropdown);
        document.removeEventListener('click', handleClickOutside);
    });
</script>
