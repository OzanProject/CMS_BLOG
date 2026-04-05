<footer class="bg-gray-950 text-white border-t-4 border-blue-600">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12">
            
            <div>
                <div class="flex items-center space-x-3 mb-6">
                    <div class="w-12 h-12 bg-gradient-to-r from-blue-600 to-purple-600 rounded-2xl flex items-center justify-center">
                        <i class="fas fa-newspaper text-white text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-2xl font-extrabold tracking-tight">{{ $settings['site_name'] ?? 'NewsHub' }}</h3>
                        <p class="text-gray-400 text-xs font-bold uppercase tracking-widest">Berita Terkini</p>
                    </div>
                </div>
                <p class="text-gray-400 text-sm leading-relaxed">
                    {{ $settings['site_description'] ?? 'Sumber berita terpercaya dengan liputan lengkap dari seluruh Indonesia dan dunia.' }}
                </p>
            </div>
            
            <div>
                <h4 class="text-lg font-bold mb-6 text-gray-100">Kategori Populer</h4>
                <ul class="space-y-3">
                    @foreach(\App\Models\Category::take(5)->get() as $cat)
                        <li>
                            <a href="{{ route('category.show', $cat->slug) }}" class="text-gray-400 hover:text-blue-500 flex items-center transition-colors">
                                <i class="fas fa-angle-right text-xs mr-2"></i> {{ $cat->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div>
                <h4 class="text-lg font-bold mb-6 text-gray-100">Informasi</h4>
                <ul class="space-y-3">
                    <li><a href="#" class="text-gray-400 hover:text-blue-500 flex items-center transition-colors"><i class="fas fa-angle-right text-xs mr-2"></i> Tentang Kami</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-blue-500 flex items-center transition-colors"><i class="fas fa-angle-right text-xs mr-2"></i> Redaksi</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-blue-500 flex items-center transition-colors"><i class="fas fa-angle-right text-xs mr-2"></i> Pedoman Media Siber</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-blue-500 flex items-center transition-colors"><i class="fas fa-angle-right text-xs mr-2"></i> Disclaimer</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-lg font-bold mb-6 text-gray-100">Ikuti Kami</h4>
                <div class="flex gap-4 mb-6">
                    <a href="#" class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center text-gray-400 hover:bg-blue-600 hover:text-white transition-all">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center text-gray-400 hover:bg-blue-400 hover:text-white transition-all">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center text-gray-400 hover:bg-pink-600 hover:text-white transition-all">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center text-gray-400 hover:bg-red-600 hover:text-white transition-all">
                        <i class="fab fa-youtube"></i>
                    </a>
                </div>
                <a href="#" class="inline-flex items-center text-sm font-bold text-white bg-gray-800 hover:bg-gray-700 px-5 py-3 rounded-xl transition-colors">
                    <i class="fas fa-envelope mr-2 text-blue-500"></i> Hubungi Kami
                </a>
            </div>
            
        </div>

        <div class="mt-16 pt-8 border-t border-gray-800 flex flex-col md:flex-row justify-between items-center gap-4 text-sm text-gray-500">
            <p>&copy; {{ date('Y') }} {{ $settings['site_name'] ?? 'NewsHub' }}. All rights reserved.</p>
            <p>Didesain dengan <i class="fas fa-heart text-red-500 mx-1"></i> untuk Pembaca.</p>
        </div>
    </div>
</footer>