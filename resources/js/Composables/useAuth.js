import { usePage } from '@inertiajs/vue3'
import { computed } from 'vue'
export function useAuth() {

    const page = usePage();
    const authenticated = computed(() => page.props.auth?.isAuthenticated ?? false);
    const user = computed(() => page.props.auth?.user?.data ?? null);
    const cartCount = computed(() => page.props.auth?.cart_count ?? 0);
    const logo = computed(() => page.props.logo ?? null);

    
    return { authenticated, user, cartCount, logo, page }
}
