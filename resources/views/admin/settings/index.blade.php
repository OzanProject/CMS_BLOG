@extends('layouts.admin')

@section('header', __('settings.title'))

@section('content')
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-12">
                <div class="bg-secondary rounded p-4 shadow-sm">
                    <h5 class="mb-4 text-white"><i class="fa fa-cog me-2"></i>{{ __('settings.title') }}</h5>

                    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Horizontal Tabs Navigation -->
                        <ul class="nav nav-pills mb-4 border-bottom border-dark pb-3" id="settingsTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active me-2" id="general-tab" data-bs-toggle="pill" data-bs-target="#general" type="button" role="tab"><i class="fa fa-info-circle me-2"></i>General</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link me-2" id="seo-tab" data-bs-toggle="pill" data-bs-target="#seo" type="button" role="tab"><i class="fa fa-search me-2"></i>SEO & Analytics</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link me-2 text-warning" id="monetization-tab" data-bs-toggle="pill" data-bs-target="#monetization" type="button" role="tab"><i class="fa fa-dollar me-2"></i>Monetization</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link me-2" id="comm-tab" data-bs-toggle="pill" data-bs-target="#comm" type="button" role="tab"><i class="fa fa-share-alt me-2"></i>Communication</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link me-2" id="system-tab" data-bs-toggle="pill" data-bs-target="#system" type="button" role="tab"><i class="fa fa-server me-2"></i>System</button>
                            </li>
                        </ul>

                        <!-- Tab Content -->
                        <div class="tab-content border-0 p-0" id="settingsTabsContent">
                            
                            <!-- TAB 1: General -->
                            <div class="tab-pane fade show active" id="general" role="tabpanel">
                                <div class="row g-4">
                                    <div class="col-md-8">
                                        <div class="card bg-dark border-0 shadow-sm p-4 mb-4">
                                            <h6 class="mb-4 text-primary border-bottom border-secondary pb-2">Site Information</h6>
                                            <div class="row g-3">
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label text-white-50 small">{{ __('settings.site_name') }}</label>
                                                    <input type="text" class="form-control" name="site_name" value="{{ $settings['site_name'] ?? '' }}">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label text-white-50 small">Copyright Text</label>
                                                    <input type="text" class="form-control" name="site_copyright" value="{{ $settings['site_copyright'] ?? '' }}">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label text-white-50 small">Active Theme</label>
                                                    <select class="form-select bg-secondary text-white" name="active_theme">
                                                        @foreach($themes as $theme)
                                                            <option value="{{ $theme->id }}" {{ $theme->is_active ? 'selected' : '' }}>{{ $theme->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label text-white-50 small">{{ __('settings.site_description') }}</label>
                                                    <textarea class="form-control" name="site_description" rows="3">{{ $settings['site_description'] ?? '' }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card bg-dark border-0 shadow-sm p-4 h-100">
                                            <h6 class="mb-4 text-primary border-bottom border-secondary pb-2">Branding</h6>
                                            <div class="mb-4 text-center p-3 bg-secondary rounded">
                                                <label class="form-label d-block text-white mb-3">Site Logo</label>
                                                @if(isset($settings['site_logo']))
                                                    <img src="{{ asset('storage/' . $settings['site_logo']) }}" alt="Logo" class="img-fluid mb-3" style="max-height: 40px;">
                                                @endif
                                                <input class="form-control form-control-sm bg-dark" type="file" name="site_logo">
                                            </div>
                                            <div class="text-center p-3 bg-secondary rounded">
                                                <label class="form-label d-block text-white mb-3">Favicon</label>
                                                @if(isset($settings['site_favicon']))
                                                    <img src="{{ asset('storage/' . $settings['site_favicon']) }}" alt="Favicon" class="img-fluid mb-3" style="max-height: 32px;">
                                                @endif
                                                <input class="form-control form-control-sm bg-dark" type="file" name="site_favicon">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- TAB 2: SEO -->
                            <div class="tab-pane fade" id="seo" role="tabpanel">
                                <div class="card bg-dark border-0 shadow-sm p-4 mb-4">
                                    <h6 class="mb-4 text-primary border-bottom border-secondary pb-2">SEO & Analytics</h6>
                                    <div class="row g-4">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label text-white-50 small">Google Analytics / GTM ID</label>
                                            <input type="text" class="form-control" name="google_analytics_id" value="{{ $settings['google_analytics_id'] ?? '' }}" placeholder="G-XXXXXXXX">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label text-white-50 small">Search Console Verification</label>
                                            <input type="text" class="form-control" name="google_verification_code" value="{{ $settings['google_verification_code'] ?? '' }}">
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label text-white-50 small">Ads.txt Content</label>
                                            <textarea class="form-control font-monospace" name="ads_txt_content" rows="8">{{ $settings['ads_txt_content'] ?? '' }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- TAB 3: Monetization -->
                            <div class="tab-pane fade" id="monetization" role="tabpanel">
                                <div class="row g-4 text-white">
                                    <div class="col-md-6">
                                        <div class="p-4 border border-primary rounded bg-dark h-100">
                                            <h5 class="h6 mb-3 text-primary border-bottom border-primary pb-2"><i class="fa fa-google me-2"></i>Google AdSense</h5>
                                            <div class="form-check form-switch mb-4">
                                                <input type="hidden" name="adsense_active" value="0">
                                                <input class="form-check-input" type="checkbox" name="adsense_active" value="1" id="ads_act" {{ ($settings['adsense_active'] ?? '') == '1' ? 'checked' : '' }}>
                                                <label class="form-check-label ms-2" for="ads_act">Status AdSense</label>
                                            </div>
                                            <div class="mb-4">
                                                <label class="form-label small text-white-50">Publisher ID</label>
                                                <input type="text" class="form-control bg-secondary border-0" name="adsense_client_id" value="{{ $settings['adsense_client_id'] ?? '' }}" placeholder="ca-pub-XXXXXXXX">
                                            </div>
                                            <div class="form-check form-switch mb-3">
                                                <input type="hidden" name="adsense_auto_ads" value="0">
                                                <input class="form-check-input" type="checkbox" name="adsense_auto_ads" value="1" id="auto_ads" {{ ($settings['adsense_auto_ads'] ?? '') == '1' ? 'checked' : '' }}>
                                                <label class="form-check-label ms-2" for="auto_ads">Auto Ads (Header Injection)</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="p-4 border border-info rounded bg-dark h-100">
                                            <h5 class="h6 mb-3 text-info border-bottom border-info pb-2"><i class="fa fa-bolt me-2"></i>Adsterra</h5>
                                            <div class="form-check form-switch mb-4">
                                                <input type="hidden" name="adsterra_active" value="0">
                                                <input class="form-check-input" type="checkbox" name="adsterra_active" value="1" id="adst_act" {{ ($settings['adsterra_active'] ?? '') == '1' ? 'checked' : '' }}>
                                                <label class="form-check-label ms-2" for="adst_act">Status Adsterra</label>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label small text-white-50">Pop-under Script</label>
                                                <textarea class="form-control bg-secondary border-0 font-monospace" name="adsterra_pop_script" rows="2">{{ $settings['adsterra_pop_script'] ?? '' }}</textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label small text-white-50">Social Bar Script</label>
                                                <textarea class="form-control bg-secondary border-0 font-monospace" name="adsterra_social_script" rows="2">{{ $settings['adsterra_social_script'] ?? '' }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="p-4 bg-dark rounded border border-warning">
                                            <h5 class="h6 mb-4 text-warning"><i class="fa fa-newspaper-o me-2"></i>In-Article Ad Density Configuration</h5>
                                            <div class="row g-4">
                                                <div class="col-md-4">
                                                    <div class="form-check form-switch pt-2">
                                                        <input type="hidden" name="ad_in_article_active" value="0">
                                                        <input class="form-check-input" type="checkbox" name="ad_in_article_active" value="1" id="in_art_act" {{ ($settings['ad_in_article_active'] ?? '') == '1' ? 'checked' : '' }}>
                                                        <label class="form-check-label ms-2" for="in_art_act">Enable In-Article Ads</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label small text-white-50">Frequency (Every X Paragraphs)</label>
                                                    <input type="number" class="form-control bg-secondary border-0 text-white" name="ad_in_article_frequency" value="{{ $settings['ad_in_article_frequency'] ?? '3' }}" min="1">
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label small text-white-50">Max Ads Per Article</label>
                                                    <input type="number" class="form-control bg-secondary border-0 text-white" name="ad_in_article_max" value="{{ $settings['ad_in_article_max'] ?? '5' }}" min="1">
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
                                        <div class="card bg-dark border-0 shadow-sm p-4 mb-4">
                                            <h6 class="mb-4 text-primary border-bottom border-secondary pb-2">Social Media Platform</h6>
                                            <div class="row g-3">
                                                @php
                                                    $socials = [
                                                        'Facebook' => 'social_facebook',
                                                        'Twitter' => 'social_twitter',
                                                        'Instagram' => 'social_instagram',
                                                        'YouTube' => 'social_youtube'
                                                    ];
                                                @endphp
                                                @foreach($socials as $label => $key)
                                                <div class="col-12 mb-2">
                                                    <label class="form-label text-white-50 small">{{ $label }} URL</label>
                                                    <input type="text" class="form-control" name="{{ $key }}" value="{{ $settings[$key] ?? '' }}">
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card bg-dark border-0 shadow-sm p-4 h-100">
                                            <h6 class="mb-4 text-primary border-bottom border-secondary pb-2">Contact & About</h6>
                                            <div class="mb-3">
                                                <label class="form-label text-white-50 small">Email Address</label>
                                                <input type="email" class="form-control" name="contact_email" value="{{ $settings['contact_email'] ?? '' }}">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label text-white-50 small">Phone / WhatsApp</label>
                                                <input type="text" class="form-control" name="contact_phone" value="{{ $settings['contact_phone'] ?? '' }}">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label text-white-50 small">Physical Address</label>
                                                <textarea class="form-control" name="contact_address" rows="2">{{ $settings['contact_address'] ?? '' }}</textarea>
                                            </div>
                                            <div class="mb-0">
                                                <label class="form-label text-white-50 small">Short About Us Text</label>
                                                <textarea class="form-control" name="about_text" rows="3">{{ $settings['about_text'] ?? '' }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- TAB 5: System -->
                            <div class="tab-pane fade" id="system" role="tabpanel">
                                <div class="row g-4">
                                    <div class="col-md-8">
                                        <div class="card bg-dark border-0 shadow-sm p-4 mb-4">
                                            <h6 class="mb-4 text-primary border-bottom border-secondary pb-2">SMTP Configuration</h6>
                                            <div class="row g-3">
                                                <div class="col-md-8 mb-3">
                                                    <label class="form-label text-white-50 small">SMTP Host</label>
                                                    <input type="text" class="form-control" name="mail_host" value="{{ $settings['mail_host'] ?? '' }}">
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label class="form-label text-white-50 small">Port</label>
                                                    <input type="text" class="form-control" name="mail_port" value="{{ $settings['mail_port'] ?? '587' }}">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label text-white-50 small">Username</label>
                                                    <input type="text" class="form-control" name="mail_username" value="{{ $settings['mail_username'] ?? '' }}">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label text-white-50 small">Password</label>
                                                    <input type="password" class="form-control" name="mail_password" value="{{ $settings['mail_password'] ?? '' }}">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label text-white-50 small">From Address</label>
                                                    <input type="text" class="form-control" name="mail_from_address" value="{{ $settings['mail_from_address'] ?? '' }}">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label text-white-50 small">From Name</label>
                                                    <input type="text" class="form-control" name="mail_from_name" value="{{ $settings['mail_from_name'] ?? '' }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card bg-dark border-0 shadow-sm p-4 h-100">
                                            <h6 class="mb-4 text-danger border-bottom border-danger pb-2">Maintenance Mode</h6>
                                            <div class="form-check form-switch mb-4 mt-2">
                                                <input type="hidden" name="maintenance_mode" value="0">
                                                <input class="form-check-input" type="checkbox" name="maintenance_mode" value="1" id="maint_mode" {{ ($settings['maintenance_mode'] ?? '0') == '1' ? 'checked' : '' }}>
                                                <label class="form-check-label ms-2 text-white" for="maint_mode">Active Maintenance</label>
                                            </div>
                                            <div class="mb-0">
                                                <label class="form-label text-white-50 small">Maintenance Message</label>
                                                <textarea class="form-control" name="maintenance_message" rows="4">{{ $settings['maintenance_message'] ?? '' }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- end first row -->

                                <!-- Second Row: Editor Configuration -->
                                <div class="row g-4 mt-2">
                                    <div class="col-md-6">
                                        <div class="card bg-dark border-0 shadow-sm p-4">
                                            <h6 class="mb-4 text-primary border-bottom border-secondary pb-2"><i class="fa fa-pencil me-2"></i>Editor Configuration</h6>
                                            <div class="mb-3">
                                                <label class="form-label text-white-50 small">TinyMCE Cloud API Key</label>
                                                <input type="text" class="form-control" name="tinymce_api_key" value="{{ $settings['tinymce_api_key'] ?? '' }}" placeholder="no-api-key">
                                                <div class="form-text small text-muted mt-2">Dapatkan kunci di <a href="https://www.tiny.cloud/" target="_blank" class="text-info">tiny.cloud</a>. Gunakan <code>no-api-key</code> untuk pengujian.</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- Sticky Footer for Save Button -->
                        <div class="mt-5 pt-3 border-top border-dark d-flex justify-content-between align-items-center">
                            <span class="text-white-50 small"><i class="fa fa-info-circle me-1"></i>Last updated: {{ Carbon\Carbon::now()->translatedFormat('d M Y, H:i') }}</span>
                            <button type="submit" class="btn btn-primary px-5 py-2 shadow-sm font-weight-bold">
                                <i class="fa fa-save me-2"></i>SAVE ALL CONFIGURATION
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        .nav-pills .nav-link {
            color: #adb5bd;
            font-weight: 500;
            padding: 10px 20px;
            border-radius: 8px;
            transition: all 0.3s;
        }
        .nav-pills .nav-link:hover {
            color: #fff;
            background-color: rgba(255,255,255,0.05);
        }
        .nav-pills .nav-link.active {
            background-color: #0d6efd;
            color: #fff !important;
            box-shadow: 0 4px 15px rgba(13, 110, 253, 0.3);
        }
        .form-control, .form-select {
            background-color: #191c24 !important;
            border: 1px solid #2c2f33;
            color: #fff !important;
            padding: 10px 15px;
            border-radius: 8px;
        }
        .form-control:focus, .form-select:focus {
            background-color: #191c24 !important;
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.1);
        }
        .card {
            border-radius: 12px;
        }
        .form-check-input:checked {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }
        .text-primary { color: #0d6efd !important; }
        .bg-secondary { background-color: #191c24 !important; }
    </style>
@endsection