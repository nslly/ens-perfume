<template>
    <Teleport to="body">
        <transition 
            enter-active-class="transform transition-all duration-300 ease-out"
            enter-from-class="translate-x-full opacity-0"
            enter-to-class="translate-x-0 opacity-100"
            leave-active-class="transform transition-all duration-300 ease-in"
            leave-from-class="translate-x-0 opacity-100"
            leave-to-class="translate-x-full opacity-0"
        >
            <div v-if="visible" class="fixed top-4 right-4 flex items-center justify-between w-80 p-4 rounded-lg shadow-lg" :class="alertClasses">
                <span>{{ message }}</span>
                <button @click="closeAlert" class="text-gray-500 hover:text-gray-700 font-bold text-3xl">
                    &times;
                </button>
            </div>
        </transition>
    </Teleport>
</template>

<script setup>
import { ref, defineProps, onMounted } from 'vue';

const props = defineProps({
    type: { type: String, required: true }, // success, error, warning, info
    message: { type: String, required: true },
    duration: { type: Number, default: 2000 } // Auto-close after 3s
});

const visible = ref(true);

const closeAlert = () => {
    visible.value = false;
};

// Auto-hide after a set duration
onMounted(() => {
    if (props.duration > 0) {
        setTimeout(closeAlert, props.duration);
    }
});

// Alert styles based on type
const alertClasses = {
    success: "bg-green-100 text-green-700 border-l-4 border-green-500",
    error: "bg-red-100 text-red-700 border-l-4 border-red-500",
    warning: "bg-yellow-100 text-yellow-700 border-l-4 border-yellow-500",
    info: "bg-blue-100 text-blue-700 border-l-4 border-blue-500"
}[props.type] || "bg-gray-100 text-gray-700 border-l-4 border-gray-500";
</script>
