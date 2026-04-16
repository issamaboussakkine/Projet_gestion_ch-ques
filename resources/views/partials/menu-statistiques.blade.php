<x-nav-link :href="route('statistiques.index')" :active="request()->routeIs('statistiques.*')">
    {{ __('📊 Statistiques') }}
</x-nav-link>