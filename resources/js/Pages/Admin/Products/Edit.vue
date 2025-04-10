<template>
    <Head title="Product Edit" />

    <AppLayout>
        <div class="h-full p-6 bg-white rounded-lg shadow-md">
            <h1 class="mb-4 text-2xl font-bold">Edit Product</h1>

            <form @submit.prevent="updateProduct(productSlug)">
                <Form :form="form" :errors="errors" :brands="items.brands" :categories="items.categories"> 
                    <template #action-button>
                        <!-- Submit Button -->
                        <div class="flex justify-end gap-2 mt-6" action-button>
                            <SecondaryButton type="button" @click="goBack">
                                Cancel
                            </SecondaryButton>
                            <PrimaryButton                         
                                :disabled="form.processing"
                                type="submit">
                                {{ form.processing ? 'Updating...' : 'Update' }}
                            </PrimaryButton>
                        </div>
                    </template>
                </Form>
            </form>
        </div>

        <Alert 
            v-if="alertMessage" 
            :type="alertType" 
            :message="alertMessage" 
        />
    </AppLayout>
</template>

<script setup>
import { ref, defineProps, computed } from 'vue';
import { useForm, Head } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/Admin/App.vue';
import PrimaryButton from '@/Components/Button/Primary.vue';
import SecondaryButton from '@/Components/Button/Secondary.vue';
import Alert from '@/Components/Modal/Alert.vue'
import { useAuth } from '@/Composables/useAuth';
import Form from './Form.vue'



// Props
const props = defineProps({
    items: Object,
});

const productSlug = computed(() => props.items?.product?.slug || '');
const alertType = ref('');
const alertMessage = ref('');

const errors = ref({})
const { page } = useAuth();



// Form State
const form = useForm({
    name: props.items?.product?.name,
    price: props.items?.product?.price,
    category_id: props.items?.product?.category_id,
    brand_id: props.items?.product?.brand_id,
    volume: props.items?.product?.volume,
    quantity: props.items?.product?.quantity,
    discount: props.items?.product?.discount,
    gender: props.items?.product?.gender,
    images: props.items?.product?.images || [], // Ensure array
    description: props.items?.product?.description,
});


const updateProduct = async (slug) => {

    form.p(`/admin/products/${slug}`, {
        preserveScroll: true,
        onSuccess: () => {
            alertType.value = 'success';
            alertMessage.value = page.props.flash.success;
        },
        onError: (err) => {
            errors.value = { ...err };
            alertType.value = 'error';
            alertMessage.value = page.props.flash.error;
        }
    });

};



// Cancel and go back
const goBack = () => {
    window.history.back();
};
</script>
