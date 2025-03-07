<template>
    <div class="w-full">
        <label v-if="label" class="block mb-1 text-sm font-semibold text-gray-700">
            {{ label }}
        </label>

        <div class="relative">
            <input 
                :type="type"
                :value="modelValue"
                @input="$emit('update:modelValue', $event.target.value)"
                class="block w-full px-4 py-3 border rounded-lg text-sm shadow-sm focus:outline-none transition-all duration-200
                    focus:ring focus:ring-[#0D0D60] focus:border-[#0D0D60] 
                    bg-white placeholder-gray-500 text-gray-600
                    dark:text-gray-600 dark:border-gray-600 dark:placeholder-gray-500
                    hover:border-[#0D0D60]
                    "
                :class="[
                    error ? 'border-red-500 focus:ring-red-500' : 'border-gray-300',
                ]"
                :placeholder="placeholder"
            />
        </div>

        <!-- Error Message -->
        <p v-if="error" class="mt-1 text-sm text-red-500">{{ error }}</p>
    </div>
</template>

<script setup>
    import { defineProps, defineEmits } from 'vue';

    const props = defineProps({
        label: String,        // Input label
        placeholder: String,  // Placeholder text
        modelValue: [String, Number],   // v-model support
        type: {
            type: String,
            default: 'text'  // Default type is text
        },
        error: String,        // Error message (optional)
    });

    defineEmits(['update:modelValue']); 
</script>