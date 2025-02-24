import { usePage } from '@inertiajs/vue3'
import { computed } from 'vue'
export function useAuth() {

    const page = usePage();
    const authenticated = computed(() => page.props.auth?.isUserAuthenticated ?? false);
    const adminAuthenticated = computed(() => page.props.auth?.isAdminAuthenticated ?? false);
    const user = computed(() => page.props.auth.user?.data ?? null);
    const admin = computed(() => page.props.auth.admin?.data ?? null);
    const cartCount = computed(() => page.props.cart_count ?? 0);
    const logo = computed(() => page.props.logo ?? null);

    
    return { 
        authenticated, 
        user, 
        cartCount, 
        logo, 
        page, 
        adminAuthenticated,
        admin
    }
}
