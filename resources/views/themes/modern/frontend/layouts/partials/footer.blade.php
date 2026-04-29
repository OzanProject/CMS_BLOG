{{-- Footer --}}
<footer class="w-full border-t border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-950 text-slate-900 dark:text-slate-50 font-label-caps text-sm mt-16">
    <div class="max-w-[1200px] mx-auto px-8 py-16 grid grid-cols-1 md:grid-cols-2 gap-8">
        <div>
            <div class="text-lg font-bold text-slate-900 dark:text-slate-50 mb-4">{{ $settings['site_name'] ?? 'TechJournal' }}</div>
            <p class="text-slate-500 dark:text-slate-400 font-body-md text-base max-w-sm mb-6">
                {{ $settings['site_description'] ?? 'A premium publication dedicated to technical depth, architectural analysis, and the future of enterprise technology.' }}
            </p>

            {{-- Social Links --}}
            <div class="flex gap-3 mb-6">
                @if(!empty($settings['social_facebook']))
                    <a href="{{ $settings['social_facebook'] }}" target="_blank" rel="noopener noreferrer" class="w-9 h-9 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-500 hover:bg-secondary hover:text-white transition-all" aria-label="Facebook">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/></svg>
                    </a>
                @endif
                @if(!empty($settings['social_twitter']))
                    <a href="{{ $settings['social_twitter'] }}" target="_blank" rel="noopener noreferrer" class="w-9 h-9 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-500 hover:bg-slate-900 hover:text-white transition-all" aria-label="Twitter/X">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                    </a>
                @endif
                @if(!empty($settings['social_youtube']))
                    <a href="{{ $settings['social_youtube'] }}" target="_blank" rel="noopener noreferrer" class="w-9 h-9 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-500 hover:bg-red-600 hover:text-white transition-all" aria-label="YouTube">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                    </a>
                @endif
                @if(!empty($settings['social_instagram']))
                    <a href="{{ $settings['social_instagram'] }}" target="_blank" rel="noopener noreferrer" class="w-9 h-9 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-500 hover:bg-pink-600 hover:text-white transition-all" aria-label="Instagram">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 1 0 0 12.324 6.162 6.162 0 0 0 0-12.324zM12 16a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm6.406-11.845a1.44 1.44 0 1 0 0 2.881 1.44 1.44 0 0 0 0-2.881z"/></svg>
                    </a>
                @endif
            </div>

            <div class="text-slate-500 dark:text-slate-400">
                {{ $settings['site_copyright'] ?? '© ' . date('Y') . ' ' . ($settings['site_name'] ?? 'Ozan Project') . '. All rights reserved.' }}
            </div>
        </div>
        <div class="grid grid-cols-2 gap-8">
            <div class="flex flex-col space-y-3">
                <span class="text-slate-900 dark:text-slate-50 font-semibold mb-2">Pages</span>
                @foreach(\App\Models\Page::where('status', 1)->take(5)->get() as $pageLink)
                    <a class="text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-100 underline decoration-slate-300 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-secondary rounded px-1 -mx-1"
                       href="{{ route('page.show', $pageLink->slug) }}">{{ $pageLink->title }}</a>
                @endforeach
                <a class="text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-100 underline decoration-slate-300 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-secondary rounded px-1 -mx-1"
                   href="{{ route('contact.index') }}">{{ 'Contact' }}</a>
            </div>
            <div class="flex flex-col space-y-3">
                <span class="text-slate-900 dark:text-slate-50 font-semibold mb-2">Categories</span>
                @foreach(\App\Models\Category::take(6)->get() as $cat)
                    <a class="text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-100 underline decoration-slate-300 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-secondary rounded px-1 -mx-1"
                       href="{{ route('category.show', $cat->slug) }}">{{ $cat->name }}</a>
                @endforeach
            </div>
        </div>
    </div>
</footer>