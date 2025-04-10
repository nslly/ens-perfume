<template>
    <Head title="Product Edit" />

    <AppLayout>
        <div class="h-full p-6 bg-white rounded-lg shadow-md">
            <h1 class="mb-4 text-2xl font-bold">Create Product</h1>

            <form @submit.prevent="createProduct">
                <Form  ref="formRef" :form="form" :brands="brands" :categories="categories" :errors="errors"> 
                    <template #action-button>
                        <!-- Submit Button -->
                        <div class="flex justify-end gap-2 mt-6" action-button>
                            <SecondaryButton type="button" @click="goBack">
                                Cancel
                            </SecondaryButton>
                            <PrimaryButton                         
                                :disabled="form.processing"
                                type="submit">
                                {{ form.processing ? 'Creating...' : 'Submit' }}
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


const errors = ref({})


const alertType = ref('');
const alertMessage = ref('');


const formRef = ref(null);


const { page } = useAuth();
const brands = computed(() => props.items?.brands);
const categories = computed(() => props.items?.categories);

// Form State
const form = useForm({
    name: null,
    price: null,
    category_id: null,
    brand_id: null,
    volume: null,
    quantity: null,
    discount: null,
    gender: null,
    images: [],
    description: null,
});


// Update Product Method
const createProduct = async () => {

    const files = formRef.value?.newFiles || [];

    
    form.transform((data) => {
        const formData = new FormData();
        
        Object.keys(data).forEach(key => {
            if (key !== 'images') {
                formData.append(key, data[key] || '');
            }
        });
        
        if (files.length > 0) {
            files.forEach((file, index) => {
                formData.append(`images[${index}]`, file);
            });
        }
        
        return formData;
    }).post('/admin/products', {
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
