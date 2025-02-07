<template>
    <Head title="Home" />

    <AppLayout>
        <div class="h-[800px] absolute top-0 left-0 w-screen bg-[url('/images/bg.jpg')] bg-cover bg-center bg-no-repeat" style="z-index:-1">
        

            <div class=" text-[#fafafa] flex items-center justify-center h-full max-w-7xl mx-auto">
                <div class="text-center flex flex-col">
                    <h1 class="text-8xl leading-tight drop-shadow-lg font-bold">Discover the Essence of You</h1>
                    <h2 class="text-2xl mt-4 text-gray-200 drop-shadow-md">A fragrance that defines your essence and lingers in every memory.</h2>
                    <div class="flex justify-center items-center space-x-4 mt-8">
                        <PrimaryButton  class="text-lg">
                            Discover More 
                        </PrimaryButton>
                        <SecondaryButton  class="text-lg">
                            New Release
                        </SecondaryButton>
                    </div>
                </div>
            </div>
            {{ props.isAuthenticated }}
        </div>

    </AppLayout>
        

</template>

<script setup>
    import { Head } from '@inertiajs/vue3'
    import { defineProps } from 'vue';
    import AppLayout from '@/Layouts/AppLayout.vue';
    import PrimaryButton from '@/Components/Button/Primary.vue';
    import SecondaryButton from '@/Components/Button/Secondary.vue';

    const props = defineProps({
        user: Object,
        isAuthenticated: Boolean
    });
</script>