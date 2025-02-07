<template>
    <button :type="type" class="bg-[#FFBF00] text-[#fafafa] font-semibold rounded-3xl px-12 py-2.5 flex items-center justify-center gap-2 hover:bg-[#E6A800] transition duration-300">
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