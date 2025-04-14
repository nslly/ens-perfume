<template>
    <div :class="['sidebar', { collapsed: !showSide }]"
        class="w-[300px] bg-white h-auto text-[#333333] transition-all duration-300">
        <div class="flex items-center justify-start p-4" v-if="showSide">
            <h3 class="text-xl font-bold">Admin Panel</h3>
        </div>
        <div class="p-2" v-else>
            <h3
                class="font-bold flex justify-center text-xl bg-[#0D0D60] rounded-full px-4 text-white text-center py-2">
                A</h3>
        </div>

        <hr />
        <div class="p-2 space-y-2">
            <!-- Products -->
            <div class="flex flex-col justify-between">
                <Link href="/admin/products"
                    class="menu-item inline-flex items-center py-[10px] px-[10px] w-full text-sm font-medium rounded-md border-slate-100 hover:bg-slate-100 hover:text-[#333333] transition duration-400 ease-in-out"
                    :class="{
                        'bg-slate-100 text-[#333333]': $page.url.startsWith('/admin/products'),
                        'justify-center': !showSide
                    }"
                >
                    <i class="text-2xl fill-current material-icons" :class="{ 'mr-2': showSide }">storefront</i>
                    <span class="ml-2 font-medium transition-all duration-300" v-if="showSide">Products</span>
                </Link>
            </div>

            <!-- Brands -->
            <div class="flex flex-col justify-between">
                <Link href="/admin/brands"
                    class="menu-item inline-flex items-center py-[10px] px-[10px] w-full text-sm font-medium rounded-md border-slate-100 hover:bg-slate-100 hover:text-[#333333] transition duration-400 ease-in-out"
                    :class="{
                        'bg-slate-100 text-[#333333]': $page.url.startsWith('/admin/brands'),
                        'justify-center': !showSide
                    }"
                >
                    <i class="text-2xl fill-current material-icons" :class="{ 'mr-2': showSide }">storefront</i>
                    <span class="ml-2 font-medium transition-all duration-300" v-if="showSide">Brands</span>
                </Link>
            </div>

            <!-- Categories -->
            <div class="flex flex-col justify-between">
                <Link href="/admin/categories"
                    class="menu-item inline-flex items-center py-[10px] px-[10px] w-full text-sm font-medium rounded-md border-slate-100 hover:bg-slate-100 hover:text-[#333333] transition duration-400 ease-in-out"
                    :class="{
                        'bg-slate-100 text-[#333333]': $page.url.startsWith('/admin/categories'),
                        'justify-center': !showSide
                    }"
                >
                    <i class="text-2xl fill-current material-icons" :class="{ 'mr-2': showSide }">storefront</i>
                    <span class="ml-2 font-medium transition-all duration-300" v-if="showSide">Category</span>
                </Link>
            </div>
        </div>


    </div>
</template>

<script setup>
    import { defineProps } from 'vue';
    import { Link } from '@inertiajs/vue3';

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
        transition: all 0.3s;
        border-radius: 0.375rem;
    }

    .menu-item svg {
        transition: transform 0.3s;
    }

    .sidebar.collapsed .menu-item span {
        display: none;
    }
</style>