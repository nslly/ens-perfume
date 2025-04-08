<template>
    <div class="w-full">
        <!-- Label -->
        <label v-if="label" class="block mb-1 text-sm font-semibold text-gray-700">
            {{ label }}
        </label>

        <!-- Select Input -->
        <div class="relative">
            <select
                :value="modelValue"
                @change="$emit('update:modelValue', $event.target.value)"
                class="block w-full px-4 py-3 border rounded-lg text-sm shadow-sm focus:outline-none transition-all duration-200
                    focus:ring focus:ring-[#0D0D60] focus:border-[#0D0D60] 
                    bg-white placeholder-gray-500 text-gray-600
                    dark:text-gray-600 dark:border-gray-600 dark:placeholder-gray-500
                    hover:border-[#0D0D60]"
                :class="[
                    error ? 'border-red-500 focus:ring-red-500' : 'border-gray-300',
                ]"
            >
                <option value="" disabled selected>{{ placeholder }}</option>
                <option v-for="option in options" :key="option.id" :value="option.id">
                    {{ option.name }}
                </option>
            </select>
        </div>

        <!-- Error Message -->
        <p v-if="error" class="mt-1 text-sm text-red-500">{{ error }}</p>
    </div>
</template>

<script setup>
import { defineProps, defineEmits } from 'vue';

const props = defineProps({
    label: String,         // Label text
    placeholder: String,   // Placeholder text
    modelValue: [String, Number],  // Supports v-model
    options: Array,        // Array of objects [{ id: 1, name: 'Category 1' }]
    error: String,         // Error message
});

defineEmits(['update:modelValue']);
</script>
