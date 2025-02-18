<template>
    <Head title="Home" />

    <AppLayout>
        <div class="h-[800px] w-screen bg-[url('/images/bg.jpg')] bg-cover bg-center bg-no-repeat">
            <!-- Background Section -->
            <div class="text-[#fafafa] flex items-center justify-center h-full max-w-7xl mx-auto">
                <div class="text-center flex flex-col">
                    <h1 class="text-8xl leading-tight drop-shadow-lg font-bold">Discover the Essence of You</h1>
                    <h2 class="text-2xl mt-4 text-gray-200 drop-shadow-md">A fragrance that defines your essence and lingers in every memory.</h2>
                    <div class="flex justify-center items-center space-x-4 mt-8">
                        <PrimaryButton class="text-lg">Discover More</PrimaryButton>
                        <SecondaryButton class="text-lg">New Release</SecondaryButton>
                    </div>
                </div>
            </div>

        </div>
        <div class="mt-8 max-w-7xl mx-auto ">
            <ProductCard :products="items"/>
        </div>



        
        <Alert 
            v-if="$page.props.flash.success ?? $page.props.flash.error" 
            :type="$page.props.flash.success ? 'success' : 'error'" 
            :message="$page.props.flash.success ?? $page.props.flash.error"
        />

    </AppLayout>

</template>

<script setup>
    import { Head } from '@inertiajs/vue3';
    import { defineProps } from 'vue';
    import AppLayout from '@/Layouts/AppLayout.vue';
    import PrimaryButton from '@/Components/Button/Primary.vue';
    import SecondaryButton from '@/Components/Button/Secondary.vue';
    import ProductCard from '../Products/ProductCart.vue';
    import Alert from '@/Components/Modal/Alert.vue'

    const props = defineProps({
        items: Object
    });
</script>