<header
  class="w-full sticky top-0 z-50 bg-[#0A0F1C]/95 backdrop-blur-xl border-b border-[#D4AF37]/30 shadow-lg shadow-black/40">

  <div class="max-w-7xl mx-auto px-4 md:px-8">
    <div class="w-full py-5 flex flex-col md:flex-row justify-between items-center gap-4 md:gap-0">

      <a href="{{ url('/') }}" class="flex items-center gap-3 group">
        @if(isset($settings['site_logo']))
          <img src="{{ asset('storage/' . $settings['site_logo']) }}" alt="Logo {{ $settings['site_name'] ?? '' }}"
            class="h-10 w-auto opacity-90 group-hover:opacity-100 transition-opacity">
        @endif
        <span
          class="font-headline font-black text-2xl md:text-3xl uppercase tracking-[0.15em] text-white group-hover:text-[#D4AF37] transition-colors">
          {{ $settings['site_name'] ?? 'OZAN PROJECT' }}
        </span>
      </a>

      <div class="flex items-center gap-4 md:gap-6 w-full md:w-auto justify-between md:justify-end">
        <form action="{{ route('search') }}" method="GET"
          class="flex-grow md:flex-grow-0 flex items-center bg-slate-900 border border-slate-700 hover:border-[#D4AF37]/50 px-4 py-2 rounded focus-within:border-[#D4AF37] transition-all">
          <span class="material-symbols-outlined text-slate-400 text-sm mr-2">search</span>
          <input name="q"
            class="bg-transparent border-none focus:ring-0 text-sm w-full md:w-48 text-slate-200 placeholder:text-slate-500"
            placeholder="Search articles..." type="text" value="{{ request('q') }}" />
        </form>

        @auth
          <a href="{{ route('admin.dashboard') }}"
            class="hidden md:block material-symbols-outlined text-slate-400 hover:text-[#D4AF37] transition-colors"
            title="Dashboard">dashboard</a>
        @endauth

        <button
          class="hidden md:block bg-gradient-to-r from-[#C5A059] to-[#D4AF37] hover:from-[#D4AF37] hover:to-[#E5C158] text-slate-950 px-6 py-2.5 rounded text-xs font-black uppercase tracking-[0.15em] shadow-lg transition-all">
          Subscribe
        </button>
      </div>
    </div>
  </div>

  <div class="w-full bg-slate-950 border-t border-slate-900">
    <div class="max-w-7xl mx-auto px-4 md:px-8">
      <nav
        class="w-full flex items-center justify-start md:justify-center gap-6 md:gap-10 py-3.5 overflow-x-auto no-scrollbar">
        <a href="{{ url('/') }}"
          class="text-[11px] md:text-xs font-bold uppercase tracking-[0.15em] transition-colors whitespace-nowrap {{ request()->is('/') ? 'text-[#D4AF37]' : 'text-slate-400 hover:text-white' }}">Home</a>

        @foreach(\App\Models\Category::all() as $cat)
          <a href="{{ route('category.show', $cat->slug) }}"
            class="text-[11px] md:text-xs font-bold uppercase tracking-[0.15em] transition-colors whitespace-nowrap {{ request()->is('category/' . $cat->slug) ? 'text-[#D4AF37]' : 'text-slate-400 hover:text-white' }}">
            {{ $cat->name }}
          </a>
        @endforeach
      </nav>
    </div>
  </div>
</header>