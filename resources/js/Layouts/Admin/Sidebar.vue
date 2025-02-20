<template>
    <div :class="['sidebar', { collapsed: !showSide }]"
        class="w-[300px] bg-[#343a40] text-white transition-all duration-300">
        <div class="py-4 px-8" v-if="showSide">
            <h3 class="font-bold text-xl">Admin</h3>
        </div>
        <div class="p-2" v-else>
            <h3
                class="font-bold flex justify-center text-xl bg-slate-100 rounded-full px-4 text-[#3f474e] text-center py-2">
                A</h3>
        </div>

        <hr />
        <div class="px-2 space-y-4">

            <div class="flex flex-col justify-between ">
                <Link href="/products" class="menu-item" :class="[
                    'inline-flex  mt-4 items-center py-[10px] px-[10px] w-full text-sm font-medium rounded-md border-gray-200 transition duration-400 ease-in-out',
                    $page.component.startsWith('/products') ? 'bg-blue-600 text-gray-800' : 'hover:bg-blue-600 hover:text-white',
                    showSide ? 'justify-start' : 'justify-center items-center'
                ]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 w-[25px] h-[25px] fill-current"
                        viewBox="0 0 576 512">
                        <path
                            d="M547.6 103.8L490.3 13.1C485.2 5 476.1 0 466.4 0L109.6 0C99.9 0 90.8 5 85.7 13.1L28.3 103.8c-29.6 46.8-3.4 111.9 51.9 119.4c4 .5 8.1 .8 12.1 .8c26.1 0 49.3-11.4 65.2-29c15.9 17.6 39.1 29 65.2 29c26.1 0 49.3-11.4 65.2-29c15.9 17.6 39.1 29 65.2 29c26.2 0 49.3-11.4 65.2-29c16 17.6 39.1 29 65.2 29c4.1 0 8.1-.3 12.1-.8c55.5-7.4 81.8-72.5 52.1-119.4zM499.7 254.9c0 0 0 0-.1 0c-5.3 .7-10.7 1.1-16.2 1.1c-12.4 0-24.3-1.9-35.4-5.3L448 384l-320 0 0-133.4c-11.2 3.5-23.2 5.4-35.6 5.4c-5.5 0-11-.4-16.3-1.1l-.1 0c-4.1-.6-8.1-1.3-12-2.3L64 384l0 64c0 35.3 28.7 64 64 64l320 0c35.3 0 64-28.7 64-64l0-64 0-131.4c-4 1-8 1.8-12.3 2.3z" />
                    </svg>

                    <span class="ml-2" v-if="showSide">Products</span>
                </Link>
            </div>
            <Link href="/products/create" class="menu-item" :class="[
                'inline-flex mt-1 items-center py-[10px] px-[10px] w-full text-sm font-medium rounded-md border-gray-200 transition duration-400 ease-in-out',
                $page.component.startsWith('/products/create') ?  'bg-blue-600 text-gray-800' : 'hover:bg-blue-600 hover:text-white',
                showSide ? 'justify-start' : 'justify-center items-center'
            ]">
                <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 w-[25px] h-[25px] fill-current"
                    viewBox="0 0 512 512">
                    <path
                        d="M432 256c0 13.3-10.7 24-24 24H280v128c0 13.3-10.7 24-24 24s-24-10.7-24-24V280H80c-13.3 0-24-10.7-24-24s10.7-24 24-24h152V104c0-13.3 10.7-24 24-24s24 10.7 24 24v128h128c13.3 0 24 10.7 24 24z" />
                </svg>
                <span class="ml-2" v-if="showSide">Create Product</span>
            </Link>

        </div>

    </div>
</template>

<script setup>
    import { defineProps } from 'vue'
    import { Link } from '@inertiajs/vue3'

    defineProps({
        showSide: {
            type: Boolean,
            default: true,
        },
    });
</script>



<style scoped>
    .sidebar {
        width: 300px;
        transition: width 0.3s ease;
    }

    .sidebar.collapsed {
        width: 80px;
    }

    .menu-item {
        display: flex;
        align-items: center;
        padding: 8px;
        transition: all 0.3s;
        border-radius: 0.375rem;
        color: white;
    }

    .menu-item svg {
        transition: transform 0.3s;
    }

    .sidebar.collapsed .menu-item span {
        display: none;
    }
</style>