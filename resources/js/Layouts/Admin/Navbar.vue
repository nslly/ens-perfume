<template>
    <div class="bg-white flex items-center justify-between shadow-sm px-6 w-full py-[18px] z-10 border-b">
        <div class="cursor-pointer w-[30px]" @click="toggleSidebar">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="w-[25px] h-[25px]">
                <path
                    d="M0 96C0 78.3 14.3 64 32 64H416c17.7 0 32 14.3 32 32s-14.3 32-32 32H32C14.3 128 0 113.7 0 96zM0 256c0-17.7 14.3-32 32-32H416c17.7 0 32 14.3 32 32s-14.3 32-32 32H32c-17.7 0-32-14.3-32-32zM448 416c0 17.7-14.3 32-32 32H32c-17.7 0-32-14.3-32-32s14.3-32 32-32H416c17.7 0 32-14.3 32 32z" />
            </svg>
        </div>

        <!-- <div class="w-full flex justify-center">
            <form class="flex items-center w-[500px]">
                <div class="relative w-full">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg aria-hidden="true" class="w-5 h-auto text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" />
                        </svg>
                    </div>
                    <input type="text" class="bg-gray-50 border border-gray-300 text-sm rounded-lg pl-10 p-2.5 w-full"
                        placeholder="Search..." />
                </div>
            </form>
        </div> -->

        <div class="relative flex items-center justify-end space-x-4">
            <Dropdown>

                <template #trigger>
                    <p class="text-sm flex items-center space-x-1 font-medium text-[#0D0D60]">
                        <i class="material-icons">account_circle</i>
                        <span class="text-[#1F2123]">{{ user.name }}</span>
                    </p>
                </template>

                <template #menu>
                    <!-- <Link 
                        href="/profile"
                        class="flex items-center space-x-2 px-4 py-2 text-sm text-[#0D0D60] w-full hover:bg-[#0D0D60] hover:text-[#ffffff] text-left"
                    >
                        <i class="material-icons text-sm">person</i>
                        <span>Profile</span>
                    </Link> -->
                    
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
</template>

<script setup>
    import Dropdown from '@/Components/Dropdown/Dropdown.vue';
    import { router } from '@inertiajs/vue3';
    import { useAuth } from '@/Composables/useAuth.js';
    import { defineEmits } from 'vue';
    
    const emit = defineEmits(['toggleSidebar']);
    const toggleSidebar = () => {
        emit('toggleSidebar');
    };


    const { authenticated, user, cartCount, logo } = useAuth();


    
    const logout = () => {
        router.post('/admin/logout');
    };



</script>
