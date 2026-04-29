@extends('themes.modern.frontend.layouts.app')

@section('title', ($title ?? 'Contact') . ' — ' . ($settings['site_name'] ?? 'TechJournal'))

@section('content')
<div class="max-w-[1200px] mx-auto px-8 py-12">

    {{-- Breadcrumbs --}}
    <nav aria-label="Breadcrumb" class="mb-6 flex items-center text-sm font-meta text-outline">
        <a class="hover:text-primary transition-colors" href="{{ url('/') }}">Home</a>
        <span aria-hidden="true" class="mx-2 material-symbols-outlined text-[16px]">chevron_right</span>
        <span aria-current="page" class="text-on-surface font-medium">{{ $title ?? 'Contact' }}</span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        {{-- Main Content --}}
        <div class="lg:col-span-8">
            <h1 class="font-h1 text-h1 text-on-surface mb-8">{{ $title ?? 'Contact Us' }}</h1>

            @if(!empty($content))
                <div class="article-content font-body-md text-body-md text-on-surface-variant leading-relaxed mb-10">
                    {!! $content !!}
                </div>
            @endif

            {{-- Success Message --}}
            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-6 py-4 rounded-xl mb-8 font-meta">
                    <span class="material-symbols-outlined text-[18px] align-middle mr-2">check_circle</span>
                    {{ session('success') }}
                </div>
            @endif

            {{-- Contact Form --}}
            <div class="bg-surface-container-lowest rounded-xl p-8 border border-surface-variant">
                <h2 class="font-h3 text-h3 text-on-surface mb-6">{{ 'Send a Message' }}</h2>
                <form action="{{ route('contact.store') }}" method="POST" class="space-y-5">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block font-meta text-[12px] text-on-surface-variant mb-1 uppercase tracking-wider" for="contact-name">{{ 'Name' }} *</label>
                            <input id="contact-name" name="name" type="text" required value="{{ old('name') }}"
                                class="w-full bg-surface px-4 py-3 rounded border border-surface-variant focus:border-secondary focus:ring-1 focus:ring-secondary outline-none font-meta text-on-surface placeholder-outline"
                                placeholder="{{ 'Your name' }}">
                            @error('name') <p class="text-error text-sm mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block font-meta text-[12px] text-on-surface-variant mb-1 uppercase tracking-wider" for="contact-email">{{ 'Email' }} *</label>
                            <input id="contact-email" name="email" type="email" required value="{{ old('email') }}"
                                class="w-full bg-surface px-4 py-3 rounded border border-surface-variant focus:border-secondary focus:ring-1 focus:ring-secondary outline-none font-meta text-on-surface placeholder-outline"
                                placeholder="{{ 'Your email' }}">
                            @error('email') <p class="text-error text-sm mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div>
                        <label class="block font-meta text-[12px] text-on-surface-variant mb-1 uppercase tracking-wider" for="contact-subject">{{ 'Subject' }}</label>
                        <input id="contact-subject" name="subject" type="text" value="{{ old('subject') }}"
                            class="w-full bg-surface px-4 py-3 rounded border border-surface-variant focus:border-secondary focus:ring-1 focus:ring-secondary outline-none font-meta text-on-surface placeholder-outline"
                            placeholder="{{ 'Subject of your message' }}">
                    </div>
                    <div>
                        <label class="block font-meta text-[12px] text-on-surface-variant mb-1 uppercase tracking-wider" for="contact-message">{{ 'Message' }} *</label>
                        <textarea id="contact-message" name="message" rows="6" required
                            class="w-full bg-surface px-4 py-3 rounded border border-surface-variant focus:border-secondary focus:ring-1 focus:ring-secondary outline-none font-meta text-on-surface placeholder-outline resize-none"
                            placeholder="{{ 'Write your message here...' }}">{{ old('message') }}</textarea>
                        @error('message') <p class="text-error text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                    <button type="submit" class="bg-secondary text-on-secondary px-8 py-3 rounded font-label-caps text-label-caps uppercase hover:opacity-90 transition-opacity">
                        {{ 'Send Message' }}
                    </button>
                </form>
            </div>
        </div>

        {{-- Sidebar --}}
        <aside class="lg:col-span-4 space-y-8">
            {{-- Contact Info --}}
            <div class="bg-surface-container-lowest rounded-xl p-6 border border-surface-variant sticky top-24">
                <h4 class="font-h3 text-[18px] text-on-surface mb-6 flex items-center gap-2">
                    <span class="material-symbols-outlined text-secondary">contact_support</span>
                    {{ 'Contact Info' }}
                </h4>
                <div class="space-y-5">
                    @if(!empty($settings['contact_address']))
                    <div class="flex items-start gap-3">
                        <span class="material-symbols-outlined text-[20px] text-secondary mt-0.5">location_on</span>
                        <p class="font-meta text-on-surface-variant text-sm">{{ $settings['contact_address'] }}</p>
                    </div>
                    @endif
                    @if(!empty($settings['contact_phone']))
                    <div class="flex items-start gap-3">
                        <span class="material-symbols-outlined text-[20px] text-secondary mt-0.5">phone</span>
                        <p class="font-meta text-on-surface-variant text-sm">{{ $settings['contact_phone'] }}</p>
                    </div>
                    @endif
                    @if(!empty($settings['contact_email']))
                    <div class="flex items-start gap-3">
                        <span class="material-symbols-outlined text-[20px] text-secondary mt-0.5">mail</span>
                        <a href="mailto:{{ $settings['contact_email'] }}" class="font-meta text-secondary text-sm hover:underline">{{ $settings['contact_email'] }}</a>
                    </div>
                    @endif
                </div>

                {{-- Social Links --}}
                <div class="mt-8 pt-6 border-t border-surface-variant">
                    <h5 class="font-label-caps text-[11px] text-on-surface-variant uppercase tracking-wider mb-4">{{ 'Follow Us' }}</h5>
                    <div class="flex gap-3">
                        @if(!empty($settings['social_facebook']))
                            <a href="{{ $settings['social_facebook'] }}" target="_blank" class="w-9 h-9 rounded-full bg-surface-container flex items-center justify-center text-on-surface-variant hover:bg-secondary hover:text-white transition-all">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/></svg>
                            </a>
                        @endif
                        @if(!empty($settings['social_twitter']))
                            <a href="{{ $settings['social_twitter'] }}" target="_blank" class="w-9 h-9 rounded-full bg-surface-container flex items-center justify-center text-on-surface-variant hover:bg-slate-900 hover:text-white transition-all">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                            </a>
                        @endif
                        @if(!empty($settings['social_youtube']))
                            <a href="{{ $settings['social_youtube'] }}" target="_blank" class="w-9 h-9 rounded-full bg-surface-container flex items-center justify-center text-on-surface-variant hover:bg-red-600 hover:text-white transition-all">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                            </a>
                        @endif
                        @if(!empty($settings['social_instagram']))
                            <a href="{{ $settings['social_instagram'] }}" target="_blank" class="w-9 h-9 rounded-full bg-surface-container flex items-center justify-center text-on-surface-variant hover:bg-pink-600 hover:text-white transition-all">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 1 0 0 12.324 6.162 6.162 0 0 0 0-12.324zM12 16a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm6.406-11.845a1.44 1.44 0 1 0 0 2.881 1.44 1.44 0 0 0 0-2.881z"/></svg>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </aside>
    </div>
</div>
@endsection
