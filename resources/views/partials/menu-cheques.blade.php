<x-nav-link :href="route('cheques.index')" :active="request()->routeIs('cheques.*')">
    {{ __('📄 Chèques') }}
</x-nav-link>