<template>
    <div class="relative mx-auto max-w-7xl">
        <Swiper 
            v-bind="swiperConfig" 
            :modules="[Navigation, Pagination]"
            class="mySwiper product-carousel"
        >
            <SwiperSlide v-for="product in cartProducts" :key="product.id">
                <div class="flex flex-col items-center justify-center max-w-sm mx-auto overflow-hidden bg-white rounded shadow-lg">
                    <ProductCard :product="product"/>
                </div>
            </SwiperSlide>
        </Swiper>
    </div>
</template>

<script setup>
    import { defineProps, ref } from "vue";
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
