<template>
    <Head title="Login" />

    <AppLayout>
        <div class="flex justify-start items-center h-screen flex-col py-8">
            <form @submit.prevent="login">
                <div class="bg-[#fafafa] w-[550px] py-8 px-6 rounded-xl space-y-8 shadow-md">
                    <h1 class="text-2xl font-bold flex justify-center items-center">Sign In</h1>
                    <div class="space-y-6">
                        <TextInput 
                            v-model="email" 
                            label="Email" 
                            type="email"
                            placeholder="Enter your email"
                        />

                        <TextInput 
                            v-model="password" 
                            label="Password" 
                            type="password"
                            placeholder="Enter your password"
                        />
                    </div>
                    <div class="flex justify-between items-center spacex-8">
                        <Checkbox v-model="rememberMe" label="Remember Me" />
                        <div>
                            <p class="text-sm font-semibold text-[#0D0D60]">Forgot Password?</p>
                        </div>
                    </div>
                    <div class="w-full">
                        <PrimaryButton type="submit" class="text-lg w-full">
                            Login 
                        </PrimaryButton>
                    </div>
                    <div class="flex justify-center items-center space-x-8">
                        <p class="text-sm">Not registered yet?</p>
                        <Link href="/register" class="text-sm font-semibold text-[#0D0D60]">
                            Create an Account
                        </Link>
                    </div>

                </div>
            </form>


        </div>
    </AppLayout>




</template>

<script setup>
    import { Head, Link } from '@inertiajs/vue3'
    import { ref } from 'vue'
    import TextInput from '@/Components/Input/Textbox.vue'
    import Checkbox from '@/Components/Input/Checkbox.vue'
    import PrimaryButton from '@/Components/Button/Primary.vue';
    import AppLayout from '../../../Layouts/AppLayout.vue';

    const email = ref('');
    const password = ref('');
    const rememberMe = ref(false);

    const login = () => {
        console.log({ email: email.value, password: password.value, rememberMe: rememberMe.value });
    };
</script>