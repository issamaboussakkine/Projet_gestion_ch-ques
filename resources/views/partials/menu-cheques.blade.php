<x-nav-link :href="route('cheques.index')" :active="request()->routeIs('cheques.*')" class="text-white hover:text-sea">
    {{ __('📄 Chèques') }}
</x-nav-link>