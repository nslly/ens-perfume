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
            <label for="image" class="block text-sm font-medium text-gray-700">Product Image</label>
            <input 
                id="image"
                type="file"
                @change="handleImageUpload"
                accept="image/*"
                multiple
                :disabled="form.processing"
                :class="{ 'border-red-500': errors.images }"

            />
            <p class="mt-1 text-xs text-gray-500">
                Upload images (JPEG, PNG, GIF, SVG). Max 2MB each.
            </p>

            <div v-if="hasImageErrors" class="mt-1 space-y-1">
                <p v-for="(error, index) in formattedImageErrors" :key="index" class="text-sm text-red-500">
                    {{ error }}
                </p>
            </div>

            <div v-if="imagePreview.length" class="mt-2 w-full flex justify-end items-end">
                <button @click="clearAllImages" type="button" 
                        class="text-sm text-red-500 hover:text-red-600 font-bold">
                    Remove All Images
                </button>
            </div>


            <!-- Preview New Uploaded Images -->
            <div v-if="imagePreview.length" class="flex gap-8 mt-3">
                <img v-for="(image, index) in imagePreview" :key="index" :src="image" alt="Preview"
                    class="object-cover w-60 h-60 rounded-xl">
            </div>

            <!-- Display Existing Images -->
            <div v-if="form.images.length" class="flex gap-8 mt-3">
                <div v-for="(image, index) in form.images" :key="'existing-'+index" class="relative">
                    <img 
                        :src="getImageUrl(image)" 
                        class="object-cover w-60 h-60 rounded-xl"
                    >
                </div>
            </div>
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
import AppLayout from '@/Layouts/Admin/App.vue';
import PrimaryButton from '@/Components/Button/Primary.vue';
import TextInput from '@/Components/Input/Textbox.vue'
import SelectInput from '@/Components/Input/Select.vue'
import Textarea from '@/Components/Input/Textarea.vue'
import { ref, defineExpose, computed } from 'vue';
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


const imagePreview = ref([]);
const newFiles = ref([]); 


/**
 * Functions 
 */
const hasImageErrors = computed(() => {
    return props.errors.images || Object.keys(props.errors).some(k => k.startsWith('images.'));
});

const formattedImageErrors = computed(() => {
    const allErrors = [];
    if (props.errors.images) allErrors.push(props.errors.images);
    Object.entries(props.errors).forEach(([key, error]) => {
        if (key.startsWith('images.')) allErrors.push(`Image ${key.split('.')[1] + 1}: ${error}`);
    });
    return allErrors;
});


const clearAllImages = () => {
    imagePreview.value = [];
    newFiles.value = [];
    if (hasImageErrors.value) {
        form.clearErrors();
    }
};


const getImageUrl = (image) => {
    if (typeof image === 'string') {
        return image.startsWith('http') ? image : `/storage/${image}`;
    }
    return image.url ? `/storage/${image.url}` : '';
};



const handleImageUpload = (event) => {
    const files = event.target.files;
    if (!files.length) return;

    imagePreview.value = [];
    newFiles.value = Array.from(files);;

    newFiles.value.forEach(file => {
        const reader = new FileReader();
        reader.onload = (e) => imagePreview.value.push(e.target.result);
        reader.readAsDataURL(file);
    });

};

//  Expose newFiles so parent can access it
defineExpose({
    newFiles
});


</script>
