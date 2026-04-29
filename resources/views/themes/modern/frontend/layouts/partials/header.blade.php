{{-- TopNavBar --}}
<nav class="sticky top-0 w-full z-50 bg-white/80 dark:bg-slate-950/80 backdrop-blur-md border-b border-slate-100 dark:border-slate-800 shadow-[0_4px_16px_rgba(15,23,42,0.04)] font-label-caps text-sm font-medium tracking-tight text-slate-900 dark:text-slate-100">
    <div class="max-w-[1200px] mx-auto px-8 h-16 flex items-center justify-between">
        <a aria-label="{{ $settings['site_name'] ?? 'TechJournal' }} Home" class="text-xl font-extrabold tracking-tighter text-slate-900 dark:text-slate-50 uppercase cursor-pointer active:scale-95 transition-all duration-200 hover:opacity-80" href="{{ url('/') }}">
            {{ $settings['site_name'] ?? 'TechJournal' }}
        </a>

        {{-- Dynamic Category Navigation --}}
        <div class="hidden md:flex space-x-6 items-center">
            @php $navCategories = \App\Models\Category::take(6)->get(); @endphp
            @foreach($navCategories as $cat)
                <a class="font-medium cursor-pointer active:scale-95 transition-all duration-200 hover:opacity-80 {{ request()->is('category/' . $cat->slug) ? 'text-slate-900 dark:text-slate-50 border-b-2 border-slate-900 dark:border-slate-50 pb-1 font-semibold' : 'text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-100' }}"
                   href="{{ route('category.show', $cat->slug) }}">{{ $cat->name }}</a>
            @endforeach
        </div>

        <div class="flex items-center gap-4">
            <button id="darkModeToggle" aria-label="Toggle Dark Mode" class="material-symbols-outlined text-slate-900 dark:text-slate-50 cursor-pointer active:scale-95 transition-all duration-200 hover:opacity-80">dark_mode</button>
            <button id="searchToggle" aria-label="Search site" class="material-symbols-outlined text-slate-900 dark:text-slate-50 cursor-pointer active:scale-95 transition-all duration-200 hover:opacity-80">search</button>

            {{-- Mobile Menu Toggle --}}
            <button id="mobileMenuToggle" aria-label="Menu" class="md:hidden material-symbols-outlined text-slate-900 dark:text-slate-50 cursor-pointer">menu</button>

            @auth
                <a href="{{ route('admin.dashboard') }}" class="hidden md:inline-block bg-primary text-on-primary px-4 py-2 rounded font-label-caps text-label-caps cursor-pointer active:scale-95 transition-all duration-200 hover:opacity-80">Dashboard</a>
            @endauth
        </div>
    </div>

    {{-- Mobile Menu --}}
    <div id="mobileMenu" class="hidden md:hidden bg-white dark:bg-slate-900 border-t border-slate-100 dark:border-slate-800 px-8 pb-4">
        @foreach($navCategories ?? [] as $cat)
            <a class="block py-2 text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white font-medium" href="{{ route('category.show', $cat->slug) }}">{{ $cat->name }}</a>
        @endforeach
    </div>
</nav>

{{-- Search Overlay --}}
<div id="searchOverlay" class="hidden fixed inset-0 z-[60] bg-black/50 backdrop-blur-sm items-center justify-center">
    <div class="bg-white dark:bg-slate-900 rounded-xl p-6 w-full max-w-lg mx-4 shadow-2xl">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-h3 text-h3 text-on-surface dark:text-white">Search</h3>
            <button id="closeSearch" class="material-symbols-outlined text-slate-500 hover:text-slate-900 dark:hover:text-white cursor-pointer">close</button>
        </div>
        <form action="{{ route('search') }}" method="GET">
            <div class="flex gap-2">
                <input id="searchOverlayInput" name="q" type="text" placeholder="{{ 'Search articles...' }}" value="{{ request('q') }}"
                    class="flex-1 bg-surface dark:bg-slate-800 text-on-surface dark:text-white px-4 py-3 rounded border border-surface-variant dark:border-slate-700 focus:border-secondary focus:ring-1 focus:ring-secondary outline-none font-meta placeholder-outline">
                <button type="submit" class="bg-primary text-on-primary px-6 py-3 rounded font-label-caps text-label-caps hover:opacity-90 transition-opacity">
                    <span class="material-symbols-outlined text-[20px]">search</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const mobileToggle = document.getElementById('mobileMenuToggle');
        const mobileMenu = document.getElementById('mobileMenu');
        if (mobileToggle && mobileMenu) {
            mobileToggle.addEventListener('click', function() {
                mobileMenu.classList.toggle('hidden');
                mobileToggle.textContent = mobileMenu.classList.contains('hidden') ? 'menu' : 'close';
            });
        }

        // Search Overlay Logic
        const searchToggle = document.getElementById('searchToggle');
        const closeSearch = document.getElementById('closeSearch');
        const searchOverlay = document.getElementById('searchOverlay');
        const searchInput = document.getElementById('searchOverlayInput');

        if (searchToggle && searchOverlay) {
            searchToggle.addEventListener('click', () => {
                searchOverlay.classList.remove('hidden');
                searchOverlay.classList.add('flex');
                if (searchInput) searchInput.focus();
            });
        }

        if (closeSearch && searchOverlay) {
            closeSearch.addEventListener('click', () => {
                searchOverlay.classList.add('hidden');
                searchOverlay.classList.remove('flex');
            });
        }

        if (searchOverlay) {
            searchOverlay.addEventListener('click', (e) => {
                if (e.target === searchOverlay) {
                    searchOverlay.classList.add('hidden');
                    searchOverlay.classList.remove('flex');
                }
            });
        }
    });
</script>