<template>
    <label class="flex items-center cursor-pointer">
        <!-- Native Checkbox (Hidden) -->
        <input 
            type="checkbox"
            :checked="modelValue"
            @change="$emit('update:modelValue', $event.target.checked)"
            class="hidden peer"
        />
        
        <!-- Custom Checkbox -->
        <div class="w-5 h-5 flex items-center justify-center border-2 border-gray-400 rounded-md 
                    peer-checked:bg-[#0D0D60] peer-checked:border-[#0D0D60]
                    transition-all duration-200">
            <svg v-if="modelValue" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white" class="h-4 w-4">
                <path fill-rule="evenodd" d="M20.707 5.293a1 1 0 00-1.414 0L9 15.586l-4.293-4.293a1 1 0 00-1.414 1.414l5 5a1 1 0 001.414 0l11-11a1 1 0 000-1.414z" clip-rule="evenodd"/>
            </svg>
        </div>
        
        <!-- Label -->
        <span v-if="label" class="text-gray-700 ml-2 text-sm select-none">{{ label }}</span>
    </label>
</template>

<script setup>
import { defineProps, defineEmits } from 'vue';

defineProps({
    modelValue: Boolean, // Supports v-model for state binding
    label: String        // Checkbox label
});

defineEmits(['update:modelValue']);
</script>