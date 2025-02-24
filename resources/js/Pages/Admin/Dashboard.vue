<template>
    <Head title="Dashboard" />

    <AppLayout>
            Admin Dashboard




            <Alert 
                v-if="page.props.flash.success ?? page.props.flash.error" 
                :type="page.props.flash.success ? 'success' : 'error'" 
                :message="page.props.flash.success ?? page.props.flash.error"
            />

    </AppLayout>
</template>




<script setup>
    import AppLayout from '@/Layouts/Admin/App.vue';
    import { useAuth } from '@/Composables/useAuth.js';
    import Alert from '@/Components/Modal/Alert.vue';
    import { Head } from '@inertiajs/vue3';

    const { page } = useAuth();
</script>