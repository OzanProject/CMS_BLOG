<footer class="bg-[#050810] text-white border-t border-slate-900/80 mt-24">

    {{-- Footer Body --}}
    <div class="max-w-7xl mx-auto px-6 lg:px-8 py-16">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12">

            {{-- Branding --}}
            <div class="lg:col-span-2">
                <a href="{{ url('/') }}" class="flex items-center gap-3 mb-6 group">
                    @if(!empty($settings['site_logo']))
                        <img src="{{ asset('storage/' . $settings['site_logo']) }}"
                             alt="{{ $settings['site_name'] ?? 'Logo' }}"
                             class="h-9 w-auto opacity-80 group-hover:opacity-100 transition-opacity">
                    @endif
                    <span class="font-headline font-black text-2xl uppercase tracking-wider text-white group-hover:text-amber-400 transition-colors">
                        {{ $settings['site_name'] ?? 'The Authority' }}
                    </span>
                </a>
                <p class="text-slate-500 text-sm leading-relaxed max-w-sm mb-8">
                    {{ $settings['site_description'] ?? 'Eksplorasi wawasan mendalam tentang teknologi dan jurnalisme modern.' }}
                </p>

                {{-- Dynamic Social Links --}}
                @php
                    $socials = [
                        'social_facebook'  => ['icon' => 'fab fa-facebook-f',  'hover' => 'hover:bg-blue-600'],
                        'social_twitter'   => ['icon' => 'fab fa-x-twitter',    'hover' => 'hover:bg-slate-700'],
                        'social_instagram' => ['icon' => 'fab fa-instagram',    'hover' => 'hover:bg-pink-600'],
                        'social_youtube'   => ['icon' => 'fab fa-youtube',      'hover' => 'hover:bg-red-600'],
                    ];
                @endphp
                <div class="flex gap-3">
                    @foreach($socials as $key => $meta)
                        @if(!empty($settings[$key]))
                            <a href="{{ $settings[$key] }}"
                               target="_blank" rel="noopener noreferrer"
                               class="w-10 h-10 rounded-full bg-slate-900 border border-slate-800 flex items-center justify-center text-slate-400 hover:text-white {{ $meta['hover'] }} transition-all duration-300">
                                <i class="{{ $meta['icon'] }} text-sm"></i>
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>

            {{-- Popular Categories --}}
            <div>
                <h4 class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-500 mb-6 pb-3 border-b border-slate-900">
                    Kategori
                </h4>
                <ul class="space-y-3">
                    @foreach(\App\Models\Category::take(6)->get() as $cat)
                        <li>
                            <a href="{{ route('category.show', $cat->slug) }}"
                               class="text-sm text-slate-400 hover:text-amber-400 flex items-center gap-2 transition-colors group">
                                <span class="w-1 h-1 rounded-full bg-amber-500/40 group-hover:bg-amber-500 transition-colors flex-shrink-0"></span>
                                {{ $cat->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- Publication Links --}}
            <div>
                <h4 class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-500 mb-6 pb-3 border-b border-slate-900">
                    Publikasi
                </h4>
                <ul class="space-y-3">
                    <li><a href="#" class="text-sm text-slate-400 hover:text-amber-400 transition-colors">Tentang Kami</a></li>
                    <li><a href="#" class="text-sm text-slate-400 hover:text-amber-400 transition-colors">Redaksi</a></li>
                    <li><a href="#" class="text-sm text-slate-400 hover:text-amber-400 transition-colors">Pedoman Media Siber</a></li>
                    <li><a href="#" class="text-sm text-slate-400 hover:text-amber-400 transition-colors">Disclaimer</a></li>
                    <li><a href="#" class="text-sm text-slate-400 hover:text-amber-400 transition-colors">Privacy Policy</a></li>
                    @if(!empty($settings['contact_email']))
                        <li>
                            <a href="mailto:{{ $settings['contact_email'] }}"
                               class="text-sm text-amber-500/70 hover:text-amber-400 transition-colors">
                               {{ $settings['contact_email'] }}
                            </a>
                        </li>
                    @endif
                </ul>
            </div>

        </div>
    </div>

    {{-- Copyright Bar --}}
    <div class="border-t border-slate-900/80 py-6">
        <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row justify-between items-center gap-3 text-xs text-slate-600">
            <p>
                {{ $settings['site_copyright'] ?? ('&copy; ' . date('Y') . ' ' . ($settings['site_name'] ?? 'Editorial') . '. All rights reserved.') }}
            </p>
            <p>Didesain dengan <span class="text-amber-600">◆</span> untuk Pembaca</p>
        </div>
    </div>

</footer>