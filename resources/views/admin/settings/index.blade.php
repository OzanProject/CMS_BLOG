@extends('layouts.admin')

@section('header', __('settings.title'))

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-12">
            <div class="bg-secondary rounded p-4">

            
                <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <!-- General Settings -->
                    <h6 class="mb-4 text-primary">{{ __('settings.general') }}</h6>
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3">
                            <label for="site_name" class="form-label">{{ __('settings.site_name') }}</label>
                            <input type="text" class="form-control" name="site_name" id="site_name" value="{{ $settings['site_name'] ?? '' }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="site_copyright" class="form-label">Copyright Text</label>
                            <input type="text" class="form-control" name="site_copyright" id="site_copyright" value="{{ $settings['site_copyright'] ?? '' }}">
                        </div>
                        <div class="col-12 mb-3">
                            <label for="site_description" class="form-label">{{ __('settings.site_description') }}</label>
                            <textarea class="form-control" name="site_description" id="site_description" rows="3">{{ $settings['site_description'] ?? '' }}</textarea>
                        </div>
                    </div>

                    <hr class="dropdown-divider bg-dark my-4">

                    <!-- Branding Settings -->
                    <h6 class="mb-4 text-primary">Branding</h6>
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3">
                            <label for="site_logo" class="form-label d-block">{{ __('settings.logo') ?? 'Site Logo' }}</label>
                            @if(isset($settings['site_logo']))
                                <div class="mb-2 p-2 bg-white rounded d-inline-block">
                                    <img src="{{ asset('storage/' . $settings['site_logo']) }}" alt="Current Logo" style="height: 50px;">
                                </div>
                            @endif
                            <input class="form-control bg-dark" type="file" name="site_logo" id="site_logo">
                            <div class="form-text">Recommended: PNG/SVG, max 2MB.</div>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="site_favicon" class="form-label d-block">{{ __('settings.favicon') ?? 'Favicon' }}</label>
                            @if(isset($settings['site_favicon']))
                                <div class="mb-2 p-1 bg-white rounded d-inline-block">
                                    <img src="{{ asset('storage/' . $settings['site_favicon']) }}" alt="Current Favicon" style="height: 32px;">
                                </div>
                            @endif
                            <input class="form-control bg-dark" type="file" name="site_favicon" id="site_favicon">
                            <div class="form-text">Recommended: 32x32px .ico or .png</div>
                        </div>
                    </div>

                    <hr class="dropdown-divider bg-dark my-4">

                    <!-- Advanced SEO & Analytics -->
                    <h6 class="mb-4 text-primary">SEO & Analytics (Google)</h6>
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Google Analytics / GTM ID</label>
                            <input type="text" class="form-control" name="google_analytics_id" value="{{ $settings['google_analytics_id'] ?? '' }}" placeholder="G-XXXXXXXXXX or GTM-XXXXXXX">
                            <div class="form-text">ID Tracking Google Analytics 4 or Google Tag Manager.</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Google Search Console Meta</label>
                            <input type="text" class="form-control" name="google_verification_code" value="{{ $settings['google_verification_code'] ?? '' }}" placeholder="content='...verification_code...'">
                            <div class="form-text">Paste the 'content' value from the HTML meta tag verification.</div>
                        </div>
                    </div>
                    
                    <h6 class="mb-4 text-primary">Monetization (AdSense)</h6>
                    <div class="row mb-4">
                        <div class="col-12 mb-3">
                            <label class="form-label">Ads.txt Content</label>
                            <textarea class="form-control font-monospace" name="ads_txt_content" rows="5" placeholder="google.com, pub-0000000000000000, DIRECT, f08c47fec0942fa0">{{ $settings['ads_txt_content'] ?? '' }}</textarea>
                            <div class="form-text">Content for /ads.txt file. Required for AdSense approval.</div>
                        </div>
                    </div>

                    <!-- Social Media Settings -->
                    <h6 class="mb-4 text-primary">{{ __('settings.social_media') }}</h6>
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Facebook</label>
                            <input type="text" class="form-control" name="social_facebook" value="{{ $settings['social_facebook'] ?? '' }}" placeholder="#">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Twitter</label>
                            <input type="text" class="form-control" name="social_twitter" value="{{ $settings['social_twitter'] ?? '' }}" placeholder="#">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Instagram</label>
                            <input type="text" class="form-control" name="social_instagram" value="{{ $settings['social_instagram'] ?? '' }}" placeholder="#">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">YouTube</label>
                            <input type="text" class="form-control" name="social_youtube" value="{{ $settings['social_youtube'] ?? '' }}" placeholder="#">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Google+</label>
                            <input type="text" class="form-control" name="social_google" value="{{ $settings['social_google'] ?? '' }}" placeholder="#">
                        </div>
                    </div>

                    <hr class="dropdown-divider bg-dark my-4">

                    <!-- Advertisement Settings -->
                    <h6 class="mb-4 text-primary">{{ __('settings.advertisements') }}</h6>
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Header Ad (728x90)</label>
                             @if(isset($settings['ad_header_image']))
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $settings['ad_header_image']) }}" class="img-fluid" style="max-height: 50px;">
                                </div>
                            @endif
                            <input class="form-control bg-dark mb-2" type="file" name="ad_header_image">
                            <input type="text" class="form-control mb-2" name="ad_header_url" value="{{ $settings['ad_header_url'] ?? '' }}" placeholder="Destination URL (http://...)">
                            <textarea class="form-control" name="ad_header_script" rows="4" placeholder="Or paste AdSense/Script code here...">{{ $settings['ad_header_script'] ?? '' }}</textarea>
                            <div class="form-text">Note: Script takes priority over Image if both are present.</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Sidebar Ad</label>
                             @if(isset($settings['ad_sidebar_image']))
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $settings['ad_sidebar_image']) }}" class="img-fluid" style="max-height: 100px;">
                                </div>
                            @endif
                            <input class="form-control bg-dark mb-2" type="file" name="ad_sidebar_image">
                            <input type="text" class="form-control mb-2" name="ad_sidebar_url" value="{{ $settings['ad_sidebar_url'] ?? '' }}" placeholder="Destination URL">
                            <textarea class="form-control" name="ad_sidebar_script" rows="4" placeholder="Or paste AdSense/Script code here...">{{ $settings['ad_sidebar_script'] ?? '' }}</textarea>
                            <div class="form-text">Note: Script takes priority over Image if both are present.</div>
                        </div>
                    </div>

                    <hr class="dropdown-divider bg-dark my-4">

                    <!-- Contact & About Information -->
                    <h6 class="mb-4 text-primary">{{ __('settings.contact') }}</h6>
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Address</label>
                            <input type="text" class="form-control" name="contact_address" value="{{ $settings['contact_address'] ?? '' }}" placeholder="123 Street, City, Country">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Phone</label>
                            <input type="text" class="form-control" name="contact_phone" value="{{ $settings['contact_phone'] ?? '' }}" placeholder="+123456789">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="contact_email" value="{{ $settings['contact_email'] ?? '' }}" placeholder="info@example.com">
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label">{{ __('settings.about_us') }}</label>
                            <textarea class="form-control" name="about_text" rows="4" placeholder="Short description about the site...">{{ $settings['about_text'] ?? '' }}</textarea>
                        </div>
                    </div>
                    <hr class="dropdown-divider bg-dark my-4">

                    <!-- Maintenance Mode -->
                    <h6 class="mb-4 text-primary">{{ __('settings.maintenance') }}</h6>
                    <div class="row mb-4">
                        <div class="col-md-12 mb-3">
                            <label class="form-label">{{ __('settings.maintenance_mode') }}</label>
                            <div class="form-check form-switch">
                                <input type="hidden" name="maintenance_mode" value="0">
                                <input class="form-check-input" type="checkbox" name="maintenance_mode" value="1" id="maintenance_mode" {{ isset($settings['maintenance_mode']) && $settings['maintenance_mode'] == '1' ? 'checked' : '' }}>
                                <label class="form-check-label" for="maintenance_mode">
                                    {{ isset($settings['maintenance_mode']) && $settings['maintenance_mode'] == '1' ? __('settings.active') : __('settings.inactive') }}
                                </label>
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label">{{ __('settings.maintenance_message') }}</label>
                            <textarea class="form-control" name="maintenance_message" rows="3" placeholder="We are currently performing maintenance...">{{ $settings['maintenance_message'] ?? '' }}</textarea>
                        </div>
                    </div>
                    
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary px-4">{{ __('common.save') }}</button>
                    </div>
                </form>
        </div>
        </div>
    </div>
</div>
@endsection
