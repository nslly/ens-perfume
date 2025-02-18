<template>
    <Teleport to="body">
    
        <div v-if="show" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-20">
            <div class="bg-white rounded-lg shadow-lg max-w-lg w-full p-6 transform transition-all"
                :class="sizeClass">
                <div class="flex justify-between items-center border-b pb-4">
                    <h3 class="text-lg font-semibold">{{ title }}</h3>
                    <button @click="close" class="text-3xl text-gray-400 hover:text-gray-700">
                        &times;
                    </button>
                </div>
                
                <div class="mt-8">
                    <slot></slot>
                </div>

                <div v-if="showFooter" class="mt-8 flex border-t justify-end space-x-3">
                    <SecondaryButton class="mt-6" v-if="showCancel" @click="close">
                        {{ cancelText }}
                    </SecondaryButton>
                    <PrimaryButton class="mt-6" v-if="showConfirm" @click="$emit('confirm')">
                        {{ confirmText }}
                    </PrimaryButton>
                </div>
            </div>
        </div>
    </Teleport>
</template>

<script setup>
    import { defineProps, defineEmits } from 'vue';
    import PrimaryButton from '@/Components/Button/Primary.vue';
    import SecondaryButton from '@/Components/Button/Secondary.vue';

    defineProps({
        show: Boolean,
        title: String,
        size: { 
            type: String, 
            default: 'md' 
        },
        showFooter: { 
            type: Boolean, 
            default: true 
        },
        showCancel: { 
            type: Boolean, 
            default: true 
        },
        showConfirm: { 
            type: Boolean, 
            default: true 
        },
        cancelText: { 
            type: String, 
            default: 'Cancel' 
        },
        confirmText: { 
            type: String, 
            default: 'Confirm' 
        }
    });

    const emits = defineEmits(['update:show', 'confirm']);

    const close = () => {
        emits('update:show', false);
    };

    const sizeClass = {
        sm: 'max-w-sm',
        md: 'max-w-lg',
        lg: 'max-w-2xl',
        xl: 'max-w-4xl',
    };
</script>
