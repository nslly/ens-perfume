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
                <Link :href="page.props.auth.user ? '/cart' : '/login'">
                    <div class="relative">
                        <i class="material-icons text-[#0D0D60]">shopping_bag</i>
                        <div v-if="cartCount" class="absolute -bottom-2 -right-2 bg-[#FFBF00] rounded-full w-5 h-5 flex items-center justify-center text-xs text-[#fafafa]">
                            {{ cartCount }}
                        </div>
                    </div>
                </Link>
                
                <Link v-if="!authenticated" href="/login">
                    <PrimaryButton class="text-sm">
                        Login 
                        <i class="material-icons">
                            person
                        </i>
                    </PrimaryButton>
                </Link>
                <Dropdown v-else>

                    <template #trigger>
                        <p class="text-sm flex items-center space-x-1 font-medium text-[#0D0D60]">
                            <i class="material-icons">account_circle</i>
                            <span class="text-[#1F2123]">{{ user.name }}</span>
                        </p>
                    </template>

                    <template #menu>
                        <Link 
                            href="/profile"
                            class="flex items-center space-x-2 px-4 py-2 text-sm text-[#0D0D60] w-full hover:bg-[#0D0D60] hover:text-[#ffffff] text-left"
                        >
                            <i class="material-icons text-sm">person</i>
                            <span>Profile</span>
                        </Link>
                        
                        <button 
                            @click="logout"
                            class="flex items-center space-x-2 px-4 py-2 text-sm text-[#0D0D60] hover:bg-[#0D0D60] hover:text-[#ffffff] w-full text-left"
                        >
                            <i class="material-icons text-sm">logout</i>
                            <span>Logout</span>
                        </button>
                    </template>
                </Dropdown>
            </div>
        </div>

        
    </nav>
</template>

<script setup>
    import { Link, usePage, router } from '@inertiajs/vue3';
    import { computed } from 'vue';
    import PrimaryButton from '@/Components/Button/Primary.vue';
    import Dropdown from '@/Components/Dropdown/Dropdown.vue';

    /**
     * 
     * State
     */
    const page = usePage();



    const authenticated = computed(() => page.props.auth.isAuthenticated);
    const user = computed(() => page.props.auth.user.data);
    const cartCount = computed(() => page.props.auth.cart_count);


    /**
     * 
     * Functions
     */

    const logout = () => {
        router.post('/logout');
    };


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