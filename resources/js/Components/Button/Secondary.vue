<template>
    <button :type="type" class=" border-2 text-[#0D0D60] border-[#0D0D60] font-medium rounded-3xl px-12 py-2.5 flex items-center gap-2 hover:bg-[#0D0D60] hover:text-[#fafafa] transition duration-300">
        <slot>{{ title }} </slot>
    </button>
</template>


<script setup>
    import { defineProps } from 'vue';

    const props = defineProps({
        type: {
            type: String,
            default: "button"
        }
    })
</script>