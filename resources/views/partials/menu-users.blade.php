<x-nav-link :href="route('users.index')" :active="request()->routeIs('users.*')">
    {{ __('👥 Utilisateurs') }}
</x-nav-link>