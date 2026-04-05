@extends('layouts.admin')

@section('header', isset($article) ? __('articles.edit') : __('articles.create'))

@section('content')
    <div class="container-fluid pt-4 px-4">
        <form action="{{ isset($article) ? route('admin.articles.update', $article->id) : route('admin.articles.store') }}"
            method="POST" enctype="multipart/form-data">
            @csrf
            @if(isset($article))
                @method('PUT')
            @endif

            <div class="row g-4">
                <!-- Left Column: Main Content -->
                <div class="col-sm-12 col-xl-8">
                    <div class="bg-secondary rounded p-4">
                        <h6 class="mb-4">{{ __('articles.form_title') }}</h6>

                        <!-- Title -->
                        <div class="mb-3">
                            <label class="form-label">{{ __('articles.title_label') }} <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="title" value="{{ old('title', $article->title ?? '') }}"
                                class="form-control" placeholder="{{ __('articles.title_label') }}" required>
                            @error('title') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <!-- Content Editor -->
                        <div class="mb-3">
                            <label class="form-label">{{ __('articles.content') }} <span
                                    class="text-danger">*</span></label>
                            <textarea name="content" id="editor" class="form-control"
                                rows="10">{{ old('content', $article->content ?? '') }}</textarea>
                            @error('content') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <!-- Excerpt -->
                        <div class="mb-3">
                            <label class="form-label">{{ __('articles.excerpt') }}</label>
                            <textarea name="excerpt" class="form-control" rows="3"
                                placeholder="...">{{ old('excerpt', $article->excerpt ?? '') }}</textarea>
                        </div>

                        <!-- Tags -->
                        <div class="mb-3">
                            <label class="form-label">Tags (Comma separated)</label>
                            <input type="text" name="tags"
                                value="{{ old('tags', isset($article) ? $article->tags->pluck('name')->implode(', ') : '') }}"
                                class="form-control" placeholder="Technology, Laravel, Tutorial">
                            <div class="form-text">Separate tags with commas.</div>
                        </div>
                    </div>

                    <!-- SEO Section -->
                    <div class="bg-secondary rounded p-4 mt-4">
                        <h6 class="mb-4">{{ __('articles.seo_settings') }}</h6>
                        <div class="mb-3">
                            <label class="form-label">Meta Title</label>
                            <input type="text" name="meta_title" value="{{ old('meta_title', $article->meta_title ?? '') }}"
                                class="form-control" placeholder="Custom SEO Title">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Meta Description</label>
                            <textarea name="meta_description" class="form-control"
                                rows="2">{{ old('meta_description', $article->meta_description ?? '') }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Keywords</label>
                            <input type="text" name="keywords" value="{{ old('keywords', $article->keywords ?? '') }}"
                                class="form-control" placeholder="tech, tutorial, laravel">
                        </div>
                    </div>
                </div>

                <!-- Right Column: Settings -->
                <div class="col-sm-12 col-xl-4">
                    <div class="bg-secondary rounded p-4 mb-4">
                        <h6 class="mb-4">{{ __('articles.publishing') }}</h6>

                        <!-- Category -->
                        <div class="mb-3">
                            <label class="form-label">{{ __('articles.category') }} <span
                                    class="text-danger">*</span></label>
                            <select class="form-select" name="category_id" required>
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $article->category_id ?? '') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <!-- Status -->
                        <div class="mb-3">
                            <label class="form-label">{{ __('articles.status') }}</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="statusDraft" value="draft" {{ old('status', $article->status ?? 'draft') == 'draft' ? 'checked' : '' }}>
                                <label class="form-check-label" for="statusDraft">{{ __('articles.draft') }}</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="statusPublished"
                                    value="published" {{ old('status', $article->status ?? '') == 'published' ? 'checked' : '' }}>
                                <label class="form-check-label" for="statusPublished">{{ __('articles.published') }}</label>
                            </div>

                            <!-- Manual Date Input -->
                            <div class="mt-2 ms-4" id="publishedDateContainer">
                                <label class="form-label small text-muted">Publish Date (Leave empty for immediate)</label>
                                <div class="input-group date" id="publishedAtPicker" data-target-input="nearest">
                                    <input type="text" class="form-control datetimepicker-input bg-dark"
                                        data-target="#publishedAtPicker" name="published_at"
                                        value="{{ old('published_at', isset($article) && $article->published_at ? $article->published_at->format('Y-m-d H:i') : '') }}"
                                        placeholder="YYYY-MM-DD HH:mm" />
                                    <div class="input-group-append" data-target="#publishedAtPicker"
                                        data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-check mt-2">
                                <input class="form-check-input" type="radio" name="status" id="statusArchived"
                                    value="archived" {{ old('status', $article->status ?? '') == 'archived' ? 'checked' : '' }}>
                                <label class="form-check-label" for="statusArchived">{{ __('articles.archived') }}</label>
                            </div>
                        </div>

                        @if(auth()->user()->role === 1)
                            <div class="mb-3">
                                <label class="form-label">{{ __('articles.visibility') }}</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="is_featured" id="isFeatured" {{ old('is_featured', $article->is_featured ?? false) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="isFeatured">{{ __('articles.featured') }}</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="is_trending" id="isTrending" {{ old('is_trending', $article->is_trending ?? false) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="isTrending">{{ __('articles.trending') }}</label>
                                </div>
                            </div>
                        @endif

                        <div class="d-grid gap-2">
                            <button type="submit"
                                class="btn btn-primary">{{ isset($article) ? __('common.save') : __('articles.create') }}</button>
                            <a href="{{ route('admin.articles.index') }}"
                                class="btn btn-outline-light">{{ __('common.cancel') }}</a>
                        </div>
                    </div>

                    <!-- Featured Image -->
                    <div class="bg-secondary rounded p-4">
                        <h6 class="mb-4">{{ __('articles.featured_image') }}</h6>
                        <div class="mb-3 text-center">
                            @if(isset($article) && $article->featured_image)
                                <img id="image-preview" src="{{ asset('storage/' . $article->featured_image) }}"
                                    class="img-fluid rounded mb-2" style="max-height: 200px;">
                            @else
                                <img id="image-preview" src="" class="img-fluid rounded mb-2 d-none" style="max-height: 200px;">
                            @endif
                        </div>
                        <div class="mb-3">
                            <input class="form-control bg-dark" type="file" name="featured_image" id="featured_image_input"
                                accept="image/*">
                            <div class="form-text">JPG, PNG, GIF</div>
                        </div>
                        <script>
                            document.getElementById('featured_image_input').addEventListener('change', function (event) {
                                const file = event.target.files[0];
                                if (file) {
                                    const reader = new FileReader();
                                    reader.onload = function (e) {
                                        const preview = document.getElementById('image-preview');
                                        preview.src = e.target.result;
                                        preview.classList.remove('d-none');
                                    }
                                    reader.readAsDataURL(file);
                                }
                            });
                        </script>
                    </div>
                </div>
            </div>
        </form>

    <!-- Script TinyMCE Self-Hosted (Lokal) untuk menjamin tidak terblokir -->
    <script src="{{ asset('js/tinymce/tinymce.min.js') }}" referrerpolicy="origin"></script>
    <script>
        console.log('Mencoba memuat TinyMCE Lokal...');
        
        window.onload = function() {
            if (typeof tinymce === 'undefined') {
                console.error('TINYMCE LOKAL GAGAL DIMUAT! Pastikan file ada di /public/js/tinymce/');
                return;
            }

            tinymce.init({
                selector: '#editor',
                height: 500,
                // Menggunakan folder lokal agar skin/ikon dimuat dari server sendiri
                base_url: '{{ asset("js/tinymce") }}',
                license_key: 'gpl',
                menubar: false,
                promotion: false,
                branding: false,
                plugins: 'preview importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media codesample table charmap pagebreak nonbreaking anchor insertdatetime advlist lists wordcount help charmap quickbars emoticons',
                toolbar: 'undo redo | bold italic underline strikethrough | blocks fontfamily fontsize | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen preview save | insertfile image media link anchor codesample',
                
                skin: 'oxide-dark',
                content_css: 'dark',
                content_style: 'body { font-family: "Open Sans", sans-serif; background-color: #191C24; color: #6C7293; font-size: 14px; }',

                images_upload_handler: (blobInfo, progress) => new Promise((resolve, reject) => {
                    const formData = new FormData();
                    formData.append('upload', blobInfo.blob(), blobInfo.filename());
                    fetch('{{ route('admin.articles.upload-image') }}', {
                        method: 'POST',
                        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(json => {
                        if (json && json.url) resolve(json.url);
                        else reject('Invalid response');
                    })
                    .catch(err => reject('Upload fail: ' + err.message));
                })
            });
        };
    </script>
@endsection