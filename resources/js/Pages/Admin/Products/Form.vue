<template>
    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
        <!-- Product Name -->
        <div>
            <TextInput
                id="name"
                label="Product Name" 
                placheholder="Enter Product"
                v-model="form.name"
                type="text"
                :error="errors.name ?? ''"
            />
        </div>

        <!-- Category -->
        <div>
            <SelectInput 
                v-model="form.category_id"
                label="Category"
                :options="categories"
                placeholder="Choose a category"
                :error="errors.category_id ?? ''"
            />
        </div>

        <!-- Brand -->
        <div>
            <SelectInput 
                v-model="form.brand_id"
                label="Brand"
                :options="brands"
                placeholder="Choose a brand"
                :error="errors.brand_id ?? ''"
            />
        </div>

        <!-- Volume -->
        <div>
            <TextInput
                id="volume"
                label="Volume (ml)" 
                placheholder="Enter Volume"
                v-model="form.volume"
                type="number"
                min=1
                :error="errors.volume ?? ''"
            />
        </div>

        <!-- Quantity -->
        <div>
            <TextInput
                id="quantity"
                label="Quantity" 
                placheholder="Enter Quantity"
                v-model="form.quantity"
                type="number"
                min="1"
                :error="errors.quantity ?? ''"
            />
        </div>

        <!-- Price -->
        <div>
            <TextInput
                id="price"
                label="Price" 
                placheholder="Enter Price"
                v-model="form.price"
                type="number"
                step="0.01"
                :error="errors.price ?? ''"
            />
        </div>

        <!-- Discount -->
        <div>
            <TextInput
                id="discount"
                label="Discount" 
                placheholder="Enter Discount"
                v-model="form.discount"
                type="number"
                step="0.01"
                min="0"
                max="100"
                :error="errors.discount ?? ''"
            />

        </div>

        <!-- Gender -->
        <div>
            <SelectInput 
                v-model="form.gender"
                label="Gender"
                :options="[
                    { id: '1', name: 'Male' },
                    { id: '2', name: 'Female' },
                    { id: '3', name: 'Unisex' }
                ]"
                placeholder="Choose Gender"
                :error="errors.gender ?? ''"
            />
        </div>

        <!-- Image Upload -->
        <div class="col-span-2">
            <FilePondUploader 
                v-model="form.images"
                :existing-files="existingImages"
            />

            <p v-if="errors.images" class="mt-1 text-sm text-red-500">{{ errors.images }}</p>
        </div>
    </div>

    <!-- Description -->
    <div class="mt-4">
        <Textarea 
            v-model="form.description"
            label="Description"
            placeholder="Enter text here..."
            :error="errors.description ?? ''"
        />
    </div>

    <slot name="action-button">
    </slot>

</template>

<script setup>
import { ref, computed } from 'vue';
import AppLayout from '@/Layouts/Admin/App.vue';
import PrimaryButton from '@/Components/Button/Primary.vue';
import TextInput from '@/Components/Input/Textbox.vue'
import SelectInput from '@/Components/Input/Select.vue'
import Textarea from '@/Components/Input/Textarea.vue'
import FilePondUploader from '@/Components/Uploader/Filepond.vue'
import SecondaryButton from '@/Components/Button/Secondary.vue';





// Props
const props = defineProps({
    form: {
        type: Object,
        required: true,
    },
    errors: {
        type: Object,
    },
    categories: {
        type: Array,
        required: true,
    },
    brands: {
        type: Array,
        required: true,
    }
});


const existingImages = computed(() => {
  return props.product?.images?.map(image => ({
    url: typeof image === 'string' ? `/storage/${image}` : image.url,
    source: typeof image === 'string' ? `/storage/${image}` : image.url
  })) || []
})


</script>
