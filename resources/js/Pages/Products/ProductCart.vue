<template>
    <div class="max-w-7xl mx-auto relative">
        <Swiper 
            v-bind="swiperConfig" 
            :modules="[Navigation, Pagination]"
            class="mySwiper product-carousel"
        >
            <SwiperSlide v-for="product in cartProducts" :key="product.id">
                <div class="max-w-sm rounded overflow-hidden shadow-lg flex flex-col items-center justify-center bg-white mx-auto">
                    <ProductCard :product="product"/>
                </div>
            </SwiperSlide>
        </Swiper>
    </div>
</template>

<script setup>
    import { defineProps, ref } from "vue";
    import { Swiper, SwiperSlide } from "swiper/vue";
    import { Navigation, Pagination } from 'swiper/modules';
    import { swiperConfig } from '@/Utils/swiper.js';

    import ProductCard from './Card/ProductCard.vue';

    /**
     * Props
     */
    const props = defineProps({
        products: {
            type: Array,
            required: true
        }
    });

    
    const cartProducts = ref(
        props.products.map(product => ({
            ...product, 
            quantity: 1,
            maxQuantity: product.quantity,
            finalPrice: product.discount 
                ? Math.floor(product.price - product.price * (product.discount / 100)) 
                : product.price
        }))
    );

</script>

<style scoped>
    .product-carousel {
        padding-bottom: 50px; 
    }


    .swiper-button-next,
    .swiper-button-prev {
        font-size: 10px;
        color: #ffffff;
        background: #0d0d60;
        padding: 34px;
        border-radius: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        top: 50%;
        transform: translateY(-50%);
    }

    .swiper-button-next::after,
    .swiper-button-prev::after {
        font-size: 20px;
    }

    :deep(.swiper-pagination-bullet) {
        width: 10px;
        height: 10px;
        background: #0d0d60;
        opacity: 0.5;
    }

    :deep(.swiper-pagination-bullet-active) {
        opacity: 1;
    }

    @media (max-width: 640px) {
        .swiper-button-next,
        .swiper-button-prev {
            display: none;
        }
    }
</style>
