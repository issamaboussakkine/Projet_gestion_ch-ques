<x-nav-link :href="route('parametres.profil')" :active="request()->routeIs('parametres.*')">
    {{ __('⚙️ Paramètres') }}
</x-nav-link>