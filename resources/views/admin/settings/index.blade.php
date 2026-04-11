@extends('layouts.admin')

@section('header', __('settings.title'))

@section('content')
<div class="container-fluid pt-4 px-3 px-md-4 mb-5">
    <div class="row g-4">
        <div class="col-12 pb-5">
            <div class="bg-secondary rounded p-3 p-md-4 shadow-sm border border-dark">
                <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
                    <h5 class="mb-0 text-white font-headline">
                        <i class="fa fa-sliders-h me-2 text-primary"></i>System Configuration
                    </h5>
                    <div class="d-flex gap-2">
                        <span class="badge bg-dark border border-secondary text-white-50 p-2 px-3 rounded-pill h6 mb-0">
                            <i class="fa fa-clock me-1 text-primary"></i> Last Update: {{ Carbon\Carbon::now()->format('H:i') }}
                        </span>
                    </div>
                </div>

                <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Professional Tab Navigation (Scrollable on Mobile) -->
                    <div class="settings-nav-wrapper mb-4">
                        <ul class="nav nav-pills flex-nowrap overflow-auto pb-2 no-scrollbar" id="settingsTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="general-tab" data-bs-toggle="pill" data-bs-target="#general" type="button" role="tab">
                                    <i class="fa fa-desktop me-2"></i>General
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="seo-tab" data-bs-toggle="pill" data-bs-target="#seo" type="button" role="tab">
                                    <i class="fa fa-search-plus me-2"></i>SEO & Global
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link position-relative" id="monetization-tab" data-bs-toggle="pill" data-bs-target="#monetization" type="button" role="tab">
                                    <i class="fa fa-hand-holding-usd me-2 text-warning"></i>Monetization
                                    <span class="position-absolute top-0 start-100 translate-middle p-1 bg-warning border border-light rounded-circle animate-pulse-slow d-none d-md-block" style="width: 8px; height: 8px;"></span>
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="comm-tab" data-bs-toggle="pill" data-bs-target="#comm" type="button" role="tab">
                                    <i class="fa fa-envelope-open-text me-2"></i>Social & Mail
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="system-tab" data-bs-toggle="pill" data-bs-target="#system" type="button" role="tab">
                                    <i class="fa fa-shield-alt me-2"></i>Maintenance
                                </button>
                            </li>
                        </ul>
                    </div>

                    <!-- Tab Content -->
                    <div class="tab-content" id="settingsTabsContent">
                        
                        <!-- TAB 1: General -->
                        <div class="tab-pane fade show active" id="general" role="tabpanel">
                            <div class="row g-4">
                                <div class="col-lg-7">
                                    <div class="card card-premium mb-4">
                                        <div class="card-header-premium">
                                            <i class="fa fa-info-circle text-primary"></i> Site Information
                                        </div>
                                        <div class="card-body p-4">
                                            <div class="row g-3">
                                                <div class="col-12 mb-3">
                                                    <label class="form-label-premium">Site Name</label>
                                                    <input type="text" class="form-control" name="site_name" value="{{ $settings['site_name'] ?? '' }}" placeholder="Enter site title">
                                                </div>
                                                <div class="col-12 mb-3">
                                                    <label class="form-label-premium">Site Description/Tagline</label>
                                                    <textarea class="form-control" name="site_description" rows="2">{{ $settings['site_description'] ?? '' }}</textarea>
                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label-premium">Copyright Footer</label>
                                                    <input type="text" class="form-control" name="site_copyright" value="{{ $settings['site_copyright'] ?? '' }}" placeholder="&copy; 2024 Your Company">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-5">
                                    <div class="card card-premium">
                                        <div class="card-header-premium">
                                            <i class="fa fa-image text-primary"></i> Visual Branding
                                        </div>
                                        <div class="card-body p-4">
                                            <div class="mb-4 text-center">
                                                <label class="form-label-premium d-block text-start">Site Logo</label>
                                                <div class="logo-preview-box mb-3 mx-auto">
                                                    @if(isset($settings['site_logo']))
                                                        <img src="{{ asset('storage/' . $settings['site_logo']) }}" class="img-fluid rounded border border-dark">
                                                    @else
                                                        <i class="fa fa-image fa-3x text-white-50"></i>
                                                    @endif
                                                </div>
                                                <input type="file" class="form-control form-control-sm bg-dark border-secondary" name="site_logo">
                                            </div>
                                            <div class="mb-0 text-center">
                                                <label class="form-label-premium d-block text-start">Favicon (.ico)</label>
                                                <div class="favicon-preview-box mb-3 mx-auto">
                                                    @if(isset($settings['site_favicon']))
                                                        <img src="{{ asset('storage/' . $settings['site_favicon']) }}" width="48">
                                                    @else
                                                        <i class="fa fa-star text-white-50"></i>
                                                    @endif
                                                </div>
                                                <input type="file" class="form-control form-control-sm bg-dark border-secondary" name="site_favicon">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- TAB 2: SEO -->
                        <div class="tab-pane fade" id="seo" role="tabpanel">
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="card card-premium h-100">
                                        <div class="card-header-premium">
                                            <i class="fa fa-chart-line text-success"></i> Search & Analytics
                                        </div>
                                        <div class="card-body p-4">
                                            <div class="mb-4">
                                                <label class="form-label-premium">Google Analytics / GTM ID</label>
                                                <div class="input-group">
                                                    <span class="input-group-text bg-dark border-secondary text-success"><i class="fa fa-google"></i></span>
                                                    <input type="text" class="form-control" name="google_analytics_id" value="{{ $settings['google_analytics_id'] ?? '' }}" placeholder="G-XXXXXXXX">
                                                </div>
                                                <small class="text-white-50">Supports GA4 (G-XXX) and Tag Manager (GTM-XXX)</small>
                                            </div>
                                            <div class="mb-0">
                                                <label class="form-label-premium">Search Console Verification</label>
                                                <textarea class="form-control font-monospace small" name="google_verification_code" rows="3" placeholder="Paste verification meta tag here">{{ $settings['google_verification_code'] ?? '' }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card card-premium h-100">
                                        <div class="card-header-premium">
                                            <i class="fa fa-file-invoice text-info"></i> Crawler Access
                                        </div>
                                        <div class="card-body p-4">
                                            <label class="form-label-premium">Ads.txt Content</label>
                                            <textarea class="form-control font-monospace small bg-dark text-success border-secondary" name="ads_txt_content" rows="8" placeholder="google.com, pub-xxxxxxxxxxxxxxxx, DIRECT, f08c47fec0942fa0">{{ $settings['ads_txt_content'] ?? '' }}</textarea>
                                            <small class="text-white-50 mt-2 d-block">Required for AdSense transparency. One entry per line.</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- TAB 3: Monetization -->
                        <div class="tab-pane fade" id="monetization" role="tabpanel">
                            <div class="row g-4">

                                <!-- AdSense Overview -->
                                <div class="col-md-6">
                                    <div class="card card-premium border-primary h-100">
                                        <div class="card-header-premium d-flex justify-content-between align-items-center">
                                            <span><i class="fa fa-google text-primary me-2"></i>Google AdSense</span>
                                            <div class="form-check form-switch m-0">
                                                <input type="hidden" name="adsense_active" value="0">
                                                <input class="form-check-input" type="checkbox" name="adsense_active" value="1" id="ads_act" {{ ($settings['adsense_active'] ?? '') == '1' ? 'checked' : '' }}>
                                            </div>
                                        </div>
                                        <div class="card-body p-4">
                                            <div class="mb-4">
                                                <label class="form-label-premium">Publisher ID (ca-pub-XXX)</label>
                                                <input type="text" class="form-control" name="adsense_client_id" value="{{ $settings['adsense_client_id'] ?? '' }}" placeholder="ca-pub-XXXXXXXXXX">
                                            </div>
                                            <div class="bg-dark-soft p-3 rounded border border-secondary mb-0">
                                                <div class="form-check form-switch mb-2">
                                                    <input type="hidden" name="adsense_auto_ads" value="0">
                                                    <input class="form-check-input" type="checkbox" name="adsense_auto_ads" value="1" id="auto_ads" {{ ($settings['adsense_auto_ads'] ?? '') == '1' ? 'checked' : '' }}>
                                                    <label class="form-check-label ms-2 text-white h6 mb-0" for="auto_ads">Auto Ads Injection</label>
                                                </div>
                                                <small class="text-white-50 d-block ps-4">Automatically injects AdSense script into entire site's &lt;head&gt;.</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Local Ad Fallbacks -->
                                <div class="col-md-6">
                                    <div class="card card-premium h-100">
                                        <div class="card-header-premium">
                                            <i class="fa fa-ad text-warning"></i> Fallback / Manual Units
                                        </div>
                                        <div class="card-body p-4">
                                            <div class="mb-3">
                                                <label class="form-label-premium">Header Fallback (728x90)</label>
                                                <textarea class="form-control font-monospace h-textarea-fixed" name="ad_header_script" placeholder="HTML/Script for header ad">{{ $settings['ad_header_script'] ?? '' }}</textarea>
                                            </div>
                                            <div class="mb-0">
                                                <label class="form-label-premium">Sidebar Fallback (300x250)</label>
                                                <textarea class="form-control font-monospace h-textarea-fixed" name="ad_sidebar_script" placeholder="HTML/Script for sidebar ad">{{ $settings['ad_sidebar_script'] ?? '' }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- In-Article Logic -->
                                <div class="col-12">
                                    <div class="card card-premium border-warning">
                                        <div class="card-header-premium d-flex justify-content-between align-items-center">
                                            <span><i class="fa fa-newspaper text-warning me-2"></i>In-Article Ad Injection</span>
                                            <div class="form-check form-switch m-0 border-warning">
                                                <input type="hidden" name="ad_in_article_active" value="0">
                                                <input class="form-check-input" type="checkbox" name="ad_in_article_active" value="1" id="in_art_act" {{ ($settings['ad_in_article_active'] ?? '') == '1' ? 'checked' : '' }}>
                                            </div>
                                        </div>
                                        <div class="card-body p-4">
                                            <div class="row g-4 align-items-center">
                                                <div class="col-md-3">
                                                    <label class="form-label-premium">Frequency (Paragraphs)</label>
                                                    <input type="number" class="form-control" name="ad_in_article_frequency" value="{{ $settings['ad_in_article_frequency'] ?? '3' }}" min="1">
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label-premium">Max Units Per Post</label>
                                                    <input type="number" class="form-control" name="ad_in_article_max" value="{{ $settings['ad_in_article_max'] ?? '5' }}" min="1">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label-premium">In-Article Ad Code (HTML/JS)</label>
                                                    <textarea class="form-control font-monospace" name="ad_in_article_script" rows="2">{{ $settings['ad_in_article_script'] ?? '' }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Adsterra Grid -->
                                <div class="col-12">
                                    <div class="card card-premium-dark border-info">
                                        <div class="card-header-premium border-info d-flex justify-content-between align-items-center bg-info-soft">
                                            <span class="text-info font-black tracking-widest"><i class="fa fa-bolt me-2"></i>ADSTERRA FULL STACK</span>
                                            <div class="form-check form-switch m-0">
                                                <input type="hidden" name="adsterra_active" value="0">
                                                <input class="form-check-input" type="checkbox" name="adsterra_active" value="1" id="adst_act" {{ ($settings['adsterra_active'] ?? '') == '1' ? 'checked' : '' }}>
                                            </div>
                                        </div>
                                        <div class="card-body p-4">
                                            <div class="row g-4">
                                                <div class="col-md-6 col-lg-4">
                                                    <div class="p-3 bg-dark-soft rounded border border-secondary h-100">
                                                        <label class="ad-unit-label"><span class="badge bg-success mb-1">BEST</span> Popunder</label>
                                                        <textarea class="form-control-unit" name="adsterra_popunder_script" placeholder="<script>...">{{ $settings['adsterra_popunder_script'] ?? $settings['adsterra_pop_script'] ?? '' }}</textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-lg-4">
                                                    <div class="p-3 bg-dark-soft rounded border border-secondary h-100">
                                                        <label class="ad-unit-label">Social Bar</label>
                                                        <textarea class="form-control-unit" name="adsterra_social_bar_script" placeholder="<script>...">{{ $settings['adsterra_social_bar_script'] ?? $settings['adsterra_social_script'] ?? '' }}</textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-lg-4">
                                                    <div class="p-3 bg-dark-soft rounded border border-secondary h-100">
                                                        <label class="ad-unit-label">Leaderboard 728x90</label>
                                                        <textarea class="form-control-unit" name="adsterra_banner_728x90_script" placeholder="<script>...">{{ $settings['adsterra_banner_728x90_script'] ?? '' }}</textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-lg-4">
                                                    <div class="p-3 bg-dark-soft rounded border border-secondary h-100">
                                                        <label class="ad-unit-label">Sidebar 300x250</label>
                                                        <textarea class="form-control-unit" name="adsterra_banner_300x250_script" placeholder="<script>...">{{ $settings['adsterra_banner_300x250_script'] ?? '' }}</textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-lg-4">
                                                    <div class="p-3 bg-dark-soft rounded border border-secondary h-100">
                                                        <label class="ad-unit-label">Native Banner</label>
                                                        <textarea class="form-control-unit" name="adsterra_native_banner_script" placeholder="<script>...">{{ $settings['adsterra_native_banner_script'] ?? '' }}</textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-lg-4">
                                                    <div class="p-3 bg-dark-soft rounded border border-secondary h-100">
                                                        <label class="ad-unit-label text-info">Smartlink URL</label>
                                                        <input type="url" class="form-control bg-dark border-secondary text-info p-2" name="adsterra_smartlink_url" value="{{ $settings['adsterra_smartlink_url'] ?? '' }}" placeholder="https://alclk.com/...">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- TAB 4: Communication -->
                        <div class="tab-pane fade" id="comm" role="tabpanel">
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="card card-premium h-100">
                                        <div class="card-header-premium"><i class="fa fa-share-alt text-primary"></i> Social Links</div>
                                        <div class="card-body p-4">
                                            @php
                                                $socials = [
                                                    'facebook' => 'Facebook URL',
                                                    'twitter' => 'Twitter / X URL',
                                                    'instagram' => 'Instagram URL',
                                                    'youtube' => 'YouTube URL'
                                                ];
                                            @endphp
                                            @foreach($socials as $key => $label)
                                            <div class="mb-3">
                                                <label class="form-label-premium">{{ $label }}</label>
                                                <div class="input-group">
                                                    <span class="input-group-text bg-dark border-secondary text-white-50"><i class="fab fa-{{ $key }}"></i></span>
                                                    <input type="text" class="form-control" name="social_{{ $key }}" value="{{ $settings['social_'.$key] ?? '' }}">
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card card-premium h-100">
                                        <div class="card-header-premium"><i class="fa fa-envelope text-primary"></i> SMTP Configuration</div>
                                        <div class="card-body p-4">
                                            <div class="row g-3">
                                                <div class="col-md-9 mb-3">
                                                    <label class="form-label-premium">SMTP Host</label>
                                                    <input type="text" class="form-control" name="mail_host" value="{{ $settings['mail_host'] ?? '' }}" placeholder="smtp.gmail.com">
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <label class="form-label-premium">Port</label>
                                                    <input type="text" class="form-control" name="mail_port" value="{{ $settings['mail_port'] ?? '587' }}">
                                                </div>
                                                <div class="col-12 mb-3">
                                                    <label class="form-label-premium">Username</label>
                                                    <input type="text" class="form-control" name="mail_username" value="{{ $settings['mail_username'] ?? '' }}">
                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label-premium">Password</label>
                                                    <input type="password" class="form-control" name="mail_password" value="{{ $settings['mail_password'] ?? '' }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="card card-premium">
                                        <div class="card-header-premium"><i class="fa fa-map-marker-alt text-primary"></i> Contact Information</div>
                                        <div class="card-body p-4">
                                            <div class="row g-4">
                                                <div class="col-md-4">
                                                    <label class="form-label-premium">Public Support Email</label>
                                                    <input type="email" class="form-control" name="contact_email" value="{{ $settings['contact_email'] ?? '' }}">
                                                </div>
                                                <div class="col-md-8">
                                                    <label class="form-label-premium">Full Office Address</label>
                                                    <textarea class="form-control" name="contact_address" rows="1">{{ $settings['contact_address'] ?? '' }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- TAB 5: System -->
                        <div class="tab-pane fade" id="system" role="tabpanel">
                            <div class="row g-4 justify-content-center">
                                <div class="col-lg-6">
                                    <div class="card card-premium border-danger">
                                        <div class="card-header-premium border-danger text-danger">
                                            <i class="fa fa-tools me-2"></i> EMERGENCY MAINTENANCE
                                        </div>
                                        <div class="card-body p-5 text-center">
                                            <i class="fa fa-exclamation-triangle text-danger fa-4x mb-4"></i>
                                            <div class="form-check form-switch d-inline-block mb-4 h4">
                                                <input type="hidden" name="maintenance_mode" value="0">
                                                <input class="form-check-input" style="width: 3.5rem; height: 1.75rem" type="checkbox" name="maintenance_mode" value="1" id="maint_mode" {{ ($settings['maintenance_mode'] ?? '0') == '1' ? 'checked' : '' }}>
                                                <label class="form-check-label ms-3 text-white" for="maint_mode">Enable Maintenance Mode</label>
                                            </div>
                                            <div class="mb-0 text-start">
                                                <label class="form-label-premium text-center d-block">Public Message for Visitors</label>
                                                <textarea class="form-control bg-dark border-danger text-danger text-center" name="maintenance_message" rows="3">{{ $settings['maintenance_message'] ?? 'Site is currently under maintenance. We will be back shortly.' }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modern Action Bar (Non-Fixed to avoid overlap) -->
                    <div class="settings-action-panel mt-5">
                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-4 p-4 rounded-4 shadow-lg border border-primary bg-dark-soft">
                            <div class="text-white-50 small order-2 order-md-1">
                                <i class="fa fa-shield-alt text-success me-2"></i> All changes are encrypted & secured
                            </div>
                            <button type="submit" class="btn btn-save-premium px-5 py-3 rounded-pill shadow-lg order-1 order-md-2 w-100 w-md-auto">
                                <i class="fa fa-save me-2 pulse"></i> SAVE CONFIGURATION
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    /* Premium Theme Utilities */
    :root {
        --primary: #0d6efd;
        --secondary: #191c24;
        --dark-soft: #11141b;
        --accent-gold: d4af37;
    }

    .bg-secondary { background-color: #191c24 !important; }
    .bg-dark-soft { background-color: #0f1218; }
    .no-scrollbar::-webkit-scrollbar { display: none; }
    .tracking-widest { letter-spacing: 0.15em; }
    .font-black { font-weight: 900; }

    /* Card Styling */
    .card-premium {
        background-color: #0f1218;
        border: 1px solid #2a2d34;
        border-radius: 12px;
        overflow: hidden;
        transition: transform 0.3s;
    }
    .card-premium-dark {
        background-color: #080a0f;
        border: 1px solid #1a1d23;
        border-radius: 12px;
        overflow: hidden;
    }
    .card-header-premium {
        background: rgba(255,255,255,0.02);
        padding: 15px 20px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-size: 0.75rem;
        border-bottom: 1px solid rgba(255,255,255,0.05);
        color: #eee;
    }
    .bg-info-soft { background: rgba(13,202,240,0.05); }

    /* Form Labels */
    .form-label-premium {
        font-size: 0.65rem;
        font-weight: 800;
        text-transform: uppercase;
        color: #6c757d;
        letter-spacing: 1.5px;
        margin-bottom: 8px;
    }
    .ad-unit-label {
        font-size: 0.6rem;
        font-weight: 900;
        text-transform: uppercase;
        color: #999;
        display: block;
        margin-bottom: 10px;
        letter-spacing: 1px;
    }

    /* Form Controls */
    .form-control, .form-select {
        background-color: #080a0f !important;
        border: 1px solid #2a2d34 !important;
        color: #fff !important;
        border-radius: 8px;
        padding: 10px 15px;
        font-size: 0.9rem;
        transition: all 0.2s;
    }
    .form-control:focus {
        border-color: #0d6efd !important;
        box-shadow: 0 0 0 4px rgba(13,110,253,0.1) !important;
    }
    .form-control-unit {
        background: #000 !important;
        border: 1px solid #1a1d23 !important;
        color: #00ff00 !important;
        font-family: 'Courier New', monospace;
        font-size: 0.75rem;
        width: 100%;
        border-radius: 6px;
        padding: 10px;
        min-height: 80px;
    }
    .h-textarea-fixed { min-height: 100px; }

    /* Professional Navigation */
    .nav-pills .nav-link {
        background: transparent;
        color: #6c757d;
        font-weight: 800;
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        padding: 12px 24px;
        border-radius: 50px;
        margin-right: 10px;
        transition: all 0.3s;
        border: 1px solid transparent;
        white-space: nowrap;
    }
    .nav-pills .nav-link:hover {
        background: rgba(255,255,255,0.03);
        color: #fff;
    }
    .nav-pills .nav-link.active {
        background: #0d6efd !important;
        color: #fff !important;
        box-shadow: 0 4px 20px rgba(13,110,253,0.3);
    }

    /* Layout Preview Boxes */
    .logo-preview-box {
        width: 100%;
        max-width: 200px;
        height: 100px;
        background: #000;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px dashed #333;
    }
    .favicon-preview-box {
        width: 64px;
        height: 64px;
        background: #000;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px dashed #333;
    }

    /* Action Panel Styling (Non-Fixed) */
    .settings-action-panel {
        position: relative;
        z-index: 10;
    }
    .bg-dark-soft { background-color: #0c0e12; }
    .rounded-4 { border-radius: 1.5rem !important; }
    
    /* Responsive Fix for Sidebar Toggled */
    @media (max-width: 991.98px) {
        .settings-action-bar { left: 0; }
        .nav-pills .nav-link { padding: 10px 18px; font-size: 0.65rem; }
    }

    .btn-save-premium {
        background: linear-gradient(135deg, #0d6efd 0%, #0046b3 100%);
        border: none;
        color: white;
        font-weight: 900;
        letter-spacing: 2px;
        font-size: 0.8rem;
        transition: all 0.3s;
    }
    .btn-save-premium:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(13,110,253,0.4);
        color: #fff;
    }
    .btn-save-premium:active { transform: translateY(0); }

    /* Animations */
    .pulse { animation: pulse-ring 2s cubic-bezier(0.4, 0, 0.6, 1) infinite; }
    @keyframes pulse-ring { 
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }
    .animate-pulse-slow { animation: pulse 2s infinite; }
</style>

@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Tab switching persistence or smooth scroll if needed
        $('button[data-bs-toggle="pill"]').on('shown.bs.tab', function (e) {
            // Optional: scroll top or log active tab
        });
    });
</script>
@endpush