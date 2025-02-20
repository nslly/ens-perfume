<template>
    <Head title="Register" />
    <AppLayout>
        <div class="flex justify-start items-center h-screen flex-col py-8">
            <form @submit.prevent="register">
                <div class="bg-[#fafafa] w-[550px] py-8 px-6 rounded-xl space-y-8 shadow-md">
                    <h1 class="text-2xl font-bold flex justify-center items-center">Sign Up</h1>
                    <div class="space-y-6">
                        <TextInput 
                            v-model="form.name" 
                            label="Name" 
                            type="text"
                            placeholder="Enter your name"
                            :error="errors.name ?? ''" 

                        />

                        <TextInput 
                            v-model="form.email" 
                            label="Email" 
                            type="email"
                            placeholder="Enter your email"
                            :error="errors.email ?? ''" 

                        />


                        <TextInput 
                            v-model="form.password" 
                            label="Password" 
                            type="password"
                            placeholder="Enter your password"
                            :error="errors.password ?? ''" 

                        />

                    </div>
                    <div class="flex  items-center spacex-8">
                        <Checkbox v-model="terms" />
                        <div>
                            <p class="text-sm ml-4">
                                By creating an account, you agree on our 
                                <span class="font-semibold text-[#0D0D60]">
                                    Terms and Condition
                                </span>
                            </p>
                        </div>
                    </div>
                    <p v-if="errors.error" class="text-red-500 text-sm">{{ errors.error }}</p>
                    <div class="w-full">
                        <PrimaryButton type="submit" class="text-lg w-full">
                            Register
                        </PrimaryButton>
                    </div>

                </div>
            </form>

        </div>
    </AppLayout>
</template>



<script setup>
    import { Head, useForm } from '@inertiajs/vue3'
    import { ref } from 'vue'
    import TextInput from '@/Components/Input/Textbox.vue'
    import Checkbox from '@/Components/Input/Checkbox.vue'
    import PrimaryButton from '@/Components/Button/Primary.vue';
    import AppLayout from '../../../Layouts/AppLayout.vue';

    const errors = ref({});
    const terms = ref(false);
    

    const form = useForm({
        name: '',
        email: '',
        password: '',
    });

    const register = () => {
        if (!terms.value) {
            errors.value = {
                'error': 'Please agree to the Terms and Conditions before submitting.'
            }
        } else {
            form.post('/register', {
                preserveScroll: true,
                onError: (err) => {
                    console.log(errors.value)
                    errors.value = { ...err }
                }
            })
        }
    };
</script>