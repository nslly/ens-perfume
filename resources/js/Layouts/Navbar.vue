<template>
    <nav class=" bg-[#f2f2f2] pt-2 border-b border-gray-200 inset-x-0 ">
        <div class="max-w-7xl mx-auto flex justify-between items-center ">

            <div>
                <Link href="/" class="text-blue-500">
                    <img :src="page.props.logo" alt="logo" class="mx-auto h-[80px] w-[80px]">
                </Link>
            </div>  
            <div class="flex justify-between items-center">
                <ul class="flex space-x-20 font-semibold">
                    <li>
                        <Link href="/" class="text-sm" :class="{ 'active' : $page.component.startsWith('Users/Home') }">
                            Home
                        </Link>
                    </li>
                    <li>
                        <Link href="/shop" class="text-sm" :class="{ 'active' : $page.component.startsWith('Users/Shop') }">
                            Shop
                        </Link>
                    </li>
                    <li>
                        <Link href="/brand" class="text-sm" :class="{ 'active' : $page.component.startsWith('Users/Brand') }">
                            Brand
                        </Link>
                    </li>
                    <li>
                        <Link href="/about-us" class="text-sm" :class="{ 'active' : $page.component.startsWith('Users/About') }">
                            About
                        </Link>
                    </li>
                </ul>
            </div>
            <div class="flex items-center justify-between space-x-8">
                <Link  href="/cart">
                    <i class="material-icons text-[#0D0D60]">
                        shopping_bag
                    </i>
                </Link>
                
                <Link href="/login">
                    <PrimaryButton  class="text-sm">
                        Login 
                        <i class="material-icons">
                            person
                        </i>
                    </PrimaryButton>
                </Link>
            </div>
        </div>

        
    </nav>
</template>

<script setup>
    import { Link, usePage } from '@inertiajs/vue3';
    import PrimaryButton from '@/Components/Button/Primary.vue';

    const page = usePage();




</script>

<style scoped>
.active {
    color: #fafafa;
    font-weight:700;
    background: #0D0D60;
    padding: 6px 14px; 
    border-radius: 4px;
}
</style>