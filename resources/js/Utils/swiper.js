import { Pagination, Navigation } from "swiper/modules";
import "swiper/css";
import "swiper/css/pagination";
import "swiper/css/navigation";

export const swiperConfig = {
    navigation: true,
    pagination: { 
        clickable: true,
        dynamicBullets: true
    },
    spaceBetween: 20,
    breakpoints: {
        320: { slidesPerView: 1 },
        640: { slidesPerView: 2 },
        768: { slidesPerView: 2 },
        1024: { slidesPerView: 3 },
    },
};