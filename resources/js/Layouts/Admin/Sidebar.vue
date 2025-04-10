<template>
    <div :class="['sidebar', { collapsed: !showSide }]"
        class="w-[300px] bg-[#0D0D60] h-auto text-white transition-all duration-300">
        <div class="p-4 flex justify-start items-center" v-if="showSide">
            <h3 class="font-bold text-xl">Admin Panel</h3>
        </div>
        <div class="p-2" v-else>
            <h3
                class="font-bold flex justify-center text-xl bg-slate-100 rounded-full px-4 text-[#3f474e] text-center py-2">
                A</h3>
        </div>

        <hr />
        <div class="p-4 space-y-2">
            <div class="flex flex-col justify-between ">
                <Link href="/admin/products" 
                    class="menu-item  inline-flex items-center py-[10px] px-[10px] w-full text-sm font-medium rounded-md border-gray-200 hover:bg-white hover:text-[#0D0D60] transition duration-400 ease-in-out" 
                    :class="{
                        'bg-white text-[#0D0D60]': $page.url.startsWith('/admin/products')
                    }"
                >
                    <i class="material-icons mr-2 text-2xl fill-current">storefront</i>


                    <span class="ml-2 font-medium" v-if="showSide">Products</span>
                </Link>
            </div>
            <div class="flex flex-col justify-between ">
                <Link href="/admin/brands" 
                    class="menu-item inline-flex items-center py-[10px] px-[10px] w-full text-sm font-medium rounded-md border-gray-200 hover:bg-white hover:text-[#0D0D60] transition duration-400 ease-in-out" 
                    :class="{
                        'bg-white text-[#0D0D60]': $page.url.startsWith('/admin/brands')
                    }"
                >
                    <i class="material-icons mr-2 text-2xl fill-current">storefront</i>


                    <span class="ml-2 font-medium" v-if="showSide">Brands</span>
                </Link>
            </div>
            <div class="flex flex-col justify-between ">
                <Link href="/admin/categories" 
                    class="menu-item inline-flex items-center py-[10px] px-[10px] w-full text-sm font-medium rounded-md border-gray-200 hover:bg-white hover:text-[#0D0D60] transition duration-400 ease-in-out" 
                    :class="{
                        'bg-white text-[#0D0D60]': $page.url.startsWith('/admin/categories')
                    }"
                >
                    <i class="material-icons mr-2 text-2xl fill-current">storefront</i>


                    <span class="ml-2 font-medium" v-if="showSide">Category</span>
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