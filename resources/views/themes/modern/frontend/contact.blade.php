@extends('themes.modern.frontend.layouts.app')

@section('title', ($title ?? 'Contact') . ' — ' . ($settings['site_name'] ?? 'TechJournal'))

@section('content')
<div class="max-w-[1200px] mx-auto px-8 pb-12 pt-0 md:pt-4">

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
        {{-- Main Content --}}
        <div class="lg:col-span-8 flex flex-col gap-10">
            <div>
                <h1 class="font-h1 text-h1 text-on-surface mb-6 tracking-tight leading-none">{{ $title ?? 'Contact Us' }}</h1>
                @if(!empty($content))
                    <div class="font-body-lg text-body-lg text-on-surface-variant leading-relaxed">
                        {!! $content !!}
                    </div>
                @endif
            </div>

            {{-- Success Message --}}
            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-6 py-4 rounded-xl font-meta flex items-center gap-3">
                    <span class="material-symbols-outlined text-[24px]">check_circle</span>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            @endif

            {{-- Contact Form --}}
            <div class="bg-surface-container-lowest rounded-3xl p-8 md:p-12 border border-outline-variant/30 shadow-premium">
                <h2 class="font-h2 text-h2 text-on-surface mb-8">{{ 'Send a Message' }}</h2>
                <form action="{{ route('contact.store') }}" method="POST" class="space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div class="flex flex-col gap-2">
                            <label class="font-label-caps text-[11px] text-on-surface-variant uppercase tracking-widest font-bold" for="contact-name">{{ 'Full Name' }} *</label>
                            <input id="contact-name" name="name" type="text" required value="{{ old('name') }}"
                                class="w-full bg-surface-container-low px-5 py-4 rounded-xl border border-transparent focus:border-secondary focus:bg-white focus:ring-0 outline-none font-meta text-on-surface placeholder-outline-variant transition-all"
                                placeholder="{{ 'John Doe' }}">
                            @error('name') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div class="flex flex-col gap-2">
                            <label class="font-label-caps text-[11px] text-on-surface-variant uppercase tracking-widest font-bold" for="contact-email">{{ 'Email Address' }} *</label>
                            <input id="contact-email" name="email" type="email" required value="{{ old('email') }}"
                                class="w-full bg-surface-container-low px-5 py-4 rounded-xl border border-transparent focus:border-secondary focus:bg-white focus:ring-0 outline-none font-meta text-on-surface placeholder-outline-variant transition-all"
                                placeholder="{{ 'john@example.com' }}">
                            @error('email') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div class="flex flex-col gap-2">
                        <label class="font-label-caps text-[11px] text-on-surface-variant uppercase tracking-widest font-bold" for="contact-subject">{{ 'Subject' }}</label>
                        <input id="contact-subject" name="subject" type="text" value="{{ old('subject') }}"
                            class="w-full bg-surface-container-low px-5 py-4 rounded-xl border border-transparent focus:border-secondary focus:bg-white focus:ring-0 outline-none font-meta text-on-surface placeholder-outline-variant transition-all"
                            placeholder="{{ 'How can we help you?' }}">
                    </div>
                    <div class="flex flex-col gap-2">
                        <label class="font-label-caps text-[11px] text-on-surface-variant uppercase tracking-widest font-bold" for="contact-message">{{ 'Message' }} *</label>
                        <textarea id="contact-message" name="message" rows="6" required
                            class="w-full bg-surface-container-low px-5 py-4 rounded-xl border border-transparent focus:border-secondary focus:bg-white focus:ring-0 outline-none font-meta text-on-surface placeholder-outline-variant transition-all resize-none"
                            placeholder="{{ 'Tell us more about your inquiry...' }}">{{ old('message') }}</textarea>
                        @error('message') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <button type="submit" class="bg-primary text-white px-10 py-4 rounded-xl font-label-caps text-sm uppercase tracking-widest hover:bg-secondary hover:shadow-premium-hover transition-all duration-300">
                        {{ 'Send Message' }}
                    </button>
                </form>
            </div>
        </div>

        {{-- Sidebar --}}
        <aside class="lg:col-span-4 flex flex-col gap-10">
            {{-- Contact Info --}}
            <div class="bg-surface-container-lowest rounded-3xl p-8 border border-outline-variant/30 shadow-premium sticky top-24">
                <h4 class="font-h3 text-h3 text-on-surface mb-8 flex items-center gap-3">
                    <span class="material-symbols-outlined text-secondary">contact_support</span>
                    {{ 'Get in Touch' }}
                </h4>
                <div class="flex flex-col gap-8">
                    @if(!empty($settings['contact_address']))
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-full bg-secondary/10 flex items-center justify-center text-secondary flex-shrink-0">
                            <span class="material-symbols-outlined text-[20px]">location_on</span>
                        </div>
                        <div class="flex flex-col">
                            <span class="font-label-caps text-[10px] text-outline uppercase tracking-widest font-bold mb-1">Our Office</span>
                            <p class="font-meta text-on-surface-variant text-sm leading-relaxed">{{ $settings['contact_address'] }}</p>
                        </div>
                    </div>
                    @endif
                    @if(!empty($settings['contact_phone']))
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-full bg-secondary/10 flex items-center justify-center text-secondary flex-shrink-0">
                            <span class="material-symbols-outlined text-[20px]">phone</span>
                        </div>
                        <div class="flex flex-col">
                            <span class="font-label-caps text-[10px] text-outline uppercase tracking-widest font-bold mb-1">Call Us</span>
                            <p class="font-meta text-on-surface-variant text-sm leading-relaxed">{{ $settings['contact_phone'] }}</p>
                        </div>
                    </div>
                    @endif
                    @if(!empty($settings['contact_email']))
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-full bg-secondary/10 flex items-center justify-center text-secondary flex-shrink-0">
                            <span class="material-symbols-outlined text-[20px]">mail</span>
                        </div>
                        <div class="flex flex-col">
                            <span class="font-label-caps text-[10px] text-outline uppercase tracking-widest font-bold mb-1">Email Support</span>
                            <a href="mailto:{{ $settings['contact_email'] }}" class="font-meta text-secondary text-sm font-bold hover:underline">{{ $settings['contact_email'] }}</a>
                        </div>
                    </div>
                    @endif
                </div>

                {{-- Social Links --}}
                <div class="mt-10 pt-8 border-t border-surface-container">
                    <h5 class="font-label-caps text-[11px] text-on-surface-variant uppercase tracking-widest font-bold mb-6">{{ 'Connect With Us' }}</h5>
                    <div class="flex gap-4">
                        @if(!empty($settings['social_facebook']))
                            <a href="{{ $settings['social_facebook'] }}" target="_blank" class="w-10 h-10 rounded-xl bg-surface-container-low flex items-center justify-center text-on-surface-variant hover:bg-secondary hover:text-white hover:-translate-y-1 transition-all duration-300">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/></svg>
                            </a>
                        @endif
                        @if(!empty($settings['social_twitter']))
                            <a href="{{ $settings['social_twitter'] }}" target="_blank" class="w-10 h-10 rounded-xl bg-surface-container-low flex items-center justify-center text-on-surface-variant hover:bg-slate-900 hover:text-white hover:-translate-y-1 transition-all duration-300">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                            </a>
                        @endif
                        @if(!empty($settings['social_instagram']))
                            <a href="{{ $settings['social_instagram'] }}" target="_blank" class="w-10 h-10 rounded-xl bg-surface-container-low flex items-center justify-center text-on-surface-variant hover:bg-pink-600 hover:text-white hover:-translate-y-1 transition-all duration-300">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 1 0 0 12.324 6.162 6.162 0 0 0 0-12.324zM12 16a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm6.406-11.845a1.44 1.44 0 1 0 0 2.881 1.44 1.44 0 0 0 0-2.881z"/></svg>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </aside>
    </div>
</div>
@endsection
